#!/bin/bash

curl -s https://www.youtube.com/ | grep -oP 'channel/UC.*?"' | sed -e 's/channel\///g' -e 's/"//g' >> $1
