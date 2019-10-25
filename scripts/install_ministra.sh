#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Ministra Installer"

mysql -uslipstream -padmin1372 -e "CREATE DATABASE IF NOT EXISTS slipstream_stalker;"; >> $LOG

mysql -uslipstream -padmin1372 slipstream_stalker < /var/www/html/portal/stalker_fresh.sql >> $LOG

sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common >> $LOG
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add - >> $LOG
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable" >> $LOG
sudo apt-get update >> $LOG
sudo apt-get install -y docker-ce >> $LOG
sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose >> $LOG
sudo chmod +x /usr/local/bin/docker-compose >> $LOG
wget -O /opt/slipstream/stalker_commit.tar.gz http://slipstreamiptv.com/downloads/stalker_commit.tar.gz >> $LOG
cd /opt/slipstream >> $LOG
gunzip -c stalker_commit.tar.gz  | docker load >> $LOG
docker run -d --net=host -d stalker_final bash -c "/etc/init.d/apache2 restart; tail -f /dev/null" >> $LOG
cd /root >> $LOG