#!/bin/bash
sudo docker exec $(docker ps -a -q) /bin/bash -c "cd /var/www/stalker_portal/server/tasks/; php ./update_epg.php;"