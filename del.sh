#!/bin/bash

[ -z "$1" ] && echo 'Usage: ./del.sh <error.log>' && exit 1

while read line 
do
while read line; do gdrive delete -r $line; done
done < $1
