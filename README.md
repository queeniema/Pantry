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
    USE pantry;
    SOURCE sql/setup.sql;


### Enable Error Reporting
    sudo vim /etc/php5/apache2/php.ini
    // find display_errors = Off
    // replace with display_errors = On
    sudo service apache2 restart

## Setup Scripts
