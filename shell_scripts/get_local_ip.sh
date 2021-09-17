#!/bin/bash
# see: https://wiki.ubuntu.com/UpdateMotd#Design
# and: https://askubuntu.com/questions/100052/modify-the-ssh-welcome-message-to-include-system-ip-address

hostname -I | awk '{print $1}'
