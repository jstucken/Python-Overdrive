#
# This script allows the user to control an Anki car using Python
#
# Author: jstucken
#

SCRIPT_TITLE="Simple Example"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive

# Setup our car
car = Overdrive(1)     # initialise overdrive object using car 12 (matches to a car in the database)

# how fast to drive the car
speed = 300

# set the car speed now
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(speed, 100)

# drive for 600 seconds
print("Let's drive!")
time.sleep(600)

# stop the car
print("Stop the car!")
car.stopCar()

car.quit()
