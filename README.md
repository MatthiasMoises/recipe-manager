# Recipe Manager

## 1. Install client

- cd client
- run "npm install"
- run "npm run serve"

## 2. Install server

- cd server
- run "composer install"
- create MySQL database, e.g. "recipe_manager"
- create ".env" file with database information
- run "php artisan migrate"
- run "php artisan db:seed"
- run "php -S localhost:8000 -t public"
