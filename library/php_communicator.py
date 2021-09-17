#
# This class allows Python to communicate with PHP
# Useful in sending data from Python to the Database
# and getting a response for further processing in Python
#
# created by jstucken 14-6-2021

#import time
#import socket
#import random
import os
import requests
import getpass


# BEGIN OUR CLASS
class PhpCommunicator:
    
    def __init__(self):
        self.endpoint = None
        
        
    # returns the full path of the python script being executed
    def getPythonPath(self):
        file_path = os.path.realpath(__file__)
        return file_path
        
        
    
    # Basic method to run a PHP script, this cannot pass GET or POST data
    # it returns the response from PHP
    def getResponseBasic(self, endpoint):
    
        # THIS METHOD IS DISABLED FOR NOW as it's not needed
        pass
    
        #python_path = self.getPythonPath()
        #print("python_path: "+python_path)
        #quit()
        proc = subprocess.Popen("php "+endpoint, shell=True, stdout=subprocess.PIPE)
        script_response = proc.stdout.read()
        
        # convert response from byte string to string
        script_response = script_response.decode('utf-8')
        
        return script_response
     
     
    # POSTS data to a PHP script (endpoint)
    # param url is the full URL (inc. http://) to the PHP script
    # param data is a dictionary (array) containing the data to send to PHP
    # This method can be used to send data locally or remotely
    # returns the response text from PHP
    def getResponse(self, url, data):
    
        # get the current user from Python
        user = getpass.getuser()
        
        # add this onto data dictionary
        # data = {'car_id':car_id}
        data['user']=user
        
        # data to be sent to PHP 
        # sending post request and saving response as response object 
        r = requests.post(url, data) 
          
        # extracting response text  
        return_text = r.text 

        return return_text
        
    
    
        
