## Bundesliga Full-Stack Challenge

this is a simple application using VueJS 2 with Laravel 5.5 that shows<br>
some data from Bundesliga using the Api provided by [OpenLigaDb](https://www.OpenLigaDB.de)

## requirements
- php >= 7.0
- composer

### clonning and installing
first clone the application
```bash
git clone https://github.com/MichaelKlemersson/fullstack-challenge-bundesliga.git

cd fullstack-challenge-bundesliga
composer install
```

copy the .env.example to .env and generate a new key
```bash
cp .env.example .env
php artisan key:generate
```

### running
just start artisan from the root path and see [http://localhost:8000](http://localhost:8000)
```bash
php artisan serve
```

### tests
tests could be run with the commands bellow
```bash
composer run test-all
composer run test-all-testdox
composer run test-unit path/to/TestClass
composer run test-unit-testdox path/to/TestClass
```
> **Important**: some tests may take long because the comunication with other api