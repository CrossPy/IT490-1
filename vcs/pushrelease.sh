v=$1
env=$2

pass="it490sucks"

apiD="192.168.1.25"
apiQ=""
apiP=""

dbD=""
dbQ=""
dbP=""

mqD=""
dbQ=""
dbP=""

webD="192.168.1.111"
webQ=""
webP=""


if [ $env="-d" ];
then
	sshpass -p "$pass" scp -r -oStrictHostKeyChecking=no "./releases/$v/IT490/api/" "nick@$apiD":/home/nick/
	sshpass -p "$pass" scp -r -oStrictHostKeyChecking=no "./releases/$v/" "steve@$dbD":/home/steve/
	sshpass -p "$pass" scp -r -oStrictHostKeyChecking=no "./releases/$v/IT490/web/src/" "god@$webD":/var/www/
	exit 
fi

if [ $env="-q" ];
then
	sshpass -p "$pass" scp -r -oStrictHostKeyChecking=no "./releases/$v/IT490/api/" "nick@$apiQ":/home/nick/ 
fi

if [ $env="-p" ];
then
	sshpass -p "$pass" scp -r -oStrictHostKeyChecking=no "./releases/$v/IT490/api/" "nick@$apiP":/home/nick/  
fi 

