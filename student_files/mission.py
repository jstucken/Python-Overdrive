#
# This script allows the user to control an Anki car using Python
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# Author: jonathan.stucken2@det.nsw.edu.au
#
   
SCRIPT_TITLE="Send the car on a mission looking for a particular location"

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

# ask the user what track piece they want to drive to
mission_objective = input("Enter mission objective (police/fire/hospital):")

# define where does user want to go?
if mission_objective == "police":
	mission_piece = police
	
elif mission_objective == "fire":
	mission_piece = fire
	
elif mission_objective == "hospital":
	mission_piece = hospital
	
elif mission_objective == "corner":
	mission_piece = corner
else:
	print("\n I don't recognise that location, but I'll try anyway...")
	mission_piece = 999	# car will never find this fictional piece

# ask the user to choose the car's speed	
speed = int(input("Enter car speed (0-1000):"))


# start the car off
# usage: car.changeSpeed(speed, accel)
car.changeSpeed(speed, 600)

# flag to signify when the mission has been completed
mission_complete = 0

# move car until mission parameters have been met
while mission_complete == 0:

    # look for mission objective
	# get current location piece
	current_piece = car.getPiece()
	
	# is current piece the mission objective?
	if current_piece == mission_piece:
		mission_complete = 1
	
	# has the mission been completed?
	if mission_complete == 1:
		print("\n WE FOUND THE "+mission_objective+" (piece: "+str(mission_piece)+") - STOP THE CAR!")
        
		# stop the car
		car.stopCarFast()
		
	else:
		# otherwise, keep searching for mission objective
		print("Looking for mission location piece: "+str(mission_piece)+" ("+mission_objective+"), the car's current location piece is: "+str(current_piece))
		
	time.sleep(0.2)


print("***********************")
print("MISSION COMPLETE!")

#quit();
car.quit()