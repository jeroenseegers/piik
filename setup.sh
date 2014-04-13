#!/usr/bin/env sh

LOGFILE="/tmp/piik_install.log";
INSTALL_DIR="/opt/piik";
REPOSITORY_URL="https://github.com/piik/piik.git";
IP_ADDRESS=$(hostname -I | tr -d ' ');

# Check if we're using Raspbian
if [ ! -f /etc/dpkg/origins/raspbian ]; then
    printf "\n%s\n" "Raspbian OS is needed for Piik to work. Please visit http://www.raspbian.org for more information.";
    exit 1;
fi

printf "" > $LOGFILE;

# Show introduction text for 5 seconds
printf "\n%s\n\n" "This script will install piik. Please be patient, it might take some time.";
sleep 5;

maybe_install() {
    for APPLICATION in $@; do
        printf "%s\n" "Checking if installation of $APPLICATION is needed.." >> $LOGFILE;
        if ! hash $APPLICATION 2>/dev/null; then
            printf "%s" "$APPLICATION not found, installing...";
            if sudo apt-get -y install $APPLICATION >> $LOGFILE 2>&1; then
                printf "%s\n" " [ ok ]";
            else
                printf "%s\n" " [ error ]";
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
printf "%s\n" "Checking connection to github..." >> $LOGFILE;
ssh -T git@github.com >> $LOGFILE 2>&1;

# Create piik installation directory
sudo mkdir $INSTALL_DIR;
sudo chown -R pi:www-data $INSTALL_DIR;

# Install piik
printf "%s" "Installing piik to $INSTALL_DIR..."
if git clone $REPOSITORY_URL $INSTALL_DIR >> $LOGFILE 2>&1; then
    printf "%s\n" " [ ok ]";
else
    printf "%s\n" " [ error ]";
    printf "%s\n" "See $LOGFILE for more information";
    exit 1;
fi

# Install nginx config file
sudo cp $INSTALL_DIR/etc/piik.ngx /etc/nginx/sites-available/piik.ngx;
sudo ln -s /etc/nginx/sites-available/piik.ngx /etc/nginx/sites-enabled/piik.ngx;

# Create logfiles
sudo mkdir -p /var/opt/piik
sudo chown -R pi:www-data /var/opt/piik

# Restart PHP-FPM and nginx
sudo service php5-fpm restart
sudo service nginx restart

# Show finish text
printf "\n%s\n\n" "All done! Visit http://$IP_ADDRESS:8123 in your browser to start using piik!";
