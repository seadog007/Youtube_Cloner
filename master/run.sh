socat -v TCP-LISTEN:12345,fork,range=0.0.0.0/0 exec:'./master.sh'
