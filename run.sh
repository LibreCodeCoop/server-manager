#!/bin/bash

DIR=$(dirname "$0")
source $DIR/colors


yellow "[1/8] ~> Install dependencies to install docker"
apt-get install -y apt-transport-https ca-certificates curl software-properties-common
yellow "[2/8] ~> Add key of docker repository"
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
yellow "[3/8] ~> Add docker repository to system"
add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu artful stable"
yellow "[4/8] ~> Update system repositories sources"
apt-get update
yellow "[5/8] ~> Install docker-ce version ${1}"
apt-get install -y docker-ce=$1
apt-get autoremove -y
yellow "[6/8] ~> Add user '${2}' to system"
EXISTS=$(grep -c ^${2}: /etc/passwd)
if [ "$EXISTS" = '0' ]; then
  adduser $2
  mkdir -p /home/$2/.ssh/
  cp ~/.ssh/authorized_keys /home/$2/.ssh/
  chmod 755 /home/$2/.ssh/authorized_keys
  chown -R $2:$2 /home/$2/.ssh/authorized_keys
fi
SSH=$(grep -c ^AllowUsers.*${2}: /etc/ssh/sshd_config)
if [ "$EXISTS" = '0' ]; then
  printf '\n%s %s\n' 'AllowUsers' $2 >> /etc/ssh/sshd_config
  service ssh reload
fi
yellow "[7/8] ~> Add '${2}' to docker group"
usermod -aG docker $2
yellow '[8/8] ~> Enable docker on system'
systemctl enable docker

if [ "${4}" = 'yes' ]; then
  yellow "[locale] ~> Fix server locale"
  apt-get install -y language-pack-pt
  locale-gen en_US en_US.UTF-8 pt_BR.UTF-8
  dpkg-reconfigure locales
fi

INSTALLED=$(docker -v)
blue "[done] ~> docker -v: $INSTALLED"
blue '[reboot] ~> Reboot your system!!'
if [ "${3}" = 'yes' ]; then
  red 'Bye Bye!'
  reboot
fi
