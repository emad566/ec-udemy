=======================================
# 000: Laravel Framework: 8.22.1
=======================================
you need to install  nodejs
to get node version: 
node -v

=======================================
# 001: Section 1: Introduction
=======================================
https://github.com/easylearningbd/laravelecommerce

=======================================
# 002: Section 2: Laravel 8 A-Z Basic Fandamentals with Complete Dynamic Web Project
=======================================
composer create-project laravel/laravel basic


//-- 13. What is Route
-----------------------------
Six Types of Route Method
1- Get
2- Post
3- Put
4- Delete
5- Patch
6- options

//-- 17. Middleware
-----------------------------
To create middleware add it in the Kernal.php

//-- from  20. Laravel 8 Authentication install
-----------------------------
Laravel_8 auth different from laravel_7 auth


** laravel_7 auth installions
composer require laravel/ui:^2.4
php artisan ui vue --auth

** laravel_8 auth installions
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install && npm run dev

php artisan migrate
php artisan serve

*** Register New user:
admin
emade09@gmail.com
12345678

*** add boot startp files to view
{{ $user->created_at->diffForHumans() }}

//-- 022. Eloquent ORM Read Users Data
--------------------------------------
if use::
    DB::table('users')->get();
Then 
{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}

