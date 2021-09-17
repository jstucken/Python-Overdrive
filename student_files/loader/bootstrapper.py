# This script loads all the required packages for the
# Anki Overdrive classes to be able to run.
# Placing it here saves cluttering up the student's code
#
# Author: jstucken 13-6-2021
#

# sys.path tute:
# https://www.devdungeon.com/content/python-import-syspath-and-pythonpath-tutorial

import site
import sys

# import our main library files
site.addsitedir('/home/pi/Python-Overdrive/library')
#print(sys.path)

#print("bootstrapper.py has run")
