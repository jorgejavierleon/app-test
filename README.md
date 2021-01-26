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
- [x] Export csv of subscribers in admin panel
- [x] Import csv via cli
- [x] Add support for heavy load with PHP generators lazycollections
- [x] Make and API endpoint to store subscribers
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
- To import subscriber via csv you neet to put the file in /storage/app/subscribers.csv. Right now the app chunks the file in groups of 600 to do the insrts at a time
    - The Api endpoint for creating subscribers requires token bearer authentication. The token is in the database seeder.

