#!/bin/bash

BASE=$1
DOMAIN=$2
up="${BASE}/docker/php/up.php"

php ${up} b=${BASE} d=${DOMAIN}
