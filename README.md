# PHP Laravel Example App

## Project creation

The project was created by following steps from the [Larval installation guide](https://laravel.com/docs/10.x#your-first-laravel-project), and in particular by executing the command:
```shell
composer create-project laravel/laravel example-app
```

## Running the app with Laravel Sail

The app can be run from the host machine with
```shell
php artisan serve
```
However, it is perhaps better to do so with [Laravel Sail](https://laravel.com/docs/10.x/sail), which is a convenient CLI tool on top of Docker.
First, create a shell alias for Sail by adding:
```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
to your `~/.zshrc` file. Next, set up Sail in the project with
```shell
php artisan sail:install
```
Hit `ENTER` when prompted to choose services to accept the defaults. This step will have created a `docker-compose.yml` in the root of the porject.

Finally, run the app with:
```shell
sail up
```
This will start the app and a MySQL database in docker containers.
You can now access the app at http://localhost.

You can start the containers in detached mode with
```shell
sail up -d
```
To stop the containers, execute:
```shell
sail down
```
To change the port the app is accessible from to e.g. 8080, add
```shell
APP_PORT=8080
```
to the [.env](./.env) file

## Git Hooks for Quality

### Install Git Hooks with Composer

```shell
sail composer run install-hooks
```

### Install Husky

```shell
sail npx husky install
```

### Check Hook Path
```shell
git config --local --get core.hooksPath
```

### Add a Pre-Commit Hook
```shell
sail npx husky add .husky/pre-commit "./vendor/bin/sail pint"
```

### Add a Pre-Push Hook
```shell
sail npx husky add .husky/pre-push "./vendor/bin/sail test"
```

### Run Browser Tests

```
sail composer run browser-tests
```

## API Documentation

### Installation

SDK Documentation for Attributes please check [PHP-Swagger](http://zircote.github.io/swagger-php/)


```
sail composer require "darkaonline/l5-swagger"
```

Then publish config and all view files:
```
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Next, open a *config/l5-swagger.php* file. Let's walk through essential keys:

*routes.api* — This is an URL for accessing documentation UI. Your frontend team will be using it to access documentation. By default, it is *api/documentation* . I prefer changing it to something smaller like *api/docs*

### Generating Docs
```
php artisan l5-swagger:generate
```
