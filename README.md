<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Steps
- [x] Estimation 
- [x] Install laravel v.8
- [x] Do the authentication process
- [x] Admin layout
- [x] Manage subscribers with CRUD in the admin panel
- [] Import and export csv of users in admin panel
- [] Import and export csv via cli
- [] Add support for heavy load with PHP generators lazycollections
- [] Make and API for the users resource
- [] Document the api with postmant
- [] Add meta data to user model for custom fields
- [] Add CRUD for products (optional)
- [x] Make the website 
- [x] Make the subscription endpoint
- [x] Make the validation email template
- [x] Send email in a queue job with redis
- [] Documentation to run the app
- [] Documentations of work done

## Info
- The seeders run in 44 seconds and create 300.000 subscribers
- To see the verification email for the first subscriber in DB go to /mailable
- For the queue jobs I'm using predis. It needs to be installed in order to run the worker with php artisan horizon

