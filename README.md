Project for data manituplation with Near Earh Objects
=====================================================

Fork repository

After this, you should do first of all
```
    composer install
```

You will be asked for database connection settings.

Probably you want to modify api settings.
You can find them in parameters.yml

By next step you should create database. Run from project folder
```
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
```

To run the command just type in command line
```
    php bin/console app:neo:data
```

To test the project simplest way is to run build-in web server. You
can run it by

```
    php bin/console server:start
```

So, you can test it in http://127.0.0.1:8000

Sample requests are:

 http://127.0.0.1:8000/neo/hazardous
 
 http://127.0.0.1:8000/neo/best-year?hazardous=true

To run unit tests
```
    ./vendor/phpunit/phpunit/phpunit
```

Enjoy :-)
