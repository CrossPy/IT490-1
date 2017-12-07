v=$1
env=$2
echo $env

pass="it490sucks"

apiD="192.168.1.104"
apiQ="192.168.1.105"
apiP="192.168.1.106"

dbD="192.168.1.107"
dbQ="192.168.1.108"
dbP="192.168.1.109"

webD="192.168.1.101"
webQ="192.168.1.102"
webP="192.168.1.103"

apiLoc="/home/nick/IT490"
dbLoc="/home/steve/IT490"
webLoc="/home/omer/IT490"

apiUser="nick"
dbUser="steve"
webUser="omer"


if [ $env="-d" ];
then
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$dbUser"@"$dbD":"$dbLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$apiUser"@"$apiD":"$apiLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$webUser"@"$webD":"$webLoc"
	exit 
fi

if [ $env="-q" ];
then
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$dbUser"@"$dbD":"$dbLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$apiUser"@"$apiD":"$apiLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$webUser"@"$webD":"$webLoc"
	exit
fi

if [ $env="-p" ];
then
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$dbUser"@"$dbD":"$dbLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$apiUser"@"$apiD":"$apiLoc"
	sudo sshpass -p '$pass' rsync -r -e ssh "./releases/$v" "$webUser"@"$webD":"$webLoc"
	exit
fi 

