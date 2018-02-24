#!/bin/bash

source ./config.sh

mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -N -B -e 'SELECT `vid` FROM `videos` WHERE `status`=0 AND `removed_reason` IS NULL;' | \
	while read id
	do
		reason=`./reason.sh $id`
		[ -n "$reason" ] && mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -e 'UPDATE `videos` SET `removed_reason`="'"$reason"'" WHERE `vid`="'$id'";' && echo "Wrote the name of $id success" || echo "$id has error"
	done
