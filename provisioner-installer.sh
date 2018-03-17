#!/bin/bash
sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

echo -e "\e[0;32mUpgrade The Base Packages \e[0m"

export DEBIAN_FRONTEND=noninteractive
apt-get update > /dev/null 2>&1
apt-get upgrade -y > /dev/null 2>&1

echo -e "\e[0;32mAdd A Few PPAs To Stay Current \e[0m"

apt-get install -y --force-yes software-properties-common > /dev/null 2>&1

LC_ALL=C.UTF-8 apt-add-repository ppa:chris-lea/redis-server -y > /dev/null 2>&1
LC_ALL=C.UTF-8 apt-add-repository ppa:ondrej/apache2 -y > /dev/null 2>&1
LC_ALL=C.UTF-8 apt-add-repository ppa:ondrej/php -y > /dev/null 2>&1

echo -e "\e[0;32mUpgrade Packages \e[0m"

apt-get update > /dev/null 2>&1
apt-get upgrade -y > /dev/null 2>&1

echo -e "\e[0;32mInstall PHP CLI \e[0m"

apt-get install -y --force-yes php7.2-cli  > /dev/null 2>&1

echo -e "\e[0;32mInstall Composer \e[0m"
curl -sS https://getcomposer.org/installer | php  > /dev/null 2>&1
mv composer.phar /usr/local/bin/composer

echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin:$HOME/.composer/vendor/bin"' >> ~/.bashrc

. ~/.bashrc  > /dev/null 2>&1

echo -e "\e[0;32mInstall Provisioner \e[0m"

composer global require kabbouchi/provisioner:dev-master  > /dev/null 2>&1