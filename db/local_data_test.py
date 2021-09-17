#
# This script sends some test data to PHP to get saved into local DB
#
# Author: jonathan.stucken2@det.nsw.edu.au
# Created: 20/2/2021
#
   
import time
import requests
#import socket
import random

# URL to post data to

# local DB
API_ENDPOINT = "http://10.176.113.64/python_save.php"

# remote DB
#API_ENDPOINT = "https://tasteacher.net/anki/mothership_save.php"

print("***************************************")
print("** This script sends some test data")
print("** to PHP to get saved into local DB")
print("***************************************")


# Get data input from user
mac = input("Enter MAC address: ")
player_name = input("Enter player_name: ")
car_type = input("Enter car_type: ")

print("Enter a delay in seconds between each data insert")
delay = float(input("OR type 0 to simulate random intervals:"))


print("******************************************")
print(" OK we are now going to start an infinite")
print("* loop and insert the above data")
print("******************************************")
print("")
print("PRESS ANY KEY TO CONTINUE or CTRL + C to quit...")
input()

# start infinite loop
location = 0
speed = 300

while True:

	# make a random number for speed
	#speed = random.randint(0,1000)
	
	# make a random delay to simulate latency on live network
	random_delay = random.randint(1,5)
	random_delay = random_delay / 10
	#print("random_delay: ")
	#print(random_delay)

	# data to be sent to api 
	data = {'school_id':'8521', 
			'mac':mac,
			'player_name':player_name,
			'speed':speed,
			'location':location,
			'car_type':car_type} 

	# sending post request and saving response as response object 
	r = requests.post(url = API_ENDPOINT, data = data) 
	  
	# extracting response text  
	return_text = r.text 
	print("Response from PHP script: %s"%return_text) 
	
	# increment location data to simulate car moving around the track
	location = location + 1
	if location == 10:
		location = 1
		
	# are we increasing or decreasing speed
	if speed >= 1000:
		speed_direction = "down"
	elif speed <= 300:
		speed_direction = "up"
		
	if speed_direction == "down":
		speed = speed - 100
	elif speed_direction == "up":
		speed = speed + 100;
	
	
	#time.sleep(1)	# 1 sec
	#time.sleep(0.2)	# 200ms
	# sleep between each loop, for however long user says
	if delay > 0:
	
		time.sleep(delay)	# random value
	# else random value if they entered 0
	else:
		time.sleep(random_delay)
		
# end infinite loop

quit()
