#!/bin/bash

LOG=/tmp/slipstream.log

killall nginx >> $LOG

RTMPPORT='1935';
HTTPPORT=$(cat /usr/local/nginx/conf/nginx.conf | grep listen | sed -n '2p' | sed 's/[^0-9]*//g');

mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.bak >> $LOG

wget -O /usr/local/nginx/conf/nginx.conf http://slipstreamiptv.com/downloads/nginx_server.txt >> $LOG

sed -i 's/EDIT_HTTP_PORT/'$HTTPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG
sed -i 's/EDIT_RTMP_PORT/'$RTMPPORT'/' /usr/local/nginx/conf/nginx.conf >> $LOG

/usr/local/nginx/sbin/nginx >> $LOG

echo "Done "
echo " "