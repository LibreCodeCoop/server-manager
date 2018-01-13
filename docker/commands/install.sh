#!/bin/bash

DIR=$(dirname "$0")
SITE=$1

DOCKER = "~/docker"
APP = "~/$SITE"

mkdir -p "$APP/app.git"
git init --bare
