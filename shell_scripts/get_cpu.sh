#!/bin/bash
# by Paul Colby (http://colby.id.au), no rights reserved ;)
# https://rosettacode.org/wiki/Linux_CPU_utilization#UNIX_Shell
# modified by jstucken 12-6-2021
PREV_TOTAL=0
PREV_IDLE=0

# loop 3 times to get an accurate CPU usage comparison
x=1
while [ $x -le 3 ]
do
  #while true; do
  # Get the total CPU statistics, discarding the 'cpu ' prefix.
  CPU=($(sed -n 's/^cpu\s//p' /proc/stat))
  IDLE=${CPU[3]} # Just the idle CPU time.
 
  # Calculate the total CPU time.
  TOTAL=0
  for VALUE in "${CPU[@]:0:8}"; do
    TOTAL=$((TOTAL+VALUE))
  done
 
  # Calculate the CPU usage since we last checked.
  DIFF_IDLE=$((IDLE-PREV_IDLE))
  DIFF_TOTAL=$((TOTAL-PREV_TOTAL))
  DIFF_USAGE=$(((1000*(DIFF_TOTAL-DIFF_IDLE)/DIFF_TOTAL+5)/10))
  #echo -en "$DIFF_USAGE%"
  # only echo out the cpu usage on the final loop
  if [ $x -eq 3 ]
  then
    echo $DIFF_USAGE
  fi
  # Remember the total and idle CPU times for the next check.
  PREV_TOTAL="$TOTAL"
  PREV_IDLE="$IDLE"
 
  # Wait before checking again.
  sleep 0.1
  x=$(( $x + 1 ))
done
