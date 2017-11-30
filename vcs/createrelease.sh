#/bin/bash

V=$1
echo $V
mkdir "./releases/$V"

cd /home/steve/IT490

git pull

cd ../vcs

cp -r /home/steve/IT490 ./releases/$V


