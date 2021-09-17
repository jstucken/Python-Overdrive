#!/bin/bash
# This script takes a plain text password and hashes it so it can be used in # /etc/wpa_supplicant/wpa_supplicant.conf, i.e. in order to use DET school wifi network
#
# PLAINTEXT_PASSWORD needs to be passed to this script as a command line argument
# e.g. ./set/get_wpa_supplicant_hash.sh mypasswordhere
#
# This script returns the hashed password which can be used in wpa_supplicant.conf

PLAINTEXT_PASSWORD=$1
#echo "PLAINTEXT_PASSWORD: ${PLAINTEXT_PASSWORD}"

# check user has supplied PLAINTEXT_PASSWORD to use
if [ "$PLAINTEXT_PASSWORD" == "" ]
then
    echo "Please pass a plaintext password to this script as an argument."
    exit
fi

# make a password hash
HASHED_PASSWORD=$(echo -n ${PLAINTEXT_PASSWORD}| iconv -t utf16le | openssl md4 -binary | xxd -p)

#echo "Clear text password set to: ${PLAINTEXT_PASSWORD}"
echo "${HASHED_PASSWORD}"