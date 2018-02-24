#!/bin/bash

curl -s -H 'Cookie: PREF=al=en;' 'https://www.youtube.com/watch?v='$1 | tr -d '\n'| grep -oP '<h1 id="unavailable-message" class="message">\s+((.*?&quot;)?)+\K.*(?=</h1>)' | sed "s/&#39;/'/g"
