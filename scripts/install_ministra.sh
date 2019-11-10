#!/bin/bash

LOG=/tmp/slipstream.log

echo "SlipStream CMS Panel Server - Ministra 5.3 Installer"

mysql -uslipstream -padmin1372 -e "DROP DATABASE IF EXISTS stalker_db;"; >> $LOG

mysql -uslipstream -padmin1372 -e "CREATE DATABASE IF NOT EXISTS stalker_db;"; >> $LOG

wget -q -O /opt/slipstream/ministra-5.3.sql http://slipstreamiptv.com/downloads/ministra-5.3.sql >> $LOG
mysql -uslipstream -padmin1372 stalker_db < /opt/slipstream/ministra-5.3.sql >> $LOG

mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.tv_genre;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.itv;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.ch_links;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.services_package;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.tariff_plan;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.users;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.service_in_package;"; >> $LOG
mysql -uslipstream -padmin1372 -e "TRUNCATE TABLE stalker_db.package_in_plan;"; >> $LOG

sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common >> $LOG
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add - >> $LOG
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable" >> $LOG
sudo apt-get update >> $LOG
sudo apt-get install -y docker-ce >> $LOG
sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose >> $LOG
sudo chmod +x /usr/local/bin/docker-compose >> $LOG

docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)

wget -q -O /opt/slipstream/ss_ministra_53.tar.gz http://slipstreamiptv.com/downloads/ss_ministra_53.tar.gz >> $LOG
cd /opt/slipstream >> $LOG
gunzip -c ss_ministra_53.tar.gz | docker load >> $LOG
docker run -d --net=host -d ministra_5.3 bash -c "/etc/init.d/apache2 restart; tail -f /dev/null" >> $LOG

ufw allow 88/tcp >> $LOG

cd /root >> $LOG