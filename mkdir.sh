#!/bin/bash
export LC_ALL=C # seems to improve performance by about 10%
shopt -s xpg_echo # 2% gain (against my expectations)
set {a..z} {A..Z} {0..9} - _
echo '{'
for a do
	echo '"'$a'": {'
	av=`gdrive mkdir -p 0B7GYRmQ_BOeKam5tNWRWZ3lETlE $a | sed -e "s/Directory\ //" -e "s/\ created//"`
	for b do
		bv=`gdrive mkdir -p $av $b | sed -e "s/Directory\ //" -e "s/\ created//"`
		echo '"'$b'": "'$bv'",'
		[ "$b" == "_" ] && echo '".": "'$av'"'
		sleep 0.2
	done
	echo '},'
done
echo '}'
