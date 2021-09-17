#
# This script contains all the variables, functions, methods and classes required
# to send the bluetooth commands to the Anki cars
# Author: jstucken
#

# jstuckens HARDCODED MAC ADDRESSES for convenience sake (copy and pasting)
# Can be safely ignored
#car1_mac = "DE:FD:79:49:7B:8E"
#car2_mac = "CF:F4:51:BD:54:A0"
#car3_mac = "D1:D4:89:16:9D:50"
#car4_mac = "FB:60:5B:2C:9A:A2"
#car5_mac = "C1:55:C8:25:66:5C"
#car6_mac = "E5:07:18:3D:D2:84"
#car7_mac = "FA:CD:02:A0:53:BD"
#car8_mac = "DD:45:84:88:23:8E"
#car9_mac = "D8:08:DD:FA:7C:57"
#car10_mac = "D6:53:F9:B5:83:56"
#car11_mac = "F4:3F:E7:5C:43:03"
#car12_mac = "E8:8B:C7:FC:35:B7"
#car13_mac = "F2:25:3D:75:25:50" # truck
#andrews_truck = "FC:AC:A7:D7:80:7C"


import __main__ as globals
from datetime import datetime
import struct
import threading
import queue
import logging
import bluepy.btle as btle
import argparse
import banner
import requests
#import socket
import random
from network import Network
from php_communicator import PhpCommunicator
import getpass


# Display welcome banner to user
banner.displayBanner(globals.SCRIPT_TITLE)

# parse user supplied input
parser = argparse.ArgumentParser()
parser.add_argument("--car_mac", help="Bluetooth MAC address of the Anki car", default="Not set")
parser.add_argument("--student_name", help="Friendly student name of the person controlling the car e.g. Bill", default="Unknown")
#parser.add_argument("--controller", help="Enter which xbox contoroller to use 0-3)", default="0")




# Outside callback function which repeatedly prints out updated location data etc into main script window
# This is called from within the Overdrive class below.
def locationChangeCallback(car_mac, location, piece, offset, speed, clockwise, show_location_data=True):
    # Print out car_mac, piece ID, location ID of the vehicle, this print everytime when location changed
    
    # only print to screen if not disabled
    if show_location_data is True:
        print("DATA FROM CAR ("+car_mac+"):   Speed="+str(speed)+"   Piece="+str(piece)+"   Location="+str(location)+"  Clockwise="+str(clockwise)+"   Offset: "+str(offset))
        #print("non str offset: ")
        #print(offset)


    
# BEGIN OUR OVERDRIVE CLASS
class Overdrive:
    def __init__(self, CAR_NUMBER=999999):
        """Initiate an Anki Overdrive connection object,
        and call connect() function.

        Parameters:
        car_mac -- Bluetooth MAC address for desired Anki Overdrive car.
        """
        self.CAR_NUMBER = CAR_NUMBER
		
        # get the local IP address of this machine
        self.local_ip_address = Network.getLocalIPAddress()
        
        # save any manually supplied user parameters eg --car_mac and --manual_student_name
        self.saveManualParameters()
        
        # Set the MAC address of the car to control
        self._setMacAddress()
        
        # now get the confirmed car_id which matches to cars table in DB
        self._setCarId(self.car_mac)
        
		
        self._peripheral = btle.Peripheral()
        self._readChar = None
        self._writeChar = None
        self._connected = False
        self._reconnect = False
        self._delegate = OverdriveDelegate(self)
        self._writeQueue = queue.Queue()
        self._btleSubThread = None
        
        # FOR TRACKING speed, location, lane offset etc
        self.speed = 0
        self.location = 0
        self.piece = 0
        self.instructed_offset = float(99)   # The offset we WANT to have, not the actual offset from car
        self.setOffset(0)
        self.offset_change_amount = 30      # how much car should turn each increment
        self.clockwise = 0
        self.lap_count = 0      # count how many laps completed
        self.prev_lap_time = datetime.now()       # time each lap completed
        self.prev_lap_time_difference = 0       # time each lap completed
        
        self._locationChangeCallbackFunc = locationChangeCallback
        self.show_location_data = False
        self._pongCallbackFunc = None
        self._transitionCallbackFunc = None
		
        # try connect to specified car
        while True:
            try:
                self.connect()
                break
            except btle.BTLEException as e:
                logging.getLogger("anki.overdrive_t1").error(e.message)

    def __del__(self):
        """Deconstructor for an Overdrive object"""
        self.disconnect()
		
	
    # saves any manually supplied user parameters eg --car_mac, --player-name
    # so other class methods can retrieve this data
    # this is an internal function called in the __init__ method
    def saveManualParameters(self):
    
        # get parameters passed manually to this script
        args = parser.parse_args()

        # Set manual_student_name name, default value is "Unknown"
        self.manual_student_name = args.student_name
        self.manual_car_mac = args.car_mac
        
    
    # External method to return the set car Mac Address
    # Must be called once the car has been connected and verified with validateCar() method below
    def getMacAddress(self):
        return self.car_mac
        
        
    # Get the MAC address of the car to control
    # this is an internal function called in the __init__ method
    def _setMacAddress(self):
        
        # Use the user supplied arguments if supplied
        if self.manual_car_mac != 'Not set':
            # User must have manually supplied the mac address via the command line switch --car_mac=xx
            # so use it
            self.CAR_NUMBER = self.manual_car_mac
            
            print("User has manually supplied --car_mac parameter whilst calling this script, so we'll use that ("+self.manual_car_mac+")")
            
        # else if they have not supplied any car_id or mac, either in their script or via params...
        elif self.CAR_NUMBER == 999999:
            print("======================================================================")
            print("ERROR - Please supply what car number you wish to control, in your code. Refer to the docs.")
            print("======================================================================")
            print()
            quit()
        
        # convert to string
        self.CAR_NUMBER = str(self.CAR_NUMBER)
                
        # validate this car choice
        self.validateCar(self.CAR_NUMBER)
        
        print("===================================================")
        print("We are now going to control this mac address: "+self.car_mac)
		
    
    # query PHP whether student can access this car
    def validateCar(self, car_id):
    
        car_id = str(car_id)
        
        #print("validateCar run with car_id: "+car_id)
        
        # build our PHP script URL
        url = "http://"+self.local_ip_address+"/python_communicator/validate_car.php"
        
        # data to send
        data = {'car_id':car_id}
        
        # Query PHP to validate student's car choice
        php = PhpCommunicator()
        response = php.getResponse(url, data)       # get the response from PHP
        
        # check for errors
        if "ERROR" in response:
            print("***********************************************************************")
            print(response)
            print("***********************************************************************")
            quit()
        else:
            # all ok, use the mac address returned from PHP database search
            self.car_mac = response
    
    
    # External method to return the car_id of the set car
    # This matches to the cars table in the DB
    def getCarId(self):
        return self.car_id
    
    
    
    # Internal method to set the car_id matching to the cars table in the DB
    # Must only be called once _setMacAddress() has been run
    # returns car_id
    def _setCarId(self, car_mac):
        # query PHP using the car mac address
        # PHP should return the corresponding car_id from the cars table
        
        #print("_setCarId run with car_mac: "+car_mac)
        
        # build our PHP script URL
        url = "http://"+self.local_ip_address+"/python_communicator/get_car_id.php"
        
        # data to send
        data = {'mac_address': self.getMacAddress()}
        
        # Query PHP to validate student's car choice
        php = PhpCommunicator()
        response = php.getResponse(url, data)       # get the response from PHP
        
        # check for errors
        if "ERROR" in response:
            print("***********************************************************************")
            print(response)
            print("***********************************************************************")
            quit()
        else:
            # all ok, use the car_id returned from PHP database search
            self.car_id = response
    
    
    # Gets the student_id of the current user from database using PHP
    # This is worked out based on the username they are logged in as
    # returns student_id
    def getStudentId(self):
    
        # build our PHP script URL
        url = "http://"+self.local_ip_address+"/python_communicator/get_student_id.php"
        
        # PhpCommunicator class appends username which is used to get the student username
        # so we don't need to send anything to PHP
        data = {'blank':'blank'}
        
        # Query PHP to validate student's car choice
        php = PhpCommunicator()
        response = php.getResponse(url, data)       # get the response from PHP
        
        # check for errors
        if "ERROR" in response:
            print("***********************************************************************")
            print(response)
            print("***********************************************************************")
            quit()
        else:
            # all ok, use the mac address returned from PHP database search
            student_id = response
    
        return student_id
        
    
    # Gets the student username of the user running this script
    # returns username string (e.g. john_smith)
    def getUsername(self):
    
        # python can tell what user called the script which is handy
        username = getpass.getuser()
        
        return username
        

    # method which connects to the car
    def connect(self):
        """Initiate a connection to the Overdrive."""
        if self._btleSubThread is not None and threading.current_thread().ident != self._btleSubThread.ident:
            return # not allow
        self._peripheral.connect(self.car_mac, btle.ADDR_TYPE_RANDOM)
        self._readChar = self._peripheral.getCharacteristics(1, 0xFFFF, "be15bee06186407e83810bd89c4d8df4")[0]
        self._writeChar = self._peripheral.getCharacteristics(1, 0xFFFF, "be15bee16186407e83810bd89c4d8df4")[0]
        self._delegate.setHandle(self._readChar.getHandle())
        self._peripheral.setDelegate(self._delegate)
        self.turnOnSdkMode()
        self.enableNotify()
        self._connected = True
        self._reconnect = False
        if self._btleSubThread is None:
            self._transferExecution()

    def _transferExecution(self):
        """Fork a thread for handling BTLE notification, for internal use only."""
        self._btleSubThread = threading.Thread(target=self._executor)
        self._btleSubThread.start()

	# this method stops the car and quits completly.
	# safer than calling quit() from main script
    def quit(self):
        self.stopCar()
        self.disconnect()
        quit()
		
    def disconnect(self):
        """Disconnect from the Overdrive."""
		
        if self._connected and (self._btleSubThread is None or not self._btleSubThread.is_alive()):
            self._disconnect()
        self._connected = False

    def _disconnect(self):
        """Internal function. Disconnect from the Overdrive."""
        try:
            self._writeChar.write(b"\x01\x0D")
            self._peripheral.disconnect()
        except btle.BTLEException as e:
            logging.getLogger("anki.overdrive").error(e.message)


    # enables the printing out and debugging of car location data
    # to the user
    def enableLocationData(self):
        self.show_location_data = True
    
    
    # changes the car speed and acceleration
    def changeSpeed(self, speed, accel):
	
        """Change speed for Overdrive.
        
        Parameters:
        speed -- Desired speed. (from 0 - 1000)
        accel -- Desired acceleration. (from 0 - 1000)
        """
		
        max_speed = 1000
        min_speed = 0
                    
        # limit max speed
        if speed >= max_speed:
            speed = max_speed
            
        # limit min speed
        if speed <= min_speed:
            speed = min_speed
        
        command = struct.pack("<BHHB", 0x24, speed, accel, 0x01)
        self.sendCommand(command)
    
    # Brake quickly to stop
    def stopCar(self):
        self.changeSpeed(0,700)
        
    # Brake VERY quickly to stop
    def stopCarFast(self):
        self.brakeLightsOn()
        self.changeSpeed(0,1000)
        
    # OLD METHOD
    def changeLaneRight(self, speed, accel):
        """Switch to adjacent right lane.

        Parameters:
        speed -- Desired speed. (from 0 - 1000)
        accel -- Desired acceleration. (from 0 - 1000)
        """
        self.changeLane(speed, accel, 44.5)
        
    # OLD METHOD
    def changeLaneLeft(self, speed, accel):
        """Switch to adjacent left lane.

        Parameters:
        speed -- Desired speed. (from 0 - 1000)
        accel -- Desired acceleration. (from 0 - 1000)
        """
        self.changeLane(speed, accel, -44.5)

    # jstucken MOD
    # allow script to modify lane change aggression
    def setLaneChangeAmount(self, val):
        self.offset_change_amount = val


    # jstucken MOD
    # make the car veer left slightly
    def turnLeft(self):
        
        speed = self.speed      # get whatever the last speed was in this class
        accel = 1000
        
        # get value of previous offset
        prev_offset = self.getInstructedOffset()
        
        # make new offset value
        new_offset = prev_offset - self.offset_change_amount
        
        # set max value
        if new_offset < -68:
            new_offset = -68
        
        # save this newly calculated offset for later reference
        self.setInstructedOffset(new_offset)
        
        #print(" ====================================== ")
        #print("prev_offset: ")
        #print(prev_offset)
        #print("new_offset: ")
        #print(new_offset)
        
        # send the command to car
        self.changeLane(speed, accel, new_offset)
        
    # jstucken MOD
    # make the car veer right slightly
    def turnRight(self):
        
        speed = self.speed      # get whatever the last speed was in this class
        accel = 1000
        
        # get value of previous offset
        prev_offset = self.getInstructedOffset()
        
        # make new offset value
        new_offset = prev_offset + self.offset_change_amount
        
        # set max value
        if new_offset > 68:
            new_offset = 68
            
        # save this newly calculated offset for later reference
        self.setInstructedOffset(new_offset)
        
        #print(" ====================================== ")
        #print("prev_offset: ")
        #print(prev_offset)
        #print("new_offset: ")
        #print(new_offset)
        
        # send the command to car
        self.changeLane(speed, accel, new_offset)

    def changeLane(self, speed, accel, offset):
        """Change lane.

        Parameters:
        speed -- Desired speed. (from 0 - 1000)
        accel -- Desired acceleration. (from 0 - 1000)
        offset -- Offset from current lane. (negative for left, positive for right)
        """
        #self.setLane(0.0)
        command = struct.pack("<BHHf", 0x25, speed, accel, offset)
        #self.sendCommandRaw(command)       # doesnt work
        self.sendCommand(command)
        
    def setLane(self, offset):
        """Set internal lane offset (unused).

        Parameters:
        offset -- Desired offset.
        """
        command = struct.pack("<Bf", 0x2c, offset)
        self.sendCommand(command)

    def turnOnSdkMode(self):
        """Turn on SDK mode for Overdrive."""
        
        command = b"\x90\x01\x01"
        #print("turnOnSdkMode run, command: ")
        #print(command)
        
        self.sendCommand(command)
            
            
    # jstucken MOD    
    # Returns the last reading of the car's speed
    def getSpeed(self):
    
        return self.speed
        
        
    # jstucken MOD    
    # Returns the last reading of the car's location
    def getLocation(self):
        return self.location
		
    # jstucken MOD    
    # Returns the last reading of the car's piece (TO BE CONFIRMED WHAT THIS IS EXACTLY?)
    def getPiece(self):

        return self.piece
        
        
    # jstucken MOD    
    # Sets the last reading of the car's lane offset
    def setOffset(self, new_value):
        self.offset = float(new_value)
        
        
    # jstucken MOD    
    # Returns the last reading of the car's lane offset
    def getOffset(self):
    
        # see if we can get offset from the car
        # otherwise set it to 0 (center lane)
        return self.offset
    
    # jstucken MOD    
    # Sets the instructed offset which we have told the car to move to
    # IMPORTANT NOTE! As the car takes a while to turn/change lanes, this instructed_offset
    # will likely differ from the actuall offset being passed back from car notification (updated about 3 times per second)
    def setInstructedOffset(self, new_value):
    
        # If it's still set to default value, try get the offset from the car
        if self.instructed_offset == 99:
            self.instructed_offset = self.getOffset()
        else:
            # set for rest of class
            self.instructed_offset = new_value
    
    # returns the number of laps the car has completed
    # currently there is no penalty for going counter-clockwise and making u-turns!
    def getLapCount(self):
        return self.lap_count
        
    # Internal function only 
    # Called when the car passes over finish line each time
    def _incrementLapCount(self):
        self.lap_count = self.lap_count + 1
    
    
    # Records the most recent lap time
    def _saveLapTime(self):
    
        current_timestamp = datetime.now() # current date and time
        previous_timestamp = self.prev_lap_time     # saved in class
        time_difference = current_timestamp - previous_timestamp
        #time_difference_formatted = time_difference.microseconds
        
        # update time counters
        self.prev_lap_time = current_timestamp
        self.prev_lap_time_difference = time_difference
        
        #print("current_timestamp: ")
        #print(current_timestamp)

        #print("previous_timestamp: ")
        #print(previous_timestamp)
        
        #print("time_difference: ")
        #print(time_difference)
        
       # print("time_difference_formatted: ")
        #print(time_difference_formatted)
    
    # returns the most recent lap time
    def getLapTime(self):  
        return self.prev_lap_time_difference
        
        
    # jstucken MOD    
    # Returns the last instructed offset which we have told the car to move to
    # IMPORTANT NOTE! As the car takes a while to turn/change lanes, this instructed_offset
    # will likely differ from the actuall offset being passed back from car notification (updated about 3 times per second)
    def getInstructedOffset(self):
        return self.instructed_offset
    
    
    # Prints the current offset etc to screen 
    def printDebuggingInfo(self):
        print("==============================")
        print("getOffset: ")
        print(self.getOffset())
        print("getInstructedOffset: ")
        print(self.getInstructedOffset())
            
        
    # jstucken MOD
    # turns on red brake lights
    def brakeLightsOn(self):
    
        command = b"\x11\x33\x01\x01\x00\x0e\x0e\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"
        
        #print("brakeLightsOn run with command: ")
        #print(command)
        self.sendCommandRaw(command)
        #print(" ")
        
    # jstucken MOD
    # turns off red brake lights
    def brakeLightsOff(self):
    
        command = b"\x11\x33\x01\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"
        
        #print("brakeLightsOff run with command: ")
        #print(command)
        self.sendCommandRaw(command)
        #print(" ")
    
    # sets lights to greenish yellow
    def setEngineLights(self):

        command = b"\x11\x33\x03\x00\x03\x00\x0e\x01\x03\x03\x00\x0e\x01\x02\x03\x00\x00\x01"
        # displays as this in wireshark:
        # Value: 1133030003000e010303000e010203000001
        
        #print("setEngineLights run with command: ")
        #print(command)
        self.sendCommandRaw(command)
        #print(" ")
        
    # Do UTURN
    def doUturn(self):
           
        command = b'\x03\x32\x03\x00';
        #print("doUturn run with command: ")
        #print(command)
        self.sendCommandRaw(command)
        #print(" ")
		
		
		
	
	# jstucken MOD
	# Send the car on a mission, looking for a particular piece
    def doMission(self, text_location, track_piece):
        
        # get car's current location
        current_piece = self.getPiece()
        
        print("Looking for "+text_location+" (track piece: "+str(track_piece)+"), current piece is: "+str(current_piece)+"...")
            
        # track piece must be an integer
        int(track_piece)
        
        # have we met the mission objective?
        if current_piece == track_piece:
            return True
        else:
            return False
            

    
    def enableNotify(self):
        """Repeatly enable notification, until success."""
        while True:
            self._delegate.notificationsRecvd = 0
            self._peripheral.writeCharacteristic(self._readChar.valHandle + 1, b"\x01\x00")
            self.ping()
            self._peripheral.waitForNotifications(3.0)
            if self.getNotificationsReceived() > 0:
                break
            logging.getLogger("anki.overdrive").error("ERROR - Set notify failed - cannot communicate with car!")
    
    def ping(self):
        """Ping command."""
        
        command = b"\x16"
        #print("ping run, command: ")
        #print(command)
        self.sendCommand(command)

    def _executor(self):
        """Notification thread, for internal use only."""
        data = None
        while self._connected:
            if self._reconnect:
                while True:
                    try:
                        self.connect()
                        self._reconnect = False
                        if data is not None:
                            self._writeChar.write(data)
                        break
                    except btle.BTLEException as e:
                        logging.getLogger("anki.overdrive").error(e.message)
                        self._reconnect = True
            try:
                data = self._writeQueue.get_nowait()
                self._writeChar.write(data)
                data = None
            except queue.Empty:
                try:
                    self._peripheral.waitForNotifications(0.001)
                except btle.BTLEException as e:
                    logging.getLogger("anki.overdrive").error(e.message)
                    self._reconnect = True
            except btle.BTLEException as e:
                logging.getLogger("anki.overdrive").error(e.message)
                self._reconnect = True
        self._disconnect()
        self._btleSubThread = None

    def getNotificationsReceived(self):
        """Get notifications received count."""
        return self._delegate.notificationsRecvd

    def sendCommand(self, command):
        """Send raw command to Overdrive
        
        Parameters:
        command -- Raw bytes command, without length.
        """
        finalCommand = struct.pack("B", len(command)) + command
        if self._writeChar is None:
            self._reconnect = True
        self._writeQueue.put(finalCommand)
    
    # jstucken MOD
    # Send raw bytes command straight over bluetooth without any struct.pack business
    def sendCommandRaw(self, command):
        """Send raw command to Overdrive
        
        Parameters:
        command -- Raw bytes command, without length.
        """
        finalCommand = command
        if self._writeChar is None:
            self._reconnect = True
        self._writeQueue.put(finalCommand)

    def setLocationChangeCallback(self, func):
        """Set location change callback.

        Parameters:
        func -- Function for callback. (see _locationChangeCallback() for details)
        """
        self._locationChangeCallbackFunc = func

    def _locationChangeCallback(self, location, piece, offset, speed, clockwise):
        """Location change callback wrapper.

        Parameters:
        car_mac -- MAC address of car
        location -- Received location ID on piece.
        piece -- Received piece ID.
        speed -- Measured speed.
        clockwise -- Clockwise flag.
        """
        if self._locationChangeCallbackFunc is not None:
        
            # round offset to nearest whole number
            #offset = round(offset, 1)
            
            # send location data to callbackfunction for printing in main script window
            self._locationChangeCallbackFunc(self.car_mac, location, piece, offset, speed, clockwise, self.show_location_data)
            
            # jstucken MOD
            # Save car location and speed etc for other class methods or the user to retrieve when needed
            self.speed = speed
            self.location = location
            self.piece = piece
            self.offset = offset
            
            # ignore 'undefined' values
            if clockwise != "undefined":
                self.clockwise = clockwise
            

    def setPongCallback(self, func):
        """Set pong callback.

        Parameters:
        func -- Function for callback. (see _pongCallback() for details)
        """
        print("setPongCallback has been run")
        self._pongCallbackFunc = func

    def _pongCallback(self):
        """Pong callback wrapper.
        
        Parameters:
        car_mac -- MAC address of car
        """
        if self._pongCallbackFunc is not None:
            self._pongCallbackFunc(self.car_mac)
    
    def setTransitionCallback(self, func):
        """Set piece transition callback.

        Parameters:
        func -- Function for callback. (see _transitionCallback() for details)
        """
        self._transitionCallbackFunc = func

    def _transitionCallback(self):
        """Piece transition callback wrapper.
        
        Parameters:
        car_mac -- MAC address of car
        """
        if self._transitionCallbackFunc is not None:
            self._transitionCallbackFunc(self.car_mac)


class OverdriveDelegate(btle.DefaultDelegate):
    """Notification delegate object for Bluepy, for internal use only."""

    def __init__(self, overdrive):
        self.handle = None
        self.notificationsRecvd = 0
        self.overdrive = overdrive
        btle.DefaultDelegate.__init__(self)

    def handleNotification(self, handle, data):
        if self.handle == handle:
            self.notificationsRecvd += 1
            (commandId,) = struct.unpack_from("B", data, 1)
            if commandId == 0x27:
                # Location position
                location, piece, offset, speed, clockwiseVal = struct.unpack_from("<BBfHB", data, 2)
                
                # jstucken MOD - TESTING!!
                # The finish line piece (34 and 33) causes problems when working out clockwise direction
                # so ignore readings on that piece
                if clockwiseVal == 0x47 and piece != 34 and piece != 33:
                    clockwise = "true"
                elif piece != 34 and piece != 33:
                    clockwise = "false"
                else:
                    # must be the finish line piece
                    clockwise = "undefined"
                    
                #print("jstucken MOD, piece: "+str(piece)+" and clockwiseVal: "+str(clockwiseVal))
                # count number of laps completed
                # piece 33 is the finish line
                if piece == 33:
                    self.overdrive._incrementLapCount()
                    self.overdrive._saveLapTime()

                # Create a Python thread to handle new notification
                threading.Thread(target=self.overdrive._locationChangeCallback, args=(location, piece, offset, speed, clockwise)).start()
                
            if commandId == 0x29:
                # Transition notification
                piece, piecePrev, offset, direction = struct.unpack_from("<BBfB", data, 2)
                threading.Thread(target=self.overdrive._transitionCallback).start()
            elif commandId == 0x17:
                # Pong
                threading.Thread(target=self.overdrive._pongCallback).start()

    def setHandle(self, handle):
        self.handle = handle
        self.notificationsRecvd = 0
        
