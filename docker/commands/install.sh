#!/bin/bash

# globals
DOCKER="${1}/docker"
TEMPLATE="${DOCKER}/template"

# resolve the main settings
ENABLED="${DOCKER}/enabled"
mkdir -p ${ENABLED}
touch "${ENABLED}/${2}"

# create dir to receive the app
SOURCE="${1}/${2}/app"
mkdir -p ${SOURCE}

# create and configure the bare repo
REPO="${1}/${2}/app.git"
mkdir -p ${REPO}
cd ${REPO}
git init --bare
touch "hooks/post-receive"
chmod +x "hooks/post-receive"

# create a temp repo to push first changes
TEMP="${1}/${2}/temp"
mkdir -p ${TEMP}
cd ${TEMP}
git init && git remote add origin ${REPO}
touch "index.html" "docker-compose.yml"
git add --all && git commit -m "Install" && git push -u origin master
rm -rf ${TEMP}
