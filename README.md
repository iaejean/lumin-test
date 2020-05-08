# Lumin - Home Excercise

## Requirments 
- PHP 7.4
- Composer
- MySQL 5.7

## How to load Database
please create first your database publisher
```shell script
> mysql CREATE DATABASE publisher;
```
```shell script
$ bin/console doctrine:migrations:execute 20200508055930 --up
```
      
## How to start Messenger async process
```shell script
$ bin/console messenger:consume message_published --time-limit=3600
```

## Configure .env with your DB settings
```dotenv
DATABASE_URL=mysql://root@127.0.0.1:3306/publisher?serverVersion=5.7
```

## You can start a local dev server with 
```shell script
$ php -S localhost:8080 -t public/
```
 
You can see the API doc on http://localhost:8080/api/doc

## Uses case

$ ./start-server.sh
$ curl -X POST -d '{ "url": "http://localhost:8080/event"}' http://localhost:8080/subscribe/topic1
$ curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8080/publish/topic1

                
## Developers guide

### Contribution guidelines ###

Please consider read about some concepts like OOP, Patterns design, PSR1, PSR2, etc.
 
This project has been provided with several tools for ensure the code quality:

* PHP Code Sniffer
* PHP Mess Detector
* PHP CS Fixer
````shell script
vendor/bin/phpcbf --standard=PSR2 src/ tests/
vendor/bin/phpcbf --standard=PSR1 src/ tests/

vendor/bin/phpmd src/ xml codesize controversial design naming unusedcode --exclude=vendor/
vendor/bin/phpmd tests/ xml codesize controversial design naming unusedcode --exclude=vendor/

vendor/bin/php-cs-fixer fix src/ --dry-run --diff
````

* PHPMetrics
* PHPLoc

```shell script
vendor/bin/phploc src
vendor/bin/phpmetrics --report-html=report/metrics ./
```
### @Todo
Write unit test
* PHPUnit

````shell script
vendor/bin/phpunit -c phpunit.xml
````

                