# MyBookApp

## quickstart
### git clone
```
git clone url
```
### start docker
```
docker-compose build
docker-compose up
```
### composer install
```
docker-compose exec php bash
composer install
```
### setting env
```
cp .env.sample .env
php artisan key:generate
```
change info of database(Host, Port, ...etc) in .env
