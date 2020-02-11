#!/bin/bash

LOG=/tmp/slipstream.log

killall nginx >> $LOG

RTMPPORT='1935';
HTTPPORT_RAW=$(echo "SELECT http_stream_port FROM headend_servers WHERE id = '1' " | mysql slipstream_cms -u slipstream -padmin1372)
HTTPPORT="$(echo $HTTPPORT_RAW | sed -e "s/http_stream_port //g")";

mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.bak >> $LOG

wget -O /usr/local/nginx/conf/nginx.conf http://slipstreamiptv.com/downloads/nginx_server.txt >> $LOG

sed -i 's/EDIT_HTTP_PORT/'$HTTPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG
sed -i 's/EDIT_RTMP_PORT/'$RTMPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG

mv /etc/php/7.2/cli/php.ini /etc/php/7.2/cli/php.ini.bak &> $LOG
wget -O /etc/php/7.2/cli/php.ini http://slipstreamiptv.com/downloads/php.txt &> $LOG
mv /etc/php/7.2/cgi/php.ini /etc/php/7.2/cgi/php.ini.bak &> $LOG
wget -O /etc/php/7.2/cgi/php.ini http://slipstreamiptv.com/downloads/php-cgi.txt &> $LOG
mv /etc/php/7.2/fpm/php.ini /etc/php/7.2/fpm/php.ini.bak &> $LOG
wget -O /etc/php/7.2/fpm/php.ini http://slipstreamiptv.com/downloads/php-fpm.txt &> $LOG

sudo service php7.2-fpm restart >> $LOG
/usr/local/nginx/sbin/nginx >> $LOG
sudo service php7.2-fpm restart >> $LOG

echo "Done "
echo " "