#!/bin/bash

[ -z "$2" ] && echo 'Usage: ./covert_subscribed_2_id.sh <subscribed_list> <query>' && exit 1

while read line
do
echo $line
curl -s "http://v4.srv.seadog007.me/youtube-playlist-extractor/channel.php?channel=$line" >> $2
done < $1
