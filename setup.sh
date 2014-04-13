#!/usr/bin/env sh

# Check if we're using Raspbian
if [[ ! -f /etc/dpkg/origins/raspbian ]]; then
    printf "%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit;
fi

printf "" > /tmp/piik_install.log;

# Check if we need to install git
hash git 2>/dev/null || {
    printf "%s" "git not found, installing...";
    sudo apt-get -y install git >> /tmp/piik_install.log && printf "%s\n" " Done";
}

# Check if we need to install nginx
hash nginx 2>/dev/null || {
    printf "%s" "nginx not found, installing...";
    sudo apt-get -y install nginx >> /tmp/piik_install.log && printf "%s\n" " Done";
}

# Check if we need to install php
hash php 2>/dev/null || {
    printf "%s" "php not found, installing...";
    sudo apt-get -y install php5 >> /tmp/piik_install.log && printf "%s\n" " Done";
}

# Check if we need to install php-fpm
hash php5-fpm 2>/dev/null || {
    printf "%s" "php5-fpm not found, installing...";
    sudo apt-get -y install php5-fpm >> /tmp/piik_install.log && printf "%s\n" " Done";
}
