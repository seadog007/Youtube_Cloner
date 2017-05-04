#!/bin/bash

awk '{print $1}' run.log | sort > log
[ -n "$2" ] && cat "$2" >> "$1" && rm "$2"
awk 'NR==FNR{a[$0]=1;next}!a[$0]' log "$1" > new_query
sort -u new_query > "$1"
rm log new_query
