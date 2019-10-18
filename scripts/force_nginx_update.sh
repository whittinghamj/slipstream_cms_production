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

/usr/local/nginx/sbin/nginx >> $LOG

echo "Done "
echo " "