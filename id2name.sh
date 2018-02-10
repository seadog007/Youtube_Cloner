#!/bin/bash

gdrive info `gdrive list -q "name contains '$1'" | grep '\-.\{11\}\.webm' | head -n1 | awk '{print $1}'` | sed -n 2p | grep -oP 'Name:\ \K.*(?=-.{11}\.webm)'
