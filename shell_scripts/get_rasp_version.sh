#!/bin/bash
# echoes out raspberry pi version to screen
# eg:
# 10 (buster)
#
# modified by jstucken 20-6-2021

# Get raspberrian version. In future, may want to improve this to obtain the
# sub version number from cat /etc/debian_version eg. 10.9
RASP_VERSION=`cat /etc/os-release | grep NAME | awk '{$2="VERSION="; print $3" "$4}'`

# strip out double quotes and newlines
RASP_VERSION=`echo "$RASP_VERSION" | tr -d '"'`
RASP_VERSION=`echo "$RASP_VERSION" | tr -d '\n'`

echo $RASP_VERSION
