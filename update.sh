#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Update Script v2.4.5"

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
chmod 777 /var/www/html/portal/m3u_uploads/ >> $LOG
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
# create bouquets_content
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`bouquets_content\` ( \`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`bouquet_id\` int(11) DEFAULT '0', \`content_id\` int(11) DEFAULT '0', \`order\` int(11) DEFAULT '999999', PRIMARY KEY (\`id\`), UNIQUE KEY \`bouquet_content\` (\`bouquet_id\`,\`content_id\`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"; >> $LOG
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
# add ondemand field for streams
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.streams ADD COLUMN IF NOT EXISTS \`ondemand\` VARCHAR(20) DEFAULT 'no'; "; >> $LOG
# add watch folder field for channels
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.channels ADD COLUMN IF NOT EXISTS \`watch_folder\` VARCHAR(500) DEFAULT NULL; "; >> $LOG
# create customers_ips
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`customers_ips\` (\`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`customer_id\` int(11) DEFAULT NULL, \`ip_address\` varchar(15) DEFAULT NULL, PRIMARY KEY (\`id\`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; "; >> $LOG
# add category_id to vod table
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.vod ADD COLUMN IF NOT EXISTS \`category_id\` VARCHAR(10) DEFAULT 1; "; >> $LOG
# add watch _older field for tv_series
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series ADD COLUMN IF NOT EXISTS \`watch_folder\` VARCHAR(500) DEFAULT NULL; "; >> $LOG
# add year field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`year\` VARCHAR(20) DEFAULT NULL; "; >> $LOG
# add rating field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`rating\` VARCHAR(20) DEFAULT NULL; "; >> $LOG
# add release_date field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`release_date\` VARCHAR(30) DEFAULT NULL; "; >> $LOG
# add plot field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`plot\` TEXT DEFAULT NULL; "; >> $LOG
# add posted field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`cover_photo\` VARCHAR(250) DEFAULT NULL; "; >> $LOG
# add season field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`season\` VARCHAR(50) DEFAULT NULL; "; >> $LOG
# add episode field for tv_series_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`episode\` VARCHAR(50) DEFAULT NULL; "; >> $LOG
# add season field for channels_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.channels_files ADD COLUMN IF NOT EXISTS \`season\` VARCHAR(50) DEFAULT NULL; "; >> $LOG
# add episode field for channels_files
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.channels_files ADD COLUMN IF NOT EXISTS \`episode\` VARCHAR(50) DEFAULT NULL; "; >> $LOG
# add rating field for tv_series
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series ADD COLUMN IF NOT EXISTS \`rating\` VARCHAR(20) DEFAULT NULL; "; >> $LOG
# add total_episodes field for channels
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.channels ADD COLUMN IF NOT EXISTS \`total_episodes\` VARCHAR(5) DEFAULT '0'; "; >> $LOG
# add total_episodes field for tv services
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series ADD COLUMN IF NOT EXISTS \`total_episodes\` VARCHAR(5) DEFAULT '0'; "; >> $LOG
# add cover_photo field for tv services
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.tv_series_files ADD COLUMN IF NOT EXISTS \`cover_photo\` VARCHAR(500) DEFAULT NULL; "; >> $LOG
# add transcoding_profile_id field for channels
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.channels ADD COLUMN IF NOT EXISTS \`transcoding_profile_id\` VARCHAR(5) DEFAULT '0'; "; >> $LOG
# add deint field for streams
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.streams ADD COLUMN IF NOT EXISTS \`deint\` VARCHAR(20) DEFAULT 'no'; "; >> $LOG
# create epg_setting
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`epg_setting\` ( \`id\` int(11) NOT NULL AUTO_INCREMENT, \`uri\` varchar(255) NOT NULL DEFAULT '', \`etag\` varchar(255) NOT NULL DEFAULT '', \`updated\` datetime DEFAULT NULL, \`id_prefix\` varchar(64) NOT NULL DEFAULT '', \`status\` tinyint(4) NOT NULL DEFAULT '1', \`lang_code\` varchar(20) DEFAULT NULL, PRIMARY KEY (\`id\`), UNIQUE KEY \`uri\` (\`uri\`) ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8; "; >> $LOG
# add name field for epg_setting
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.epg_setting ADD COLUMN IF NOT EXISTS \`name\` VARCHAR(50) DEFAULT ''; "; >> $LOG
# add time_offset field for epg_setting
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.epg_setting ADD COLUMN IF NOT EXISTS \`time_offset\` VARCHAR(50) DEFAULT '0000'; "; >> $LOG
# create epg_xml_ids
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`epg_xml_ids\` ( \`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`epg_source_id\` int(11) DEFAULT '0', \`xml_id\` varchar(30) DEFAULT '', \`xml_name\` varchar(50) DEFAULT '', \`xml_language\` varchar(20) DEFAULT 'en', PRIMARY KEY (\`id\`), UNIQUE KEY \`xml_id\` (\`xml_id\`) ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4; "; >> $LOG
# add epg_xml_id field for streams
mysql -uslipstream -padmin1372 -e "ALTER TABLE slipstream_cms.streams ADD COLUMN IF NOT EXISTS \`epg_xml_id\` VARCHAR(50) DEFAULT ''; "; >> $LOG
# add master_token to global_settings
mysql -uslipstream -padmin1372 -e "INSERT IGNORE INTO \`slipstream_cms\`.\`global_settings\` (\`id\`, \`config_name\`, \`config_value\`) VALUES (100, 'master_token', '1372'); "; >> $LOG
# create vod_connection_log
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`vod_connection_logs\` (\`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`timestamp\` bigint(11) DEFAULT NULL, \`server_id\` varchar(100) DEFAULT NULL, \`vod_id\` int(11) DEFAULT NULL, \`stream_name\` varchar(50) DEFAULT NULL, \`client_ip\` varchar(15) DEFAULT NULL, \`customer_id\` int(11) DEFAULT NULL, PRIMARY KEY (\`id\`) ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1; "; >> $LOG
# create series_connection_log
mysql -uslipstream -padmin1372 -e "CREATE TABLE IF NOT EXISTS \`slipstream_cms\`.\`series_connection_logs\` (\`id\` int(11) unsigned NOT NULL AUTO_INCREMENT, \`timestamp\` bigint(11) DEFAULT NULL, \`server_id\` varchar(100) DEFAULT NULL, \`series_id\` int(11) DEFAULT NULL, \`stream_name\` varchar(50) DEFAULT NULL, \`client_ip\` varchar(15) DEFAULT NULL, \`customer_id\` int(11) DEFAULT NULL, PRIMARY KEY (\`id\`) ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1; "; >> $LOG

# check if streamlink is installed, if not, install it.
command -v streamlink >/dev/null 2>&1 || { sudo apt-get install software-properties-common -y -qq; sudo add-apt-repository ppa:nilarimogard/webupd8 -y; sudo apt-get update -y -qq; sudo apt-get install -y -qq streamlink; } >> $LOG


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
cron_1=$(crontab -l | grep '# Slipstream CMS Main Server - Cron Manager' | wc -l)
if [ "$cron_1" -eq "0" ]; then
	echo "Updating cron jobs"
	crontab /var/www/html/portal/crontab.txt
fi


# old /c/ check
old_c='/var/www/html/portal/c/'
if [ -d "$old_c" ]; then
	echo "Removing old Stalker and updating NGINX"
    rm -rf $old_c
    sh /var/www/html/portal/scripts/force_nginx_update.sh
fi


echo "Update Complete"
echo " "
