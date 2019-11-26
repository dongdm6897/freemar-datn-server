Installation
Clone repository
$ git clone https://github.com/modulr/api-laravel-passport.git
Enter folder
$ cd api-laravel
Install composer dependencies
~/api-laravel$ composer install
Generate APP_KEY
~/api-laravel$ php artisan key:generate
Configure .env file, edit file with next command $ nano .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=user
DB_PASSWORD=secret
Run migrations
~/api-laravel$ php artisan migrate
Create client
~/api-laravel$ php artisan passport:install
Dependencies
laravolt/avatar - Generate avatars for users of application
Routes
Authentication
POST /auth/login
GET /auth/logout
POST /auth/signup
GET /auth/signup/activate/{token}
GET /auth/user
Password Reset
POST /password/create
GET /password/find/{token}
POST /password/reset