#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# Author: jstucken
#

SCRIPT_TITLE="Changing speed and stopping example"

import time
from library import overdrive               # the script which contains variables, functions and classes
from library.overdrive import Overdrive     # the overdrive class itself
from library import keyboard                # keyboard control class


# Setup our car
car = Overdrive()  # init overdrive object

# set the car speed now
# USAGE:
# car.changeSpeed(speed, accel)
print("\n Moving car with speed: 300, accel: 600 for 5 seconds \n")
car.changeSpeed(300, 600)
time.sleep(5)   # run for 5 seconds

# stop the car for 3 seconds
print("\n BRAKES!!! \n")
car.brakeLightsOn()
car.stopCar()
time.sleep(3)
car.brakeLightsOff()

# GO FAST
print("\n Moving car with speed: 800, accel: 400 for 3 seconds \n")
car.changeSpeed(800, 400)
time.sleep(3)

# stop again
car.brakeLightsOn()
print("\n BRAKES!!! \n")
car.stopCar()
time.sleep(3)   # script will usually end on this

quit()