#
# This class allows Python to communicate via 
# Useful in sending data from Python to the Database
# and getting a response for further processing in Python
#
# created by jstucken 14-6-2021

#import time
import subprocess


# BEGIN OUR CLASS
class Network:

    def __init__(self):
        pass


    # Static method to get the local IP address of the raspi
    # Uses a bash script on the machine to do this
    @staticmethod
    def getLocalIPAddress():
    
        # get local ip address
        local_ip_address = Network.getBashResponse("/home/pi/Python-Overdrive/shell_scripts/get_local_ip.sh");
        
        return local_ip_address
    
    
    # Static method which runs a local bash script or linux command and gets response data
    @staticmethod
    def getBashResponse(command):
    
        #response = subprocess.run([command], stdout=subprocess.PIPE, universal_newlines=False).stdout.decode('utf-8')
        
        response = subprocess.check_output(command, shell=True).decode('utf-8')
        
        # strip out newlines
        response = response.strip()
        
        return response
        
