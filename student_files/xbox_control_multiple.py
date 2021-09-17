#
# This script allows the user to control an Anki car using a wired Xbox 360 controller
# Xbox controller must be physically connected to the raspi's USB port
# See: https://github.com/linusg/xbox360controller/
# and: https://github.com/linusg/xbox360controller/blob/master/docs/API.md
# and: https://pypi.org/project/xbox360controller/
#
# To control multiple cars at once, open a seperate Command Line Window for each car
# and call this script with the approriate car mac address.
#
# This script can run over an SSH connection too, eg an SHH connection to the Raspberry Pi.
# Author: jstucken
#

SCRIPT_TITLE="Multiple Xbox controller example"

import time
from library import overdrive               # the script which contains variables, functions and classes
from library.overdrive import Overdrive     # the overdrive class itself
import signal								# Xbox control class
from xbox360controller import Xbox360Controller	# Xbox control class

user_controller = input("Enter controller number 0-3: ")
user_controller = int(user_controller)
print("user_controller: ")
print(user_controller)


print("")
print("")
print("Use a wired Xbox 360 controller to control the car:")
print("")
print("Left stick = turn left and right")
print("Right stick = speed up and slow down")
print("A button = U-Turn (Use with care! Best done from center lane at slower speeds)")
print("Y button = Print debugging info")
print()
input("Press ENTER to continue or CTRL+C to quit...")

# Setup our class for use shortly
car = Overdrive()  # init overdrive object
car_mac = overdrive.car_mac     
# tell the class to change lanes slower than normal (eg than with keyboard control)
car.setLaneChangeAmount(10)

# set default values:
speed = 300


#print("user_controller: ")
#print(user_controller)

#quit()
# fast speed increments for hard stick movements
fast_increment = 40     # how much to increase/decrease speed by
fast_accel = 500

# slower speed increment for gentle stick movements
slow_increment = 20     # how much to increase/decrease speed by
slow_accel = 250

# start the car
#car.changeSpeed(speed, fast_accel)

# instantiate our xbox controller object
controller = Xbox360Controller(user_controller, axis_threshold=0.1)

# start infinite loop to allow user to continously give keyboard input
while True:

	# get xbox controller inputs
	y_button = controller.button_y.is_pressed
	a_button = controller.button_a.is_pressed
	
	x_val = controller.axis_l.x		# left stick
	y_val = controller.axis_r.y		# right stick
	print("x_val: "+str(x_val)+" and y_val: "+str(y_val))
	
	# handle rapid stop/braking with A button
	if (a_button):
		print("SCREEEEEECH! SLOW DOWN REALLY FAST")
		car.changeSpeed(0, 1000)
	# handle u-turns
	elif (y_button):
		car.doUturn()
		time.sleep(0.3)
	else:
		# handle car turns
		if x_val == -1:
			print("GO LEFT")
			car.turnLeft()
		elif x_val == 1:
			print("GO RIGHT")
			car.turnRight()
			
		# handle speed changes
		# -1 = stick fully up
		# 1 = stick fully down
		print("y_val: "+str(y_val))
		if y_val == -1:
			# speed up
			print("SPEED UP FAST")
			speed = speed + fast_increment
			car.brakeLightsOff()
			car.changeSpeed(speed, fast_accel)
		elif y_val < -0.2:
			print("SPEED UP SLOW")
			speed = speed + slow_increment
			car.brakeLightsOff()
			car.changeSpeed(speed, 1000)
		elif y_val == 1:
			# slow down
			print("SLOW DOWN FAST")
			speed = speed - fast_increment
			car.brakeLightsOn()
			car.changeSpeed(speed, fast_accel)
		elif y_val > 0.2:
			print("SLOW DOWN SLOWLY")
			speed = speed - slow_increment
			car.brakeLightsOn()
			car.changeSpeed(speed, slow_accel)
		
		
		
		# keep speed within car's limits
		if speed < 0:
			speed = 0
		elif speed > 1000:
			speed = 1000
		
		if speed == 1000:
			controller.set_led(Xbox360Controller.LED_TOP_RIGHT_ON)
		elif speed == 0:
			controller.set_led(Xbox360Controller.LED_BOTTOM_RIGHT_ON)
		else:
			controller.set_led(Xbox360Controller.LED_OFF)
	
	print("speed: "+str(speed))
	
	"""
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
    """
	
	time.sleep(0.1)

quit()
