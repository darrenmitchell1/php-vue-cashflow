## Cashflow Application for Laravel and Vue.

Cashflow application to manage Types, Items, Transactions and produce a Statement.

Retrieval-Augmented Generation (RAG) for querying the cashflow data.

## Environment

### PHP + Laravel + Inertia.js + Vue.js + TypeScript + Wayfinder + Tailwind.css + PostgreSQL

* Composer 2.9.x
* PHP 8.4.x
* Laravel 13.x
* [PostgreSQL](https://www.postgresql.org/download/linux/ubuntu/)
* Node 25.8.x
* NPM 11.11.x
* [Inertia.js SSR](https://inertiajs.com/) 3.0.x
* [Vue](https://vuejs.org/) 3.5.x
* [Wayfinder Router](https://github.com/laravel/wayfinder) 0.1.x
* [Tailwind CSS](https://tailwindcss.com/) 4.1.x


## Installation

copy the .env.example to make .env and configure

starts the app and testing postgresql dbs
```
$ docker compose up -d
```

enable the vector extension for both app and testing db
```
$ docker exec -it <container id> psql -U <user> -d <database>

<database>=# CREATE EXTENSION IF NOT EXISTS vector;
```

setup the app (once)
```
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ npm install
$ npm run build
```

## Start Application

```
$ composer run dev
```

## Testing
Tests are written with the PEST framework.

Run tests
```
$ ./vendor/bin/pest
```
