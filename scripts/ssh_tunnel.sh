#!/bin/bash
# Author: Yanis Alim

if [[ $EUID -ne 0 ]]; then
	echo "This script must be run as root" 
	exit 1
fi

command -v xterm >/dev/null 2>&1 || { echo >&2 "This script requires xterm !"; exit 1; }
command -v sshuttle >/dev/null 2>&1 || { echo >&2 "This script requires sshuttle !"; exit 1; }

echo -n "Enter your university ID number: "
read ID
echo -e "[!] When the new terminal pop-up, enter your university account PASSWORD !"

sleep 3
xterm -hold -e "sshuttle --dns -r $ID@ssh.ufr-info-p6.jussieu.fr 132.227.89.0/24 172.16.0.0/24 -vvvv" & 
