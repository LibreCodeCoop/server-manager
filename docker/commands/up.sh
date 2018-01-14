#!/bin/bash

file="docker-compose.yml"
docker-compose -f "${1}/${2}/app/${file}" up -d
docker-compose -f "${1}/docker/${file}" up -d
