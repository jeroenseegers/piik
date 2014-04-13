#!/usr/bin/env sh

# Check if we're using Raspbian
if [[ ! -f /etc/dpkg/origins/raspbian ]]; then
    printf "%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit;
fi

# Check if we need to install git
hash git 2>/dev/null || {
    printf "%s" "git not found, installing...";
    sudo apt-get -y install git > /dev/null && printf "%s\n" " Done";
}

# Check if we need to install nginx
hash nginx 2>/dev/null || {
    printf "%s" "nginx not found, installing...";
    sudo apt-get -y install nginx > /dev/null && printf "%s\n" " Done";
}

# Check if we need to install php
hash php 2>/dev/null || {
    printf "%s" "php not found, installing...";
    sudo apt-get -y install php5 php5-fpm > /dev/null && printf "%s\n" " Done";
}
