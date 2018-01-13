#!/usr/bin/env bash

DIR="$(dirname $0)"
BASE="$(readlink -f ~)"
ACTION=$1
DOMAIN=$2

WORKDIR=${BASE}/${DOMAIN}/app

source "${DIR}/colors"

sh "${DIR}/${ACTION}.sh" ${BASE} ${DOMAIN}>/dev/null 2>&1
