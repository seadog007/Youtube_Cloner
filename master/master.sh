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
	echo "${data[1]} success uploaded, folder id: ${data[1]}" >> ../run.log
done <<< "$line"
}

function main(){
cmd=`echo "$data" | grep -v '\[GNUPG:\]' | head -n1`
[ "$cmd" == "req" ] && req
[ "$cmd" == "res" ] && res
}

function vaild(){
read vaild_data
key=`echo $vaild_data | awk '{print $1}'`
while read vailded_key
do
	[ "$key" == "$vailded_key" ] && return 0
done < keys
echo "Go away Hacker"
return 1
}

read gpg_data
data=`echo "$gpg_data" | base64 -d | gpg --status-fd 1 --decrypt 2>/dev/null`
echo "$data" | grep '\[GNUPG:\] VALIDSIG' | tail -n1 | awk '{print $3, $5}' | vaild && main
