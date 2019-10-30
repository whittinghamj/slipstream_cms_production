#!/bin/bash
docker stop $(docker ps -a -q)
/usr/bin/docker run -d --net=host --restart always stalker-5.2 bash -c '/etc/init.d/apache2 restart; tail -f /dev/null'
