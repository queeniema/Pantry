# Pantry
CS 130 Web Application

## Setup LAMP Environment
    sudo apt-get install apache2
    sudo apt-get install mysql-server
    sudo apt-get install php5 libapache2-mod-php5
    sudo apt-get install php5-mysql
    sudo /etc/init.d/apache2 restart

    php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'
Use 'password' when prompted for root mysql password

### Setup MySQL Database
    mysql --user=root --password=password
    CREATE DATABASE pantry;

### Enable Error Reporting
    sudo vim /etc/php5/apache2/php.ini
    // find display_errors = Off
    // replace with display_errors = On
    sudo service apache2 restart

## Setup Scripts
    mysql pantry --user=root --password=password
    SOURCE sql/reset.sql;
    SOURCE sql/setup.sql;
* SQL scripts only at the moment

## Testing
Install Composer and required libraries
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```
Run Selenium Server
```
java -jar selenium-server-standalone-2.45.0.jar
```
In a new CLI, run the tests. We assume that your Apache port is 8888. 
You can change this to match your environment. Note: you must have Firefox installed. 
```
vendor/bin/phpunit tests/basic_test.php
```