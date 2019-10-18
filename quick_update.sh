#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Server - Quick Update Script v2"

# bash git update script
cd /var/www/html/portal
git --git-dir=/var/www/html/portal/.git pull origin master

echo "Quick Update Complete "
echo " "