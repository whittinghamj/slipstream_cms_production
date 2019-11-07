#!/bin/bash
curl -L -O https://downloads.sourceforge.net/project/filebot/filebot/FileBot_4.7.9/filebot_4.7.9_amd64.deb
dpkg -i filebot_4.7.9_amd64.deb
sudo apt-get install -y -qq openjfx
sudo apt-get install -y -qq openjdk-8-jre
sudo apt-get install -y -qq default-jre