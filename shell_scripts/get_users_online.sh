#!/bin/bash
# echoes out connected users to screen
# eg:
# pi pi pi pi root (5 total)
#
# modified by jstucken 20-6-2021

# users online
NUM_USERS=`users | wc -w`
USERS=`users`

echo "${USERS} (${NUM_USERS} total)"
