#!/bin/bash

[ -z "$1" ] && echo 'Usage: ./clean.sh <query> [add_to_query]' && exit 1
awk '{print $1}' run.log | sort > log
[ -n "$2" ] && cat "$2" >> "$1" && rm "$2"
awk 'NR==FNR{a[$0]=1;next}!a[$0]' log "$1" > new_query
sort -u new_query > "$1"
rm log new_query
