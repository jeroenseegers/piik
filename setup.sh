#!/usr/bin/env sh

# Check if we're using Raspbian
if [[ ! -f /etc/dpkg/origins/raspbian ]]; then
    printf "%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit;
fi

printf "" > /tmp/piik_install.log;

# Check if we need to install git
maybe_install() {
    for application in $@; do
        hash $application 2>/dev/null || {
            printf "%s" "$application not found, installing...";
            sudo apt-get -y install $application >> /tmp/piik_install.log && printf "%s\n" " Done";
        }
    done
}

maybe_install git nginx php5 php5-fpm
