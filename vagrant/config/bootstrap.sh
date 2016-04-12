#!/usr/bin/env bash

# Fixing the locale
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
locale-gen en_US.UTF-8
dpkg-reconfigure locales
echo 'LC_ALL="en_US.UTF-8"' > /etc/environment

apt-get update

# curl
apt-get install -y curl

# Git
apt-get install -y git

# Node.js
curl -sL https://deb.nodesource.com/setup_5.x | bash -
apt-get install -y nodejs

apt-get install -y language-pack-en-base
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get install -y nginx php7.0 php7.0-mysql php7.0-fpm php7.0-mbstring php7.0-xml php7.0-curl php7.0-zip php7.0-dev

# Configure PHP 7
echo "cgi.fix_pathinfo=0" >> /etc/php/7.0/fpm/php.ini
mkdir -p /var/www/html

# Configure nginx
rm /etc/nginx/sites-available/default
cp /code/simple-blog/vagrant/config/default /etc/nginx/sites-available/default
cp /code/simple-blog/vagrant/config/simple-blog /etc/nginx/sites-available/simple-blog
ln -s /etc/nginx/sites-available/simple-blog /etc/nginx/sites-enabled/simple-blog
cp /code/simple-blog/vagrant/config/.env /code/simple-blog/.env

sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
sed -i 's/sendfile on/sendfile off/g' /etc/nginx/nginx.conf

/etc/init.d/nginx restart

# Install MongoDB
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv EA312927
echo "deb http://repo.mongodb.org/apt/ubuntu trusty/mongodb-org/3.2 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-3.2.list
apt-get update
apt-get install -y mongodb-org

# Install PHP extension for MongoDB
apt-get install -y php-pear libcurl4-openssl-dev pkg-config
pecl install mongodb
echo "extension=mongodb.so" >> /etc/php/7.0/fpm/php.ini
echo "extension=mongodb.so" >> /etc/php/7.0/cli/php.ini
sudo service php7.0-fpm restart

# Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

chmod -R 775 /code/simple-blog/storage
chmod -R 775 /code/simple-blog/bootstrap/cache

# Initialize project
cd /code/simple-blog
su vagrant -c "composer install"

sudo service php7.0-fpm restart

mongo simpleBlog --eval "db.createUser({user: 'simpleBlogAdmin', pwd: 'p4ssw0rd', roles: [{role: 'userAdmin', db: 'simpleBlog'}]})"

su vagrant -c "php artisan migrate"
su vagrant -c "php artisan db:seed"
