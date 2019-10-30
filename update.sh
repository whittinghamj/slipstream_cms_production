#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Update Script v2.2.2"

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
# cp -R /var/www/html/portal/c /var/www/html/ >> $LOG


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
# add 'type' to bouquets
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.bouquets ADD COLUMN IF NOT EXISTS \`type\` VARCHAR(20); "; >> $LOG
# set default field value for field 'type'
mysql -uslipstream -padmin1372 -e "UPDATE slipstream_cms.bouquets SET \`type\` = 'live' WHERE \`type\` = '' OR \`type\` IS NULL; "; >> $LOG
# delete servers where user_id != 0
mysql -uslipstream -padmin1372 -e "DELETE FROM slipstream_cms.headend_servers WHERE user_id = '0'; "; >> $LOG
# create vod_categories
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`vod_categories\` (\`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`user_id\` int(11) DEFAULT NULL, \`name\` varchar(50) NOT NULL DEFAULT '', PRIMARY KEY (\`id\`)) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;"; >> $LOG
# create default vod_category
mysql -uslipstream -padmin1372 -e "INSERT IGNORE INTO \`slipstream_cms\`.\`vod_categories\` (\`id\`, \`user_id\`, \`name\`)VALUES(1, 1, 'General'); "; >> $LOG
# change mag_devices.aspect field type
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.mag_devices MODIFY aspect VARCHAR(100) NULL; "; >> $LOG
# create vod_watch table
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`vod_watch\` ( \`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`user_id\` int(11) DEFAULT NULL, \`server_id\` int(11) DEFAULT NULL, \`folder\` text, PRIMARY KEY (\`id\`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; "; >> $LOG
# add default stream_category
mysql -uslipstream -padmin1372 -e "INSERT IGNORE INTO \`slipstream_cms\`.\`stream_categories\` (\`id\`, \`user_id\`, \`name\`) VALUES (1, 1, 'Default Category'); "; >> $LOG
# change all streams with no category to new default
mysql -uslipstream -padmin1372 -e "UPDATE slipstream_cms.streams SET \`category_id\` = '1' WHERE \`category_id\` = '0'; "; >> $LOG
# create default package
mysql -uslipstream -padmin1372 -e "INSERT IGNORE INTO \`slipstream_cms\`.\`packages\` (\`id\`, \`user_id\`, \`name\`) VALUES (1, 1, 'Default Package'); "; >> $LOG
# add package field to customer table
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.customers ADD COLUMN IF NOT EXISTS \`package_id\` VARCHAR(20) DEFAULT 1; "; >> $LOG


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
get_php_check=$(cat /usr/local/nginx/conf/nginx.conf | grep 'ss_v_2.2' | wc -l)
if [ "$get_php_check" -eq "0" ]; then
	killall nginx >> $LOG

	RTMPPORT='1935';
	# HTTPPORT=$(cat /usr/local/nginx/conf/nginx.conf | grep listen | sed -n '2p' | sed 's/[^0-9]*//g');
	HTTPPORT_RAW=$(echo "SELECT http_stream_port FROM headend_servers WHERE id = '1' " | mysql slipstream_cms -u slipstream -padmin1372)
	HTTPPORT="$(echo $HTTPPORT_RAW | sed -e "s/http_stream_port //g")";

	mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.bak >> $LOG

	wget -O /usr/local/nginx/conf/nginx.conf http://slipstreamiptv.com/downloads/nginx_server.txt >> $LOG

	sed -i 's/EDIT_HTTP_PORT/'$HTTPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG
	sed -i 's/EDIT_RTMP_PORT/'$RTMPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG

	/usr/local/nginx/sbin/nginx >> $LOG
	echo "NGINX Config file updated"
fi


# check mysql bind-address
check_mysql_bind=$(cat /etc/mysql/mariadb.conf.d/50-server.cnf | grep '#bind-address' | wc -l)
if [ "$check_mysql_bind" -eq "0" ]; then
	mv /etc/mysql/mariadb.conf.d/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf.bak &> $LOG
	wget -O /etc/mysql/mariadb.conf.d/50-server.cnf http://slipstreamiptv.com/downloads/50-server.txt &> $LOG
	service mysql restart &> $LOG
	service mysqld restart &> $LOG
	echo "NGINX Config file updated"
fi


# crontab check
cron_1=$(crontab -l | grep '@reboot /usr/local/nginx/sbin/nginx' | wc -l)
if [ "$cron_1" -eq "0" ]; then
	echo "Updating cron jobs"
	echo "# Slipstream CMS Main Server - HTTP Server" >> /tmp/slipstream_cms.cron
	echo "@reboot /usr/local/nginx/sbin/nginx" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Main Server - Customer Checks" >> /tmp/slipstream_cms.cron
	echo "*/10 * * * * /usr/bin/flock -w 0 /tmp/console_customer_checks.lock /usr/bin/php -q /var/www/html/portal/console/console.php customer_checks > /tmp/cron.customer_checks.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Main Server - Server Checks" >> /tmp/slipstream_cms.cron
	echo "*/10 * * * * /usr/bin/flock -w 0 /tmp/console_node_checks.lock /usr/bin/php -q /var/www/html/portal/console/console.php node_checks > /tmp/cron.customer_checks.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Stalker Portal" >> /tmp/slipstream_cms.cron
	echo "@reboot sh /var/www/html/portal/scripts/stalker_start.sh" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - GIT Update" >> /tmp/slipstream_cms.cron
	echo "* * * * * sh /root/slipstream/node/update.sh" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Crons" >> /tmp/slipstream_cms.cron
	echo "* * * * * php -q /root/slipstream/node/console/console.php cron >> /root/slipstream/node/logs/cron.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Roku Channel Manager" >> /tmp/slipstream_cms.cron
	echo "0 */4 * * * php -q /root/slipstream/node/console/console.php roku_channel_manager >> /root/slipstream/node/logs/cron.log" >> /tmp/slipstream_cms.cron

	crontab /tmp/slipstream_cms.cron
	rm /tmp/slipstream_cms.cron
fi
cron_2=$(crontab -l | grep '@reboot sh /var/www/html/portal/scripts/stalker_start.sh' | wc -l)
if [ "$cron_2" -eq "0" ]; then
	echo "Updating cron jobs"
	echo "# Slipstream CMS Main Server - HTTP Server" >> /tmp/slipstream_cms.cron
	echo "@reboot /usr/local/nginx/sbin/nginx" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Main Server - Customer Checks" >> /tmp/slipstream_cms.cron
	echo "*/10 * * * * /usr/bin/flock -w 0 /tmp/console_customer_checks.lock /usr/bin/php -q /var/www/html/portal/console/console.php customer_checks > /tmp/cron.customer_checks.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Main Server - Server Checks" >> /tmp/slipstream_cms.cron
	echo "*/10 * * * * /usr/bin/flock -w 0 /tmp/console_node_checks.lock /usr/bin/php -q /var/www/html/portal/console/console.php node_checks > /tmp/cron.customer_checks.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Stalker Portal" >> /tmp/slipstream_cms.cron
	echo "@reboot sh /var/www/html/portal/scripts/stalker_start.sh " >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - GIT Update" >> /tmp/slipstream_cms.cron
	echo "* * * * * sh /root/slipstream/node/update.sh" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Crons" >> /tmp/slipstream_cms.cron
	echo "* * * * * php -q /root/slipstream/node/console/console.php cron >> /root/slipstream/node/logs/cron.log" >> /tmp/slipstream_cms.cron
	echo " " >> /tmp/slipstream_cms.cron
	echo "# Slipstream CMS Streaming Server - Roku Channel Manager" >> /tmp/slipstream_cms.cron
	echo "0 */4 * * * php -q /root/slipstream/node/console/console.php roku_channel_manager >> /root/slipstream/node/logs/cron.log" >> /tmp/slipstream_cms.cron

	crontab /tmp/slipstream_cms.cron
	rm /tmp/slipstream_cms.cron
fi

echo "Update Complete "
echo " "