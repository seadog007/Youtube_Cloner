#!/bin/bash
root=`pwd`
file=$1

function finish {
  echo "Cleaning up..."
  cd "$root"
  rm -rf tmp/*
  ./clean.sh "$file"
}
trap finish EXIT

[ -z "$1" ] && echo "Arg requeired" && exit 1
cd tmp
while read line
do
  echo $line
  if [ -z "`grep \"$(echo $line | sed 's/-/\\\\-/g')\" ../run.log`" ]
  then
    d=`date +%s`
    mkdir $d
    cd $d
    youtube-dl "https://www.youtube.com/watch?v=$line" --all-formats --all-subs >> /dev/null
    if [ $? -eq 0 ]
    then
      cd ..
      folder=''
      folder=`gdrive mkdir -p \`cat ../index.json | jq -r '."'${line:0:1}'"."'${line:1:1}'"'\` $line | sed -e "s/Directory\ //" -e "s/\ created//"` && gdrive sync upload $d $folder >> /dev/null
      if [ $? -ne 0 ]
      then
	echo $folder >> ../error.log
        gdrive delete -r $folder
        sleep 1
        gdrive delete -r $folder
        sleep 1
        gdrive delete -r $folder
        sleep 1
        gdrive delete -r $folder
        sleep 1
        gdrive delete -r $folder
        sleep 1
      else
        echo "$line success uploaded, folder id: $folder" >> ../run.log
      fi
    else
      cd ..
    fi
    rm -r $d
    sleep 0.5
  else
    echo "Already exist in the drive"
  fi
done < "../$file"
