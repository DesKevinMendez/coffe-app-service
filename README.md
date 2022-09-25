
## NOTE

This configuration is only for run db, server and app; for running the frontend from docker, you need extra configuration; this will be implemented in the future.

## Requirements

- Docker 19.x o 20.x
- Docker Compose 1.25.x

## Tecnologies
- PHP 7.4 or PHP 8.0
- Node > 14.x

## Project setup

### Setup .env variables

```shell
cp .env.example .env
```

### Update env variables

```shell
DB_DATABASE=<coffe>
DB_USERNAME=<username>
DB_PASSWORD=<password>
```

### Replace DB_HOST in case that you run db in docker
```shell
DB_HOST=coffedb
```
## or

```shell
DB_HOST=0.0.0.0
```


### Build database
```shell
docker-compose build
```

### Generate key
```
docker-compose exec app php artisan key:generate
```

### Clean default config
```
docker-compose exec app php artisan config:cache
```

### Create user with password in the db
```
docker-compose exec coffedb bash
```

NOTE: The password for root user in db is **DB_PASSWORD_ROOT** in your .env file

### Login with user and password
```
mysql -u root -p
```
### Create database for test
```
create database coffe;
```

Please replace 'laraveluser' for **DB_USERNAME** and 'your_laravel_db_password' for **DB_PASSWORD** defined in your .env
```
GRANT ALL ON laravel.* TO 'laraveluser'@'%' IDENTIFIED BY 'your_laravel_db_password';
```

```
FLUSH PRIVILEGES;
```

### Run migrations
```
docker-compose exec app php artisan migrate
```
### Run seeders
```
docker-compose exec app php artisan db:seed &&
docker-compose exec app php artisan db:seed --class DevelopmentSeeder
```

### Run laravel app
```
docker-composer up -d
```
## Extra commands

### Start db

```shell
docker-compose start
```

### Stop db

```shell
docker-compose stop
```

### Run tinker
```shell
docker-compose exec app php artisan tinker
```

### Last pass

Configuration the local host into /etc/host -> this work only in mac and linux, for window you need added virtual host in another way.

```shell
sudo nano /etc/hosts or sudo vim /etc/hosts
```

Into host you need add the domain as APP_DOMAIN into your .env file.
In our case coffe.test
```shell
127.0.0.1   coffe.test
```

