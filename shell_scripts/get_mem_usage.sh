#!/bin/bash
# echoes out memory usage to screen, in MB
# requires bc (calculator) to be installed
# modified by jstucken 12-6-2021

#df -h
# get second line of file usage command which will have the actual values
#data=`df -h | head --lines 2`
data=`free -m | sed -n '2p'`

#echo $data
# break the data into pieces, splitting by spaces
parts=($data)

# now pieces can be accessed from the numerical array
TOTAL=${parts[1]}
USED=${parts[2]}
FREE=${parts[3]}
SHARED=${parts[4]}
#USE_PERCENTAGE=$(echo "scale=3; ($USED / $TOTAL) * 100" | bc)

#echo "TOTAL: $TOTAL"
#echo "USED: $USED"
#echo "FREE: $FREE"
#echo "SHARED: $SHARED"
#echo "USE_PERCENTAGE: $USE_PERCENTAGE"

echo "$USED MB of $TOTAL MB used"