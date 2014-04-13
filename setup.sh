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
        printf "%s\n" "Checking if installation of $application is needed.." >> /tmp/piik_install.log;
        if ! hash $application 2>/dev/null; then
            printf "%s" "$application not found, installing...";
            if sudo apt-get -y install $application >> /tmp/piik_install.log 2>&1; then
                printf "%s\n" " Done";
            else
                printf "%s\n" " Error";
                printf "%s\n" "See /tmp/piik_install.log for more information";
                exit 1;
            fi
        fi
        printf "%s\n\n" "$application installed." >> /tmp/piik_install.log;
    done
}

maybe_install git nginx php5 php5-fpm
