#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# SlipStream CMS Password Reset
#===========================================================


## set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/slipstream.log


mysql -u root -padmin1372 -e "UPDATE slipstream_cms.users SET username = 'admin' WHERE id = '1'; "; &> $LOG
mysql -u root -padmin1372 -e "UPDATE slipstream_cms.users SET password = 'admin' WHERE id = '1'; "; &> $LOG


echo " "
echo "Your CMS login details have been reset."
echo " "
echo "Username: admin"
echo "Password: admin"
echo " "

