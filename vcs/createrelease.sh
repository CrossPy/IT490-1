#/bin/bash

V=$1
mkdir "./releases/$V"
git pull
rsync -Rr ../ ./releases/$V


