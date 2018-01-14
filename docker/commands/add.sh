#!/bin/bash

# globals
BASE=$1
DOMAIN=$2
DOCKER="${BASE}/docker"
replace="${DOCKER}/php/replace.php"
install="${DOCKER}/php/install.php"

# resolve the main settings
ENABLED="${DOCKER}/enabled"
mkdir -p ${ENABLED}
php ${install} b=${BASE} d=${DOMAIN}
php ${replace} b=${BASE} d=${DOMAIN} t=enabled/domain s=true
php ${replace} b=${BASE} d=${DOMAIN} t=docker-compose.yml s=true

# create dir to receive the app what will be write by git hook
SOURCE="${BASE}/${DOMAIN}/app"
mkdir -p ${SOURCE}

# create and configure the bare repo
REPO="${BASE}/${DOMAIN}/app.git"
mkdir -p ${REPO}
cd ${REPO}
git init --bare
php ${replace} b=${BASE} d=${DOMAIN} t=app.git/hooks/post-receive
chmod +x "hooks/post-receive"

# create a temp repo to push first changes
TEMP="${BASE}/${DOMAIN}/temp"
mkdir -p ${TEMP}
cd ${TEMP}
git init && git remote add origin ${REPO}
git config user.email "root@localhost" && git config user.name "Root"
php ${replace} b=${BASE} d=${DOMAIN} t=app/docker-compose.yml
php ${replace} b=${BASE} d=${DOMAIN} t=app/index.html
git add --all && git commit -m "Install" && git push -u origin master
rm -rf ${TEMP}
