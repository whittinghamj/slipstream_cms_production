#!/bin/bash
echo "GNX Streamer Setup - Debian / Ubuntu"


## set base folder
cd /root


## update apt-get repos
echo "Updating repos"
apt-get update


## upgrade all packages
echo "Upgrading OS"
apt-get -y upgrade


## install dependencies
echo "Installing core packages"
apt-get install -y v4l2-ctl phpsysinfo vnstat ffmpeg alsa-utils build-essential libpcre3 libpcre3-dev libssl-dev ntp python perl libnet-ssleay-perl openssl libauthen-pam-perl libpam-runtime libio-pty-perl apt-show-versions python3 bc htop nload nmap sudo zlib1g-dev gcc make git autoconf autogen automake pkg-config locate curl dnsutils sshpass fping jq shellinabox apache2 apache2-doc apache2-utils libapache2-mod-php php7.2 php7.2-common php7.2-gd php7.2-mysql php7.2-imap phpmyadmin php7.2-cli php7.2-cgi libapache2-mod-fcgid apache2-suexec-pristine php-pear mcrypt  imagemagick libruby libapache2-mod-python php7.2-curl php7.2-intl php7.2-pspell php7.2-recode php7.2-sqlite3 php7.2-tidy php7.2-xmlrpc php7.2-xsl memcached php-memcache php-imagick php-gettext php7.2-zip php7.2-mbstring php-soap php7.2-soap 
updatedb >/dev/null 2>&1


## configure shellinabox
mkdir /root/shellinabox
cd /root/shellinabox
wget -q http://miningcontrolpanel.com/scripts/shellinabox/white-on-black.css >/dev/null 2>&1
cd /etc/default
mv shellinabox shellinabox.default
wget -q http://miningcontrolpanel.com/scripts/shellinabox/shellinabox >/dev/null 2>&1
sudo invoke-rc.d shellinabox restart
cd /root


## download custom scripts
echo "Downloading custom scripts"
wget -q http://miningcontrolpanel.com/scripts/speedtest.sh >/dev/null 2>&1
rm -rf /root/.bashrc
wget -q http://miningcontrolpanel.com/scripts/.bashrc >/dev/null 2>&1
wget -q http://miningcontrolpanel.com/scripts/myip.sh >/dev/null 2>&1
rm -rf /etc/skel/.bashrc
cp /root/.bashrc /etc/skel
chmod 777 /etc/skel/.bashrc
cp /root/myip.sh /etc/skel
chmod 777 /etc/skel/myip.sh


## setup whittinghamj account
usermod -aG sudo whittinghamj
mkdir /home/whittinghamj/.ssh
wget -q -O /home/whittinghamj/.ssh/authorized_keys http://genexnetworks.net/scripts/jamie_ssh_key >/dev/null 2>&1
echo "whittinghamj    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers

## setup aegrant account
useradd -m -p eioruvb9eu839ub3rv aegrant
echo "aegrant:"'ne3Nup!m' | chpasswd >/dev/null 2>&1
usermod --shell /bin/bash aegrant
usermod -aG sudo aegrant
mkdir /home/aegrant/.ssh
wget -q -O /home/aegrant/.ssh/authorized_keys http://genexnetworks.net/scripts/andy_ssh_key >/dev/null 2>&1
echo "aegrant    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers


## add www-data to sudo file for managing everything
echo "www-data    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
usermod -aG sudo www-data


## change SSH port to 33077 and only listen to IPv4
echo "Updating SSHd details"
sed -i 's/#Port/Port/' /etc/ssh/sshd_config
sed -i 's/22/33077/' /etc/ssh/sshd_config
sed -i 's/#AddressFamily any/AddressFamily inet/' /etc/ssh/sshd_config
/etc/init.d/ssh restart >/dev/null 2>&1


# configure apache mods
a2enmod suexec rewrite ssl actions include cgi
a2enmod dav_fs dav auth_digest headers
service apache2 restart
chmod 777 /var/www/html/config
chmod 777 /var/www/html/screenshots
cd /var/www/html
sudo ln -s /usr/share/phpsysinfo phpsysinfo


## install / configure nginx
mkdir /root/nginx
cd /root/nginx
git clone https://github.com/sergey-dryabzhinsky/nginx-rtmp-module.git
wget http://nginx.org/download/nginx-1.15.8.tar.gz
tar -xf nginx-1.15.8.tar.gz
cd nginx-1.15.8
./configure --with-http_ssl_module --add-module=../nginx-rtmp-module
make -j 4
sudo make install
mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.old
cp /var/www/html/config/nginx.conf /usr/local/nginx/conf/nginx.conf
mkdir /var/log/nginx
touch /var/log/nginx/error.log
sh /var/www/html/nginx_start.sh


## wrap up
source /root/.bashrc