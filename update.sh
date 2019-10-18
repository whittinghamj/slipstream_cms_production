#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Update Script v2"

# set git repo
# git remote set-url origin https://github.com/whittinghamj/slistream_cms_production.git


# bash git update script
cd /var/www/html/portal >> $LOG
git --git-dir=/var/www/html/portal/.git pull -q origin master >> $LOG


# check folders
mkdir -p /var/www/html/portal/xc_uploads >> $LOG
mkdir -p /var/www/html/portal/m3u_uploads >> $LOG
mkdir -p /opt/slipstream/backups >> $LOG


# confirm folder permissions
chmod 777 /var/www/html/portal/m3u_uploads >> $LOG
mkdir -p /var/www/html/portal/xc_uploads >> $LOG
chmod 777 /var/www/html/portal/xc_uploads >> $LOG


# copy files over
# cp /var/www/html/portal/get.php /var/www/html/get.php
# cp /var/www/html/portal/portal.php /var/www/html/portal.php
cp -R /var/www/html/portal/c /var/www/html/ >> $LOG
cp -R /var/www/html/portal/d /var/www/html/ >> $LOG


# mysql status check
UP=$(pgrep mysql | wc -l);
if [ "$UP" -ne 1 ];
then
    sudo service mysql start >> $LOG
fi


# nginx status check
nginx_status=$(ps aux | grep nginx | grep -v 'grep' | wc -l)
if [ "$nginx_status" -eq "0" ]; then
   echo "Starting NGINX Streaming Server.";
   /usr/local/nginx/sbin/nginx >> $LOG
fi


# mysql updates
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.bouquets ADD COLUMN IF NOT EXISTS \`type\` VARCHAR(20); "; >> $LOG
mysql -uslipstream -padmin1372 -e "UPDATE slipstream_cms.bouquets SET \`type\` = 'live' WHERE \`type\` = '' OR \`type\` IS NULL; "; >> $LOG
mysql -uslipstream -padmin1372 -e "DELETE FROM slipstream_cms.headend_servers WHERE user_id = '0'; "; >> $LOG
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`vod_categories\` (\`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`user_id\` int(11) DEFAULT NULL, \`name\` varchar(50) NOT NULL DEFAULT '', PRIMARY KEY (\`id\`)) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;"; >> $LOG
mysql -uslipstream -padmin1372 -e "INSERT IGNORE INTO \`slipstream_cms\`.\`vod_categories\` (\`id\`, \`user_id\`, \`name\`)VALUES(1, 1, 'General'); "; >> $LOG


# stalker cleanup
old_stalker=$(cat /usr/local/nginx/conf/nginx.conf | grep '/home/xapicode/iptv_xapicode/wwwdir/_c;' | wc -l)
if [ "$old_stalker" -eq "1" ]; then
	killall nginx >> $LOG
	sed -i 's/\/home\/xapicode\/iptv_xapicode\/wwwdir\/_c/\/var\/www\/html\/c/' /usr/local/nginx/conf/nginx.conf
   	/usr/local/nginx/sbin/nginx >> $LOG
fi


# update git repo 
sed -i 's/streamwizz_cms_production.git/slipstream_cms_production.git/' /var/www/html/portal/.git/config


# update nginx conf file
get_php_check=$(cat /usr/local/nginx/conf/nginx.conf | grep 'ss_v_2.1' | wc -l)
if [ "$get_php_check" -eq "0" ]; then
	killall nginx >> $LOG

	RTMPPORT='1935';
	HTTPPORT=$(cat /usr/local/nginx/conf/nginx.conf | grep listen | sed -n '2p' | sed 's/[^0-9]*//g');

	mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.bak >> $LOG

	wget -O /usr/local/nginx/conf/nginx.conf http://slipstreamiptv.com/downloads/nginx_server.txt >> $LOG

	sed -i 's/EDIT_HTTP_PORT/'$HTTPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG
	sed -i 's/EDIT_RTMP_PORT/'$RTMPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG

	/usr/local/nginx/sbin/nginx >> $LOG
	echo "NGINX Config file updated"
fi

echo "Update Complete "
echo " "