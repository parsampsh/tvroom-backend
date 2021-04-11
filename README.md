# Tvroom Backend
**Tvroom** is a movie website. This project is the backend of the Tvroom.
This project is open source and licensed under [MIT](LICENSE) and written by [parsa shahmaleki](https://github.com/parsampsh).

To get started and run it locally, do the following steps (You need to have `php >= 8.0`, `composer` and `mysql` installed):

```bash
$ cd path/to/tvroom-backend
$ cp .env.example .env

# create a mysql database
$ mysql -u root -p
> CREATE DATABASE tvroom;
# then, set database information in `.env`

$ composer install
$ php artisan migrate
$ php artisan optimize
$ php artisan serve
```

Now, API is accessible at `http://localhost:8000`.

For running tests:

```bash
$ php artisan test
```

For format the code using php-cs-fixer:

```bash
$ composer format
```

## Frontend
The frontend project for this backend will be created soon...

## Documentation
To read documentation of this project and also APIs, see [docs folder](docs).
