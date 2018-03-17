#!/usr/bin/env bash
sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

# Upgrade The Base Packages

export DEBIAN_FRONTEND=noninteractive

apt-get update
apt-get upgrade -y

# Add A Few PPAs To Stay Current

apt-get install -y --force-yes software-properties-common

apt-add-repository ppa:chris-lea/redis-server -y
apt-add-repository ppa:ondrej/apache2 -y
apt-add-repository ppa:ondrej/php -y

apt-get update
apt-get upgrade -y

apt-get install -y --force-yes php7.2-cli

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

composer global require kabbouchi/provisioner:dev-master