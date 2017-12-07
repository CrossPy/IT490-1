#/bin/bash

V=$1
echo $V
mkdir "./releases/$V"
git pull
cd ..
cp -R . ./vcs/releases/$V


