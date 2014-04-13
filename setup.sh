#!/usr/bin/env sh

LOGFILE="/tmp/piik_install.log"
INSTALL_DIR="/opt/piik"
REPOSITORY_URL="https://github.com/jeroenseegers/piik.git"

# Check if we're using Raspbian
if [ ! -f /etc/dpkg/origins/raspbian ]; then
    printf "%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit 1;
fi

printf "" > $LOGFILE;

maybe_install() {
    for APPLICATION in $@; do
        printf "%s\n" "Checking if installation of $APPLICATION is needed.." >> $LOGFILE;
        if ! hash $APPLICATION 2>/dev/null; then
            printf "%s" "$APPLICATION not found, installing...";
            if sudo apt-get -y install $APPLICATION >> $LOGFILE 2>&1; then
                printf "%s\n" " Done";
            else
                printf "%s\n" " Error";
                printf "%s\n" "See $LOGFILE for more information";
                exit 1;
            fi
        fi
        printf "%s\n\n" "$APPLICATION installed." >> $LOGFILE;
    done
}

# Install dependencies
maybe_install git nginx php5 php5-fpm

# Establish initial github connection
printf "%s\n" "Checking connection to github" >> $LOGFILE;
ssh -T git@github.com >> $LOGFILE 2>&1;

# Install piik
printf "%s" "Installing piik to $INSTALL_DIR"
if git clone $REPOSITORY_URL $INSTALL_DIR >> $LOGFILE 2>&1; then
    printf "%s\n" " Done";
else
    printf "%s\n" " Error";
    printf "%s\n" "See $LOGFILE for more information";
    exit 1;
fi
