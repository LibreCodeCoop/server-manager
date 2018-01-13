#!/bin/bash

DIR=$(dirname "$0")
SITE=$1

cd $DIR/$SITE/app

docker-compose down
