#!/usr/bin/env bash

PASSWORD='123456789'

sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"

# install phpmyadmin and give password(s) to installer
# for simplicity I'm using the same password for mysql and phpmyadmin
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"

sudo apt-get update
sudo apt-get -y upgrade
sudo apt-get install -y apache2 php5 php5-mcrypt php5-xdebug php5-curl mysql-server php5-mysql phpmyadmin vim git

printf "[client]\nuser=root\npassword=$PASSWORD" > ~/.my.cnf
cp /root/.my.cnf /home/vagrant/.my.cnf
chown vagrant:vagrant /home/vagrant/.my.cnf
chown vagrant:vagrant /home/miga-core

# restart apache
service apache2 restart
