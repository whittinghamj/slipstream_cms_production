#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Upgrade Script"

# set git repo
# git remote set-url origin https://github.com/whittinghamj/slistream_cms_production.git


# go into staging area
cd /var/www/html/portal >> $LOG

# force cms update
sh update.sh >> $LOG

# force nginx update
sh scripts/force_nginx_update.sh >> $LOG

# force cms update
sh update.sh >> $LOG

# crontab update
crontab /var/www/html/portal/crontab.txt >> $LOG

# go into staging area
cd /root/slipstream/node >> $LOG

# force cms update
sh update.sh >> $LOG

# force cms update
sh update.sh >> $LOG

echo "Upgrade Complete, Rebooting Server"
echo " "

sudo /sbin/reboot 
sudo /sbin/shutdown -r now
