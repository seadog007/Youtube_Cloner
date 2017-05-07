#!/bin/bash

[ -z "$1" ] && echo 'Usage: ./fetch_new_channel_form_home_page.sh <subscribed_list>' && exit 1

curl -s https://www.youtube.com/ | grep -oP 'channel/UC.*?"' | sed -e 's/channel\///g' -e 's/"//g' >> $1
