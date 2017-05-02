#!/bin/bash

awk '{print $1}' run.log | sort > log
[ -n "$1" ] && cat $1 >> query && rm $1
awk 'NR==FNR{a[$0]=1;next}!a[$0]' log query > new_query
sort -u new_query > query
rm log new_query
