#/bin/bash

V=$1
mkdir releases/"$V"
git pull
rsync -r ../ ./releases/$V/ --exclude vcs


