#!/bin/bash

if [[ $EUID -ne 0 ]]; then
    echo "You need to be root to install prerequisites"
fi

apt-get update && apt-get install -y php5-dev

# Let's install scrypt if it doesn't already exist
SCRYPTINSTALLED=`rgrep scrypt.so /etc/php5 | (wc -l)` >/dev/null 2>&1
if [[ $SCRYPTINSTALLED -ne 0 ]]; then
    echo "scrypt already installed"
else
    yes | pecl install scrypt
    echo "extension=scrypt.so" > /etc/php5/mods-available/scrypt.ini
    php5enmod scrypt
fi
# Let's install libsodium if it doesn't already exist
SODIUMINSTALLED=`rgrep sodium.so /etc/php5 | (wc -l)` >/dev/null 2>&1
if [[ $SODIUMINSTALLED -ne 0 ]]; then
    echo "The PHP libsodium extension is already installed"
else
    yes | pecl install sodium
    echo "extension=sodium.so" > /etc/php5/mods-available/sodium.ini
    php5enmod sodium
fi

if [[ -d /etc/php5/fpm ]]; then
    service php5-fpm restart
fi
if [[ -d /etc/php5/apache2 ]]; then
    service apache2 restart
fi
