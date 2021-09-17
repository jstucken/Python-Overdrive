
# Displays the welcome banner and title up top of each script
# Author: jstucken

from network import Network

# Text formatting colours
# From https://stackoverflow.com/questions/287871/how-to-print-colored-text-in-python
TEXT_HEADER='\033[95m'
TEXT_BLUE='\033[94m'
TEXT_CYAN='\033[96m'
TEXT_GREEN='\033[92m'
TEXT_WARNING='\033[93m'
TEXT_FAIL='\033[91m'
TEXT_ENDC='\033[0m'
TEXT_BOLD='\033[1m'
TEXT_UNDERLINE='\033[4m'
TEXT_RESET='\033[0;0m'


# Function which handles keyboard input
def displayBanner(script_title):

    # run a bash script to get the version number of our DET Python Anki Overdrive library
    command = '/home/pi/Python-Overdrive/shell_scripts/get_version.sh'
    version = Network.getBashResponse(command)
    
    # format version text
    v = "v"+str(version)

    print(TEXT_GREEN)
    print("*******************************************")
    print("**       DET Python Anki Overdrive       **")
    print("**                 "+v+"                  **")
    print("*******************************************")
    print("")
    print(TEXT_HEADER+" -- "+script_title+" -- ")
    print(TEXT_RESET)
    print()
    
