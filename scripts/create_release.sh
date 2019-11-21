#!/usr/bin/env bash
VERSION="$1"

wget https://github.com/matomo-org/matomo-marketplace-for-wordpress/archive/master.zip
unzip master.zip
mv matomo-marketplace-for-wordpress-master matomo-marketplace-for-wordpress
zip -r matomo-marketplace-for-wordpress-$VERSION.zip matomo-marketplace-for-wordpress
rm master.zip
rm -rf matomo-marketplace-for-wordpress
scp -p matomo-marketplace-for-wordpress-$VERSION.zip "piwik-builds@matomo.org:/home/piwik-builds/www/builds.piwik.org/"
scp -p matomo-marketplace-for-wordpress-$VERSION.zip "piwik-builds@matomo.org:/home/piwik-builds/www/builds.piwik.org/matomo-marketplace-for-wordpress-latest.zip"
rm matomo-marketplace-for-wordpress-$VERSION.zip
