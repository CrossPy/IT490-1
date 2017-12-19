#!/bin/bash

serverIP=$1

while true;
do
	ping -c 1 $serverIP > /dev/null 2>&1
	if [ $? -ne 0 ]
	then
		dt=$(date)
		echo $dt": Taking over backend processing."
		php BackendServer.php
	fi
done
