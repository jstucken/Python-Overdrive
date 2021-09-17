#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# Author: jonathan.stucken2@det.nsw.edu.au
#
   
SCRIPT_TITLE="Send the car on several missions, one after the other"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive


# Setup our car
car = Overdrive(12)  # init overdrive object


# define what track locations correspond to which friendly location names eg 33 = shops
police = 33
fire = 34
hospital = 39
corner = 17


# ask the user for the first mission objective
mission_objective1 = input("Enter first mission objective (police/fire/hospital):")
mission_objective2 = input("Enter second mission objective (police/fire/hospital):")
mission_objective3 = input("Enter third mission objective (police/fire/hospital):")

# setup what track piece matches what label
if mission_objective1 == "police":
	track_piece1 = police
elif mission_objective1 == "fire":
	track_piece1 = fire
elif mission_objective1 == "hospital":
	track_piece1 = hospital
	
if mission_objective2 == "police":
	track_piece2 = police
elif mission_objective2 == "fire":
	track_piece2 = fire
elif mission_objective2 == "hospital":
	track_piece2 = hospital

if mission_objective3 == "police":
	track_piece3 = police
elif mission_objective3 == "fire":
	track_piece3 = fire
elif mission_objective3 == "hospital":
	track_piece3 = hospital

# ask the user to choose the car's speed	
speed = int(input("Enter car speed (0-1000):"))


# start the car off
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(speed, 600)

# flag to signify when the mission has been completed
objective_complete = 0

# move car until mission parameters have been met
while objective_complete == 0:

    # look for mission objective until found
    if car.doMission(mission_objective1, track_piece1):
        # stop the car
        car.stopCarFast()
    
        print("\n **************************")
        print("FIRST OBJECTIVE COMPLETED! We have arrived at "+mission_objective1)
        objective_complete = 1
    else:
        # not found yet, keep looking
        time.sleep(0.2)

# start second objective
time.sleep(4)
print("Now starting second objective: "+mission_objective2)
time.sleep(2)

car.brakeLightsOff()
car.changeSpeed(speed, 600)
objective_complete = 0
while objective_complete == 0:

    # look for mission objective until found
    if car.doMission(mission_objective2, track_piece2):
        # stop the car
        car.stopCarFast()
        
        print("\n **************************")
        print("SECOND OBJECTIVE COMPLETED! We have arrived at "+mission_objective2)
        objective_complete = 1
        
    else:
        # not found yet, keep looking
        time.sleep(0.2)


# start third objective
time.sleep(4)
print("Now starting third objective: "+mission_objective3)
time.sleep(2)

car.brakeLightsOff()
car.changeSpeed(speed, 600)
objective_complete = 0
while objective_complete == 0:

    # look for mission objective until found
    if car.doMission(mission_objective3, track_piece3):
        # stop the car
        car.stopCarFast()
        
        print("\n **************************")
        print("THIRD OBJECTIVE COMPLETED! We have arrived at "+mission_objective3)
        objective_complete = 1
        
    else:
        # not found yet, keep looking
        time.sleep(0.2)


print("\n ***********************")
print("**************************")
print("All objectives found") 
print("MISSION COMPLETE!")

#quit();
car.quit()