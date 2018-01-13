#!/bin/bash
# This script will perform all the necessary settings to launch the project

clear
echo "Select action:"
echo "1 - Install project (full configuration, load fixtures)"
echo "2 - Reinstall backend"
echo "3 - Reinstall frontend"
echo "4 - Recreate database"
echo "5 - Load fixtures"
echo "6 - Run tests"
echo "0 - Exit"

read Keypress

case "$Keypress" in
1)
    echo
    echo INSTALLING BACKEND ...
    echo ======================
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    rm composer.phar
    rm -rf ./var/cache/*
    rm -rf ./var/logs/*
    setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx ./var/cache ./var/logs
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx ./var/cache ./var/logs
    echo
    echo INSTALLING FRONTEND ...
    echo =======================
    npm install
    echo
    echo CREATING DATABASE ...
    echo =====================
    ./bin/console doctrine:database:create
    ./bin/console doctrine:migration:migrate --no-interaction
    echo
    echo LOADING FIXTURES ...
    echo ====================
    ./bin/console hautelook:doctrine:fixtures:load --no-interaction
;;
2)
    echo
    echo REINSTALLING BACKEND ...
    echo ========================
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    rm composer.phar
    rm -rf ./var/cache/*
    rm -rf ./var/logs/*
    setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx ./var/cache ./var/logs
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx ./var/cache ./var/logs
;;
3)
    echo
    echo REINSTALLING FRONTEND ...
    echo =========================
    npm install
;;
4)
    echo
    echo RECREATING DATABASE ...
    echo =======================
    ./bin/console doctrine:database:drop --force
    ./bin/console doctrine:database:create
    ./bin/console doctrine:migration:migrate --no-interaction
;;
5)
    echo
    echo LOADING FIXTURES ...
    echo ====================
    ./bin/console hautelook:doctrine:fixtures:load --no-interaction
;;
6)
    echo
    echo RUNING TESTS ...
    echo ================
    ./vendor/bin/phpunit
;;
10)
    exit 0
;;
*)
    echo "ERROR! UNDEFINED ACTION"
    exit 0
;;
esac
echo
echo =======================
echo ALL OPERATION COMPLETED
exit 0