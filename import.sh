#!/bin/bash

source ./config.sh

echo 'START TRANSACTION;' > tmp.sql
awk 'length($1)==11{print "INSERT IGNORE INTO `videos` (`vid`, `fid`, `import_time`) VALUES (\""$1"\", \""$6"\", NOW());"}' run.log >> tmp.sql
echo 'COMMIT;' >> tmp.sql
mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' < tmp.sql
rm tmp.sql
