#!/bin/bash
# applies wpa_supplicant.conf changes without a reboot
#
# from: https://www.raspberrypi.org/forums/viewtopic.php?t=198274
#
# modified by jstucken 22-6-2021

echo "Enabling wifi, in case it is currently turned off..."
# enable wifi, in case user has clicked off in raspi GUI
sudo ifconfig wlan0 down
sleep 2
sudo ifconfig wlan0 up
sleep 2 #wait x seconds
sudo rfkill unblock 0
sleep 2

echo "Reloading changes to /etc/wpa_supplicant/wpa_supplicant.conf"
sleep 3
wpa_cli -i wlan0 reconfigure

# alternative commands to try
sudo systemctl daemon-reload
sudo systemctl restart dhcpcd


