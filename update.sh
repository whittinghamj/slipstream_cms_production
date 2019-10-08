#!/bin/bash

# bash git update script
cd /var/www/html/portal && git --git-dir=/var/www/html/portal/.git pull origin master

# confirm folder permissions
chmod 777 /var/www/html/portal/m3u_uploads
mkdir -p /var/www/html/portal/xc_uploads
chmod 777 /var/www/html/portal/xc_uploads

# mysql status check
UP=$(pgrep mysql | wc -l);
if [ "$UP" -ne 1 ];
then
    sudo service mysql start
fi