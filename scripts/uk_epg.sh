#!/bin/bash

#CRONTAB
# 00 3,15 * * * sh /var/www/html/portal/scripts/uk_epg.sh


wget http://www.xmltvepg.nl/rytecUK_Basic.xz -O /var/www/html/epg/rytecUK_Basic.xz
unxz < /var/www/html/epg/rytecUK_Basic.xz > /var/www/html/epg/uk_basic.xml

wget http://www.xmltvepg.nl/rytecUK_FTA.xz -O /var/www/html/epg/rytecUK_FTA.xz
unxz < /var/www/html/epg/rytecUK_FTA.xz > /var/www/html/epg/uk_fta.xml

wget http://www.xmltvepg.nl/rytecUK_SkyLive.xz -O /var/www/html/epg/rytecUK_SkyLive.xz
unxz < /var/www/html/epg/rytecUK_SkyLive.xz > /var/www/html/epg/uk_sky.xml

wget http://www.xmltvepg.nl/rytecUK_SkyDead.xz -O /var/www/html/epg/rytecUK_SkyDead.xz
unxz < /var/www/html/epg/rytecUK_SkyDead.xz > /var/www/html/epg/uk_sky_dead.xml

wget http://www.xmltvepg.nl/rytecUK_SportMovies.xz -O /var/www/html/epg/rytecUK_SportMovies.xz
unxz < /var/www/html/epg/rytecUK_SportMovies.xz > /var/www/html/epg/uk_sky_sports_movies.xml

wget http://www.xmltvepg.nl/rytecUK_int.xz -O /var/www/html/epg/rytecUK_int.xz
unxz < /var/www/html/epg/rytecUK_int.xz > /var/www/html/epg/uk_int.xml

wget http://www.xmltvepg.nl/rytecNWS.xz -O /var/www/html/epg/rytecNWS.xz
unxz < /var/www/html/epg/rytecNWS.xz > /var/www/html/epg/uk_nws.xml