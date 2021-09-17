#
# This script allows the user to control multiple Anki cars
# simultaneously using a single Python script
#
# Author: jstucken
#

SCRIPT_TITLE="Multiple Cars Example"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive

# Setup our cars
nuke = Overdrive(12)
mxt = Overdrive(11)

# set the car speeds now
# usage: car.changeSpeed(speed, accel)
nuke.changeSpeed(600, 600)
mxt.changeSpeed(270, 600)

time.sleep(5)   # run for 5 seconds

# stop the cars
nuke.stopCar()
mxt.stopCar()

# disconnect from the cars (allows other students to use them)
# their lights should change from blue to green signifying disconnected state
nuke.disconnect()
mxt.disconnect()


quit()
