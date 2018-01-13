#!/bin/bash

DOCKER="${1}/docker"
ENABLED="${DOCKER}/enabled"
TEMPLATE="${DOCKER}/template"

mkdir -p ${ENABLED}
touch "${ENABLED}/${2}"

SOURCE="${1}/${2}/app"
REPO="${1}/${2}/app.git"
TEMP="${1}/${2}/temp"

mkdir -p ${SOURCE}
mkdir -p ${REPO}
mkdir -p ${TEMP}

cd ${REPO}
git init --bare

touch "${REPO}/hooks/post-receive"

cd ${TEMP}
git init && git remote add origin ${REPO}
touch "index.html" "docker-compose.yml"
git add --all && git commit -m "Install" && git push -u origin master
rm -rf ${TEMP}
