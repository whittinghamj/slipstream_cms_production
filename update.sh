#!/bin/bash

# bash git update script
cd /var/www/html/portal && git --git-dir=/var/www/html/portal/.git pull origin master

# confirm folder permissions
chmod 777 /var/www/html/portal/m3u_uploads
mkdir -p /var/www/html/portal/xc_uploads
chmod 777 /var/www/html/portal/xc_uploads

# copy files over
cp /var/www/html/portal/get.php /var/www/html/get.php
cp /var/www/html/portal/portal.php /var/www/html/portal.php

cp -R /var/www/html/portal/c /var/www/html/

# mysql status check
UP=$(pgrep mysql | wc -l);
if [ "$UP" -ne 1 ];
then
    sudo service mysql start
fi

# mysql updates
mysql -uroot -padmin1372 -e "ALTER TABLE slipstream_cms.bouquets ADD COLUMN IF NOT EXISTS \`type\` VARCHAR(20); ";
mysql -uroot -padmin1372 -e "UPDATE slipstream_cms.bouquets SET \`type\` = 'live' WHERE \`type\` = '' OR \`type\` IS NULL; ";
mysql -uroot -padmin1372 -e "DELETE FROM slipstream_cms.headend_servers WHERE user_id = '0'; ";
mysql -uroot -padmin1372 -e "ALTER TABLE slipstream_cms.bouquets ADD COLUMN IF NOT EXISTS `type` VARCHAR(20); ";
mysql -uroot -padmin1372 -e "UPDATE slipstream_cms.bouquets SET `type` = 'live' WHERE `type` = '' OR `type` IS NULL; ";

# stalker cleanup
old_stalker=$(cat /usr/local/nginx/conf/nginx.conf | grep '/home/xapicode/iptv_xapicode/wwwdir/_c;' | wc -l)
if [ "$old_stalker" -eq "0" ]; then
	sed -i 's/\/home\/xapicode\/iptv_xapicode\/wwwdir\/_c/\/var\/www\/html\/c/' /usr/local/nginx/conf/nginx.conf
   	killall nginx
   	/usr/local/nginx/sbin/nginx
fi
