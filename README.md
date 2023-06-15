

## What I've Done Check
- Homepage search form
- get data from weather api https://www.weatherapi.com/
- save data at database, then cache it at redis
- make migration file
- I didn't make any fixture because I didn't need it
- Make Features(Controller) tests, Unit tests, Mock Tests 
- Make Docker
- 
## Installation
- clone repo
- change .env.example to .env
- generate app secret
- ``php bin/console make:command regenerate-app-secret``
- Run Docker
- ``docker-compose build && docker-compose up -d``
- get api key from weatherapi.com
- ``docker exec -it code_red-php-1 bash``
- Run Migration
- ``symfony console doctrine:migrations:migrate``
- Run Tests
- ``php bin/phpunit``
- Run server
- ``symfony serve -v``
- http://127.0.0.1:8000/