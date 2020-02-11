#!/bin/bash

# set vars

# kernel
KERNEL=$(uname -r)

# hostname
HOSTNAME=$(hostname);

# uptime
UPTIME="$(awk '{print $1}' /proc/uptime)";

# ssh port
SSHPORT="$(sshd -T | head -n 1 | awk '{print $2}')";

# cpu model
CPU_MODEL=$(cat /proc/cpuinfo | grep 'model name' | awk -F\: '{print $2}' | uniq)

# cpu cores
CPU_CORES=$(cat /proc/cpuinfo | grep processor | wc -l)

# cpu speed
CPU_SPEED=$(lscpu | grep 'CPU MHz' | awk -F\: '{print $2}' | sed -e 's/^ *//g' -e 's/ *$//g')

# cpu usage
CPU_USAGE="$(grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage "%"}')";

# total ram
RAM_TOTAL="$(cat /proc/meminfo | grep ^MemTotal: | awk '{print $2}')";

# ram usage
RAM_USAGE="$(free -m | awk 'NR==2{printf "%.2f%%", $3*100/$2 }' | sed 's/ //g')";

# hard drive usage
DISK_USAGE="$(df -h | awk '$NF=="/"{printf "%s", $5}')";

# network / bandwidth stats
IPADDRESS="$(ip addr | grep 'state UP' -A2 | tail -n1 | awk '{print $2}' | cut -f1  -d'/')";
# IPADDRESS="$(hostname -i)";

echo "--------------------------------------"
echo "  SlipStream CMS System Check Script  "
echo "--------------------------------------"
echo " "
echo "Checking NGINX HTTP Server:"
nginx_status=$(ps aux | grep nginx | grep -v 'grep' | wc -l)
if [ "$nginx_status" -eq "0" ]; then
	echo "Status .......................................... \e[31mOFFLINE\e[0m"
else
	echo "Status .......................................... \e[32mONLINE\e[0m"
fi

nginx_conf_file=/usr/local/nginx/conf/nginx.conf
if test -f "$nginx_conf_file"; then
	HTTPPORT=$(cat /usr/local/nginx/conf/nginx.conf | grep listen | sed -n '2p' | sed 's/[^0-9]*//g');
    echo "Config File ..................................... \e[32mFOUND\e[0m"
else
	HTTPPORT="ERROR"
	echo "Config File ..................................... \e[31mNO FOUND\e[0m"
fi

echo " "

echo "Checking MySQL Database Server: "
mysql_status=$(ps aux | grep mysql | grep -v 'grep' | wc -l)
if [ "$mysql_status" -eq "0" ]; then
	echo "Status .......................................... \e[31mOFFLINE\e[0m"
else
	echo "Status .......................................... \e[32mONLINE\e[0m"
fi

DBNAME="mysql"
DBEXISTS=$(mysql -uslipstream -padmin1372 --batch --skip-column-names -e "SHOW DATABASES LIKE '"$DBNAME"';" | grep "$DBNAME" > /dev/null; echo "$?")
if [ $DBEXISTS -eq 0 ];then
    echo "Access .......................................... \e[32mGRANTED\e[0m"
else
    echo "Access .......................................... \e[31mDENIED\e[0m"
fi

echo " "

echo "Checking SlipStream CMS: "
cms_folder=/var/www/html/portal
if [ -d "$cms_folder" ]; then
    echo "CMS is .......................................... \e[32mINSTALLED\e[0m"
else
	echo "CMS is .......................................... \e[31mNOT INSTALLED\e[0m"
fi

DBNAME="slipstream_cms"
DBEXISTS=$(mysql -uslipstream -padmin1372 --batch --skip-column-names -e "SHOW DATABASES LIKE '"$DBNAME"';" | grep "$DBNAME" > /dev/null; echo "$?")
if [ $DBEXISTS -eq 0 ];then
    echo "CMS Database .................................... \e[32mFOUND\e[0m"
else
    echo "CMS Database .................................... \e[31mMISSING\e[0m"
fi

echo " "

echo "Checking SlipStream Streaming Server: "
node_folder=/root/slipstream/node
if [ -d "$node_folder" ]; then
    echo "Node is ......................................... \e[32mINSTALLED\e[0m"
else
	echo "Node is ......................................... \e[31mNOT INSTALLED\e[0m"
fi

ss_conf_file=/root/slipstream/node/config.json
if test -f "$ss_conf_file"; then
    echo "Config File ..................................... \e[32mFOUND\e[0m"
else
	echo "Config File ..................................... \e[31mNO FOUND\e[0m"
fi

USERNAME_RAW=$(echo "SELECT username FROM users" | mysql slipstream_cms -u slipstream -padmin1372)
USERNAME="$(echo $USERNAME_RAW | sed -e "s/username //g")";

PASSWORD_RAW=$(echo "SELECT password FROM users" | mysql slipstream_cms -u slipstream -padmin1372)
PASSWORD="$(echo $PASSWORD_RAW | sed -e "s/password //g")";

echo " "

echo "CMS Panel URL: http://"$IPADDRESS":"$HTTPPORT"/portal"
echo "Username: "$USERNAME
echo "Password: "$PASSWORD

echo " "