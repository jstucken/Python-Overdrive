#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.

# This script attempts to save lap times into local mysql db running on the pi
# Author: jstucken
# Created: 23-2-2021
#
   
SCRIPT_TITLE="Lap timer saving to Mysql"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive
from php_communicator import PhpCommunicator
from network import Network

# Setup our car
car = Overdrive(12)  # init overdrive object
car.enableLocationData()

# get car mac address from our class object
car_mac = car.getMacAddress()
car_id = car.getCarId()
username = car.getUsername()
student_id = car.getStudentId()


# count number of laps completed
lap_count = 0

# start the car off
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(400, 800)

last_lap_time = 0
last_lap_count = -1

# race 3 laps and time each one
while lap_count !=3:

    time.sleep(0.1)
    # lap count is incremented when cars pass over the finish line
    lap_count = car.getLapCount()

    # count laps done
    if last_lap_count != lap_count:
        last_lap_count = lap_count
        print()
        print("lap_count: "+str(lap_count))

        # get lap time
        prev_lap_time = car.getLapTime()

        if last_lap_time != prev_lap_time:
            print()
            print("prev_lap_time: "+str(prev_lap_time))
            
        
        # if car has completed at least 1 lap
        if lap_count > 0:
            # Save last_lap_time time to database now
            # get cars current location and speed
            location = car.getLocation()
            speed = car.getSpeed()
            

            # data to be sent to API 
            data = {
                'student_id':student_id,
                'car_id':car_id,
                'lap_time':prev_lap_time,
                'lap_count':lap_count,
                'speed':speed
                }

            # get the local IP address of the server machine
            local_ip_address = Network.getLocalIPAddress()

            # build our PHP script URL where data will be sent to be saved
            # eg  "http://192.168.0.10/lap_times_save.php"
            url = "http://"+local_ip_address+"/python_communicator/lap_times_save.php"

            # Send data to PHP to save to database
            php = PhpCommunicator()
            return_text = php.getResponse(url, data)       # get the response from PHP

            # extracting response text  
            print("Response from PHP script: %s"%return_text)
            
        # end if
        print()
        print("*****")

    last_lap_time = prev_lap_time
    
    


# stop the car
car.stopCarFast()
print("Stopping as car has done the required number of laps")

car.disconnect()
quit()