#!/bin/bash
set -x

########################
#
# Author: Andrew O'Brien
# Version: v1.0.0
# Date: 2021-08-17
# Description: Create user accounts from class.csv file on desktop.
# Usage: ./addUsers-csv.sh path/to/local/csv
#
########################

if [ ! -f"$1" ] ; then
  echo "The input to $0 should be a filename and its path"
  exit 1
fi

CSV=$1  #first argument


while IFS=, read lastname firstname username class password; do
  # Create Class as group, -f is force option if group already exists
  sudo groupadd -f "$class"
  echo "$lastname", "$firstname", "$username", "$class", "$password"
  sudo useradd -g "$class" -s /bin/bash -p "$password" -m "$username"
  sudo cp /home/pi/Python-Overdrive/student_files/*.* /home/"$username"/
done < "$CSV"

#while IFS=, read -ra array; do
#  ar1+=("${array[0]}")
#  ar2+=("${array[1]}")
#  ar3+=("${array[2]}")
#  ar4+=("${array[3]}")
#done < "$CSV"
#printf `%$\n` "${ar1[@]}" "${ar2[@]}" "${ar3[@]}" "${ar4[@]}"

### useradd -p $(openssl passwd -crypt $PASS) $USER
### something to check: https://github.com/harelba/q

