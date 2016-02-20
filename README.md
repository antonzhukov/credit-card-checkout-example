Credit Card Payment
=======================
This is the test task I made for one of the companies.
This project is based on following solutions: ZF2, Bootstrap 3, monolog, Mysql

Installation
------------
Follow these simple steps to install:

    cd my/project/dir
    git clone git@github.com:antonzhukov/credit-card-checkout-example.git
    cd credit-card-checkout-example
    mkdir data/log
    chmod 777 -R data/log/
    composer install
    
Last step is to apply db migration in: module/Application/data/schema.mysql.sql

Edit db access credentials at: config/autoload/global.php

Logs
------------
Logs are written to data/log/application.log

PHPUnit
------------
To run tests for this project

    cd module/Application/test
    phpunit
    
by Anton Zhukov