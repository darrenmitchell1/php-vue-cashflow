## Cashflow Application for Laravel and Vue.

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

## Dependencies

For Retrieval-Augmented Generation (RAG) load SQLite vector ext vec0.so

## Start PostgreSQL
starts the app and testing postgresql dbs

```
$ docker compose up -d
```

## Installation (Once Only)

```
$ composer run setup
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
