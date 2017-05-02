#!/bin/bash

while read line
do
echo $line
curl -s "http://v4.srv.seadog007.me/youtube-playlist-extractor/channel.php?channel=$line" >> query2
done < subscribed
./clean.sh
