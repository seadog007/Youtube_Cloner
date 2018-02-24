#!/bin/bash

source ./config.sh
mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -N -B -e 'SELECT `vid` FROM `videos` WHERE `status`=0 AND `removed_reason` IS NULL;' | \
	while read id
	do
		echo "Checking $id"
		stat=`curl -s 'https://content.googleapis.com/youtube/v3/videos?part=snippet&key='$YT_API_KEY'&id='$id | jq -r 'if (.pageInfo.totalResults)==(.items | length) then 1 else 0 end'`
		[ $stat -eq 1 ] && \
			mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -e 'UPDATE `videos` SET `status`=1, `disappear_time`=NULL, `video_name`=NULL, `removed_reason`=NULL WHERE `vid`="'$id'";' && \
			echo "Fixed error from $id" || echo "Please check $id"
	done
