#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# SlipStream CMS Main Server Un-Installer
#===========================================================


## set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/slipstream.log


## set shell silent installer mode
export DEBIAN_FRONTEND=noninteractive


## set starting point
cd /root


## start the installer
echo "-------------------------------------------"
echo "  SlipStream CMS Main Server Un-Installer  "
echo "-------------------------------------------"
echo " "
echo " "

echo -n "#"
wget -O /etc/apt/apt.conf.d/71debconf http://slipstreamiptv.com/downloads/71debconf &> $LOG
echo -n "#"
service apparmor stop &> $LOG
echo -n "#"
update-rc.d -f apparmor remove &> $LOG
echo -n "#"
apt-get remove -qq -y apparmor apparmor-utils &> $LOG
echo -n "#"
apt-get purge -qq -y postfix &> $LOG
echo -n "#"
apt-get purge -qq -y postfix-mysql &> $LOG
echo -n "#"
apt-get purge -qq -y postfix-doc &> $LOG
echo -n "#"
apt-get purge -qq -y mariadb-client &> $LOG
echo -n "#"
apt-get purge -qq -y mariadb-server &> $LOG
echo -n "#"
apt-get purge -qq -y openssl &> $LOG
echo -n "#"
apt-get purge -qq -y getmail4 &> $LOG
echo -n "#"
apt-get purge -qq -y rkhunter &> $LOG
echo -n "#"
apt-get purge -qq -y binutils &> $LOG
echo -n "#"
apt-get purge -qq -y dovecot-imapd &> $LOG
echo -n "#"
apt-get purge -qq -y dovecot-pop3d &> $LOG
echo -n "#"
apt-get purge -qq -y dovecot-mysql &> $LOG
echo -n "#"
apt-get purge -qq -y dovecot-sieve &> $LOG
echo -n "#"
apt-get purge -qq -y dovecot-lmtpd &> $LOG
echo -n "#"
apt-get purge -qq -y  &> $LOG
echo -n "#"
apt-get purge -qq -y amavisd-new &> $LOG
echo -n "#"
apt-get purge -qq -y spamassassin &> $LOG
echo -n "#"
apt-get purge -qq -y clamav &> $LOG
echo -n "#"
apt-get purge -qq -y clamav-daemon &> $LOG
echo -n "#"
apt-get purge -qq -y arj &> $LOG
echo -n "#"
apt-get purge -qq -y nomarch &> $LOG
echo -n "#"
apt-get purge -qq -y lzop &> $LOG
echo -n "#"
apt-get purge -qq -y cabextract &> $LOG
echo -n "#"
apt-get purge -qq -y apt-listchanges &> $LOG
echo -n "#"
apt-get purge -qq -y libnet-ldap-perl &> $LOG
echo -n "#"
apt-get purge -qq -y libauthen-sasl-perl &> $LOG
echo -n "#"
apt-get purge -qq -y clamav-docs &> $LOG
echo -n "#"
apt-get purge -qq -y daemon &> $LOG
echo -n "#"
apt-get purge -qq -y libio-string-perl &> $LOG
echo -n "#"
apt-get purge -qq -y libio-socket-ssl-perl &> $LOG
echo -n "#"
apt-get purge -qq -y libnet-ident-perl &> $LOG
echo -n "#"
apt-get purge -qq -y zip &> $LOG
echo -n "#"
apt-get purge -qq -y libnet-dns-perl &> $LOG
echo -n "#"
apt-get purge -qq -y postgrey &> $LOG
echo -n "#"
apt-get purge -qq -y libdbd-mysql-perl &> $LOG
echo -n "#"
apt-get purge -qq -y nginx &> $LOG
echo -n "#"
apt-get purge -qq -y apache2 &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-fpm &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2 &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-common &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-gd &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-mysql &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-imap &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-cli &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-cgi &> $LOG
echo -n "#"
apt-get purge -qq -y php-pear &> $LOG
echo -n "#"
apt-get purge -qq -y mcrypt &> $LOG
echo -n "#"
apt-get purge -qq -y imagemagick &> $LOG
echo -n "#"
apt-get purge -qq -y libruby &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-curl &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-intl &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-pspell &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-recode &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-sqlite3 &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-tidy &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-xmlrpc &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-xsl &> $LOG
echo -n "#"
apt-get purge -qq -y memcached &> $LOG
echo -n "#"
apt-get purge -qq -y php-memcache &> $LOG
echo -n "#"
apt-get purge -qq -y php-imagick &> $LOG
echo -n "#"
apt-get purge -qq -y php-gettext &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-zip &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-mbstring &> $LOG
echo -n "#"
apt-get purge -qq -y php-soap &> $LOG
echo -n "#"
apt-get purge -qq -y php7.2-soap &> $LOG
echo -n "#"
apt-get purge -qq -y fcgiwrap &> $LOG
echo -n "#"
apt-get purge -qq -y ffmpeg &> $LOG

rm -rf /opt/nginx/ &> $LOG
rm -rf /opt/slipstream/ &> $LOG
rm -rf /opt/ioncube/ &> $LOG
rm -rf /var/www/html/ &> $LOG
rm -rf /root/slipstream/ &> $LOG

/usr/local/nginx/sbin/nginx -s stop &> $LOG

killall nginx &> $LOG
killall ffmpeg &> $LOG

## clear
echo " "
echo "-------------"
echo "  Completed  "
echo "-------------"
echo " "
