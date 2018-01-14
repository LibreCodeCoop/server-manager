#!/bin/bash

# globals
BASE=$1
DOMAIN=$2
DOCKER="${BASE}/sm/docker"
replace="${DOCKER}/php/helper/replace.php"
add="${DOCKER}/php/add.php"
enable="${DOCKER}/php/enable.php"

# create dir to receive the app what will be write by git hook
APP="${BASE}/app/${DOMAIN}"
mkdir -p ${APP}
touch ${APP}/.new

# create and configure the bare repo
REPO="${BASE}/repo/${DOMAIN}.git"
mkdir -p ${REPO}
cd ${REPO}
git init --bare
php ${replace} b=${BASE} d=${DOMAIN} t=repo/domain.git/hooks/post-receive
chmod +x "hooks/post-receive"

# create a temp repo to push first changes
TEMP="${BASE}/temp"
mkdir -p ${TEMP}
cd ${TEMP}
git init && git remote add origin ${REPO}
git config user.email "root@localhost" && git config user.name "Root"
php ${replace} b=${BASE} d=${DOMAIN} t=temp/docker-compose.yml
php ${replace} b=${BASE} d=${DOMAIN} t=temp/index.html
git add --all && git commit -m "Install" && git push -u origin master
rm -rf ${TEMP}

# resolve the main settings
ENABLED="${DOCKER}/enabled"
mkdir -p ${ENABLED}
php ${add} b=${BASE} d=${DOMAIN}
php ${replace} b=${BASE} d=${DOMAIN} t=enabled/domain s=true
php ${enable} b=${BASE} d=${DOMAIN}

echo ''
echo " ~> git clone ssh://${USER}@server/~/repo/${DOMAIN}.git"
echo ''
