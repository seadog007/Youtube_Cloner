#!/bin/bash

MAX_RETRY=5

function log(){
echo "$1" >> log
}

function distribute(){
echo "$vid"
newline="$vid,$lock_time,$retry"
sed -i -e "s/$line/$newline/g" query
exit 0
}

function req(){
while read line
do
	while IFS=',' read -ra data
	do
		vid=${data[0]}
		lock_until=${data[1]}
		retried=${data[2]}

		now=`date "+%s"`
		lock_time=$(($now + 43200))
		retry=0

		if [ -n "$lock_until" ]
		then
			if [ $lock_until -lt $now ]
			then
				log "lock of $vid expired, trying to re-distribute this" && retry=$(($retried + 1))
				if [ $retry -gt $MAX_RETRY ]
				then
					log "Re-distribute $vid failed: reach max retry"
					lock_time=9999999999
				else
					distribute
				fi
			fi
		else
			log "${data[0]} with no lock, distribute it"
			distribute
		fi
	done <<< "$line"
done < query
log "Nothing to distribute"
echo "NULL"
}

function res(){
read line
while IFS=',' read -ra data
do
	for i in "${data[@]}"
	do
		echo process "$i"
	done
done <<< "$line"
}

read line
[ "$line" == "req" ] && req
[ "$line" == "res" ] && res

