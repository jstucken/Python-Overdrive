#!/bin/bash
# echoes out kernel version to screen
# eg:
# Linux 4.19.0-13-amd64 x86_64 GNU/Linux
#
# modified by jstucken 20-6-2021

KERNEL=`uname -srmo`

echo $KERNEL
