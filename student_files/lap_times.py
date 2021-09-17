#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# Author: jstucken
#
   
SCRIPT_TITLE="Lap timer with lap limit"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive


# Setup our car
car = Overdrive(12)  # init overdrive object
#car.enableLocationData()    # we need to know the cars constant location

# count number of laps completed
lap_count = 0

# start the car off
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(600, 800)

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
        print()
        print("*****")
        
        last_lap_time = prev_lap_time
    

# stop the car
car.stopCarFast()
print("Stopping as car has done the required number of laps")

car.disconnect()
quit()