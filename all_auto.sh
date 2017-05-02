#!/bin/bash

./fetch_new_channel_form_home_page.sh
./unique_subscribed.sh
./covert_subscribed_2_id.sh
./clean.sh query2
./download.sh < query
./del.sh
