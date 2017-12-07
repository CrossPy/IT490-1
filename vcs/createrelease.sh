#/bin/bash

V=$1
echo $V
mkdir "./releases/$V"

git pull

cp -r ../ ./releases/$V


