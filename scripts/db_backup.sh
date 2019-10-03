#!/bin/bash

mysqldump -uroot -p'Mimi\!\#\&@' --single-transaction --all-databases | gzip > /root/slipstream_full_backup.sql.gz

mv /root/slipstream_full_backup.sql.gz /mnt/dropbox/slipstream_backups/"$(date +%Y-%m-%d_%H-%M)_slipstream_full_backup.sql.gz"