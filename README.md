# README #

### This project is in progress

## Installation:

- run `composer install` to install vendor packages
- make storage and bootstrap folder writable `chown -R www-data:www-data storage bootstrap`
  `chmod -R 755 storage bootstrap`
- run `php artisan storage:link` to make them accessible from the web
- copy `.env.example ` to `.env ` and set necessary configs
- run `php artisan key:generate` to generate new application key
- run `php artisan migrate --seed` to run database migrations
- run `npm install`
- for test proposal run `php artisan serve`

**Notes:**

- _Each project pull you must run command `php artisan migrate` to migrate new database changes_
- _If there is new packages added to composer file don't forget to run command `composer update`_

#### Setup CronJob

- `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`



#### Requirements
- PHP ^7.3|^8.0
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Redis Server
- NodeJs

#### Setup Redis Server
- install redis server
- run `redis-server --daemonize yes` to keep redis server running on background
- then check it with `ps aux | grep redis-server`
