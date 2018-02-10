#!/bin/bash

source ./config.sh

mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -N -B -e 'SELECT `vid` FROM `videos` WHERE `status`=1;' | \
	while read id
	do
		echo "Checking $id"
		stat=`curl -s 'https://content.googleapis.com/youtube/v3/videos?part=snippet&key='$YT_API_KEY'&id='$id | jq -r 'if (.pageInfo.totalResults)==(.items | length) then 1 else 0 end'`
		[ $stat -eq 0 ] && \
			mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -e 'UPDATE `videos` SET `status`=0, `last_check`=NOW(), `disappear_time`=NOW() WHERE `vid`="'$id'";' || \
			mysql -u"$MYSQL_USER" -p"$MYSQL_PASS" -D 'youtube_dump' -e 'UPDATE `videos` SET `last_check`=NOW() WHERE `vid`="'$id'";'
	done

./fetch_removed_videos_name.sh
