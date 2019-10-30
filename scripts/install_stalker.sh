#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Stalker 5.2 Installer"

mysql -uslipstream -padmin1372 -e "CREATE DATABASE IF NOT EXISTS stalker_db;"; >> $LOG

wget -q -O /opt/slipstream/stalker-5.2.sql http://slipstreamiptv.com/downloads/stalker-5.2.sql >> $LOG
mysql -uslipstream -padmin1372 stalker_db < /opt/slipstream/stalker-5.2.sql >> $LOG

mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.tv_genre;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.itv;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.ch_links;"; >> $LOG

sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common >> $LOG
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add - >> $LOG
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable" >> $LOG
sudo apt-get update >> $LOG
sudo apt-get install -y docker-ce >> $LOG
sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose >> $LOG
sudo chmod +x /usr/local/bin/docker-compose >> $LOG

wget -q -O /opt/slipstream/stalker-5.2.tar.gz http://slipstreamiptv.com/downloads/stalker-5.2.tar.gz >> $LOG
cd /opt/slipstream >> $LOG
gunzip -c stalker-5.2.tar.gz | docker load >> $LOG
docker run -d --net=host -d stalker-5.2 bash -c "/etc/init.d/apache2 restart; tail -f /dev/null" >> $LOG
cd /root >> $LOG