#!/bin/bash

file="docker-compose.yml"
docker-compose -f "${1}/docker/${file}" down
docker-compose -f "${1}/${2}/app/${file}" down
