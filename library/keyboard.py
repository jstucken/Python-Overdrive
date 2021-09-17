
# Keyboard input script
# Allows the user to press keys on the keyboard
# without needing to subsequently press enter to accept the input
# Author: jstucken

import time
import curses

# Function which handles keyboard input
# Modified from: https://stackoverflow.com/questions/3523174/raw-input-in-python-without-pressing-enter
def getKeyboardInput(message):
    try:
        win = curses.initscr()
        win.addstr(0, 0, message)
        while True: 
            ch = win.getch()
            if ch in range(32, 127): 
                break
            time.sleep(0.05)
    finally:
        curses.endwin()
    return chr(ch)
    
    
def testMethod():
    print("testMethod has run")
