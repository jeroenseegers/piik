#!/usr/bin/env sh

INSTALL_DIR="/opt/piik"

# Check if we're using Raspbian
if [ ! -f /etc/dpkg/origins/raspbian ]; then
    printf "%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit 1;
fi

printf "" > /tmp/piik_install.log;

maybe_install() {
    for APPLICATION in $@; do
        printf "%s\n" "Checking if installation of $APPLICATION is needed.." >> /tmp/piik_install.log;
        if ! hash $APPLICATION 2>/dev/null; then
            printf "%s" "$APPLICATION not found, installing...";
            if sudo apt-get -y install $APPLICATION >> /tmp/piik_install.log 2>&1; then
                printf "%s\n" " Done";
            else
                printf "%s\n" " Error";
                printf "%s\n" "See /tmp/piik_install.log for more information";
                exit 1;
            fi
        fi
        printf "%s\n\n" "$APPLICATION installed." >> /tmp/piik_install.log;
    done
}

# Install dependencies
maybe_install git nginx php5 php5-fpm

# Install piik
printf "%s" "Installing piik to $INSTALL_DIR"
if git clone git@github.com:jeroenseegers/piik.git $INSTALL_DIR >> /tmp/piik_install.log 2>&1; then
    printf "%s\n" " Done";
else
    printf "%s\n" " Error";
    printf "%s\n" "See /tmp/piik_install.log for more information";
    exit 1;
fi
