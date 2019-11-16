#!/bin/bash

# set some vars
IPADDRESS="$(ip addr | grep 'state UP' -A2 | tail -n1 | awk '{print $2}' | cut -f1  -d'/')";


# create needed folders
mkdir -p /opt/nzbget
wget https://github.com/nzbget/nzbget/releases/download/v21.0/nzbget-21.0-bin-linux.run
sudo sh nzbget-21.0-bin-linux.run --destdir /opt/nzbget
rm nzbget-21.0-bin-linux.run
sudo chown -R nobody:nogroup /opt/nzbget
sudo sed -i "/DaemonUsername=/c\DaemonUsername=nobody" /opt/nzbget/nzbget.conf
wget -O /etc/systemd/system/nzbget.service http://domain.com/files/nzbget.service.txt
sudo systemctl enable nzbget.service
sudo service nzbget start


# report back
echo ""
echo "System Main IP: "$IPADDRESS
echo " "
echo "NZBGet URL: http://"$IPADDRESS":6789"
echo "NZVGet Default Username: nzbget"
echo "NZVGet Default Password: tegbzn6789"

