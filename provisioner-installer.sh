#!/bin/bash
sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

echo "Upgrade The Base Packages"

export DEBIAN_FRONTEND=noninteractive
apt-get update > /dev/null 2>&1
apt-get upgrade -y > /dev/null 2>&1

echo "Add A Few PPAs To Stay Current"

apt-get install -y --force-yes software-properties-common > /dev/null 2>&1

LC_ALL=C.UTF-8 apt-add-repository ppa:chris-lea/redis-server -y > /dev/null 2>&1
LC_ALL=C.UTF-8 apt-add-repository ppa:ondrej/apache2 -y > /dev/null 2>&1
LC_ALL=C.UTF-8 apt-add-repository ppa:ondrej/php -y > /dev/null 2>&1

echo "Upgrade Packages"

apt-get update > /dev/null 2>&1
apt-get upgrade -y > /dev/null 2>&1

echo "Install PHP CLI"

apt-get install -y --force-yes php7.2-cli  > /dev/null 2>&1

echo "Install Composer"
curl -sS https://getcomposer.org/installer | php  > /dev/null 2>&1
mv composer.phar /usr/local/bin/composer

echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin:$HOME/.composer/vendor/bin"' >> ~/.bashrc

. ~/.bashrc  > /dev/null 2>&1

echo "Install Provisioner"

composer global require kabbouchi/provisioner:dev-master  > /dev/null 2>&1