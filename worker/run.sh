#!/bin/bash

host=0
port=12345

function sendreq(){
gpg -o - --clearsign <(echo req) | base64 | tr -d '\n' | nc $host $port
}

function sendres(){
gpg -o - --clearsign <(echo res) | base64 | tr -d '\n' | cat - <(echo -e "\n$1,$2")| nc $host $port
}

sendreq
#sendres vid fid
