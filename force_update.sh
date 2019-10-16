#!/bin/bash

LOG=/tmp/slipstream.log

killall nginx >> $LOG

cd /var/www/html/portal >> $LOG

git fetch --all -q >> $LOG

git reset --hard -q origin/master >> $LOG

/usr/local/nginx/sbin/nginx >> $LOG

echo "Done "