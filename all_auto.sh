#!/bin/bash

if [ -n "$1" ]
then
	./fetch_new_channels_from_home_page.sh subscribed
	./unique.sh subscribed
	./covert_subscribed_2_id.sh subscribed query2
	./clean.sh query query2
else
	./clean.sh query
fi
./download.sh query
./del.sh error.log
./clean.sh query
