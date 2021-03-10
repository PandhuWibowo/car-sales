# Car Sell

## Preparation - How to use

### Config

1. Download the project.
2. Create .env file in your project. You can see the value at **example.env.** file
3. Please fill **DB_PORT**, **DB_DATABASE**, **DB_USERNAME**, **DB_PASSWORD** to your local

### Database

A database MySQL with name, and please to import the database to your local database

```bash
db_penjualan_mobil.sql
```

### Install Environment

Run this script to install the project

```bash
composer install
```

### Start

Run this script before start the `localhost`

```bash
php artisan migrate
```

Run this script to run out the project inside your local web server

```bash
php artisan serve
```

For login, Hopefully you must create directly from the database. Don't forget to Hash the password.

To make you easier, copy paste this script.

```bash
php artisan tinker
```

And then

```bash
Hash::make('yourpassword')
```

Copy to the password field inside users table.


Thank you.
Pandhu Wibowo
