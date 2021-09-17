#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.

# This script attempts to save lap times into local mysql db running on the pi
# Author: jstucken
# Created: 23-2-2021
#
   
SCRIPT_TITLE="Retrieve and save car data"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive
from php_communicator import PhpCommunicator
from network import Network

# Setup our car
car = Overdrive(12)  # init overdrive object
car.enableLocationData()

# get car details from Overdrive class object
school_id = '8521'
mac_address = car.getMacAddress()
car_id = car.getCarId()
username = car.getUsername()
student_id = car.getStudentId()

# Set custom fields - students can pass their own data here
custom_field1 = 'student data here1'
custom_field2 = 'student data here2'
custom_field3 = 'student data here3'


# start the car off
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(300, 800)

# start endless loop
while True:
    
    # slight delay between reading car data
    time.sleep(0.1)

    # get car location and speed data
    location = car.getLocation()
    speed = car.getSpeed()

    # data to be sent to API to save to DB
    data = {'school_id':school_id, 
        'student_id':student_id,
        'car_id':car_id,
        'student_id':student_id,
        'mac_address':mac_address,
        'username':username,
        'speed':speed,
        'location':location,
        'car_type':'MXT',
        'custom_field1': custom_field1,
        'custom_field2': custom_field2,
        'custom_field3': custom_field3
        }

    # get the local IP address of the server machine
    local_ip_address = Network.getLocalIPAddress()

    # build our PHP script URL where data will be sent to be saved
    # eg  "http://192.168.0.10/cars_data_save.php"
    url = "http://"+local_ip_address+"/python_communicator/cars_data_save.php"

    # Send data to PHP to save to database
    php = PhpCommunicator()
    return_text = php.getResponse(url, data)       # get the response from PHP

    # extracting response text  
    print("Response from PHP script: %s"%return_text)


car.disconnect()
quit()