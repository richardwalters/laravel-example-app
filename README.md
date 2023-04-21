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

## Git Hooks for Quality

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

