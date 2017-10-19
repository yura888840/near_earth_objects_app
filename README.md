Project for data manituplation with Near Earh Objects from NASA
===============================================================

Fork repository

You should do first of all
```
composer install
```

You will be asked for database connection settings.

Probably you want to modify api settings
You can always change them in parameters.yml

Then you should create database.

Run from project folder
```
 php bin/console doctrine:schema:update --force
```

To run unit tests
```
./vendor/phpunit/phpunit/phpunit
```

To test the project simplest way is to run build-in web server. You
can run it by

```
php bin/console server:start
```

So, you can test it in http://127.0.0.1:8000

Sample request is http://127.0.0.1:8000/neo/best-year?hazardous=true

Enjoy :-)
