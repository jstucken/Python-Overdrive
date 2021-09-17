#!/bin/bash
# echoes out local disk usage to screen
# modified by jstucken 12-6-2021

#df -h
# get second line of file usage command which will have the actual values
#data=`df -h | head --lines 2`
data=`df / -h | sed -n '2p'`

# break the data into pieces, splitting by spaces
parts=($data)

# now pieces can be accessed from the numerical array
SIZE=${parts[1]}
USED=${parts[2]}
AVAIL=${parts[3]}
USE_PERCENTAGE=${parts[4]}

#echo "SIZE: $SIZE"
#echo "USED: $USED"
#echo "AVAIL: $AVAIL"
#echo "USE_PERCENTAGE: $USE_PERCENTAGE"

echo "$USED of $SIZE used ($USE_PERCENTAGE), $AVAIL free"
