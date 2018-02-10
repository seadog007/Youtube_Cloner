#!/bin/bash

source ./config.sh

mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -N -B -e 'SELECT `vid` FROM `videos` WHERE `status`=0 AND `video_name` IS NULL;' | \
	while read id
	do
		name=`./id2name.sh $id`
		[ -n "$name" ] && mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -e 'UPDATE `videos` SET `video_name`="'"$name"'" WHERE `vid`="'$id'";' && echo "Wrote the name of $id success"
	done
