# GIF API

Simple API to fetch gifs from [Giphy](https://giphy.com/).

This project is intended to be used with the [gif-frontend](https://github.com/gabriel-ps/gif-frontend "gif-frontend") project.

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [PHP Composer](https://getcomposer.org/)

Setting up your development environment on your local machine :
```bash
$ git clone https://github.com/gabriel-ps/gif-api.git
$ cd gif-api
$ cp .env.example .env
$ docker-compose build && docker-compose up -d
$ composer install
$ docker exec php php artisan key:generate
$ docker exec php php artisan jwt:secret
```

Now the API will be avaible on [http://localhost:8080](http://localhost:8080).

**There is no need to run ```php artisan serve```. PHP is already running in a dedicated container.**

## Before starting
You need to run the migrations with the seeds :
```bash
$ docker exec php php artisan migrate --seed
```

This will create a new user that you can use to sign in :
```yml
Email: test@test.com
Password: 123456
```

## CORs
By default, CORs policy is going to allow for origin http://localhost:8081. You can change that on the key CLIENTS_ENDPOINTS of your .env file.

Example of .env:
CLIENTS_ENDPOINTS=http://localhost:8082
**Multiple clients:**
CLIENTS_ENDPOINTS=http://localhost:8082,http://localhost:8083

## GIPHY
This projects fetchs GIFs from [Giphy](https://giphy.com/) with the [giphy-and-stickers](https://github.com/romeroqe/giphy-and-stickers "romeroqe/giphy-and-stickers") package. The package comes with a default beta API key, but it is recomended that you set your own API key on the GIPHY_KEY key of your .env file.

Example of .env:
GIPHY_KEY=my-api-key