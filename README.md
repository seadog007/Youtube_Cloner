# Youtube Cloner
A project that can let you mirror Youtube to your Google Drive from the video list you give.

In the project, there are several shell script.
- all_auto.sh
- clean.sh
- covert_subscribed_2_id.sh
- del.sh
- download.sh
- fetch_new_channel_form_home_page.sh
- mkdir.sh
- unique.sh

### all_auto.sh
Do all process automatically.  
```
Usage: ./all_auto.sh [any]
```  
If there is a argument, then it will also fetch new channel from the home page to `subscribed`, and add new video to `query`.  
Then download all video in the `query`

### clean.sh
Clean the query list, remove downloaded videos, and it also can adding new list into the query.  
```
Usage: ./clean.sh <query> [add_to_query]
```
If `add_to_query` exist, then it will add the list to query  
Below is what I usually do  
`./clean.sh query query2`

### covert_subscribed_2_id.sh
Covert the subscribed list to video id list.  
```
Usage: ./covert_subscribed_2_id.sh <subscribed_list> <query>
```
Dependence: Changed version of mevdschee/youtube-playlist-extractor

### del.sh
Delete undeleted folder due to error from Google Drive.  
```
Usage: ./del.sh <error.log>
```

### download.sh
Download videos from query list.  
```
Usage: ./download.sh <query>
```

### fetch_new_channel_form_home_page.sh
Fetch new channels from Youtube home page to subscribed list.  
```
Usage: ./fetch_new_channel_form_home_page.sh <subscribed_list>
```

### mkdir.sh
Inital process, which create folders of `{a..z} {A..Z} {0..9} - _` combinations, and depth of 2, and output a json to stdout.  
_**Notice: There might have some uncreated folder that you need to create manually.**_

### unique.sh
Basically an alias of `sort -u` to the same file.  
```
Usage: ./unique.sh <file_you_want_to_unique>
```
