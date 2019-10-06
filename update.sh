#!/bin/bash

# bash git update script
cd /var/www/html/portal && git pull git@github.com:whittinghamj/slipstream_cms_server.git

# confirm folder permissions
chmod 777 /var/www/html/portal/m3u_uploads