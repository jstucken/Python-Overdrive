#
# This script allows the user to control an Anki car using their keyboard
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# This script can run over an SSH connection too, eg an SHH connection to the Raspberry Pi.
# Author: jstucken
#

SCRIPT_TITLE="Keyboard control example"

# import required modules
import loader.bootstrapper
import time
from overdrive import Overdrive
import keyboard                # keyboard control class

print("")
print("")
print("Use the following keys on your keyboard to control the car:")
print("")
print("W = accelerate/move forward")
print("A = turn left")
print("S = brake/slow down")
print("D = turn right")
print()
print("U = U-Turn (Use with care! Best done from center lane at slower speeds)")
print("P = Print debugging info")
print()
input("Press ENTER to continue or CTRL+C to quit...")

# Setup our class for use shortly
car = Overdrive(12)  # init overdrive object

# set default values:
speed = 300
increment = 100     # how much to increase/decrease speed by

# start infinite loop to allow user to continously give keyboard input
while True:

    # get user input (keyboard characters)
    user_char = keyboard.getKeyboardInput("Press W A S D keys to control the car:")
    user_char = user_char.lower()

    # increase speed
    if user_char == 'w':
        speed = speed + increment
        car.brakeLightsOff()

    # decrease speed
    if user_char == 's':
        speed = speed - increment
        car.brakeLightsOn()

    # u-turn
    if user_char == 'u':
        car.doUturn()

    # turn left
    if user_char == 'a':
        car.turnLeft()

    # turn right
    if user_char == 'd':
        car.turnRight()       
    
    # Prints the current offset etc to screen
    if user_char == 'p':
        car.printDebuggingInfo()
        

    #print("CHANGE SPEED to: "+str(speed))

    
    # tell car to go the new speed chosen
    car.changeSpeed(speed, 1000) 
    

quit()
