while read line 
do
while read line; do gdrive delete -r $line; done
done < $1
