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
- [x] Make the website 
- [x] Make the subscription endpoint
- [x] Make the validation email template
- [x] Send email in a queue job with redis
- [x] Add meta data to user model for custom fields 
- [] Add CRUD for products (optional)
- [] Documentation to run the app
- [] Documentations of work done
- [] Document the api with postmant

## Info
- The seeders run in 44 seconds and create 300.000 subscribers
- To see the verification email for the first subscriber in DB go to /mailable
- For the queue jobs I'm using predis. It needs to be installed in order to run the worker with php artisan horizon
- To import subscriber via csv you neet to put the file in /storage/app/subscribers.csv. Right now the app chunks the file in groups of 600 to do the insrts at a time
    - The Api endpoint for creating subscribers requires token bearer authentication. The token is in the database seeder.
This is a cURL example of a post to the api
`curl --location --request POST 'http://synolia.test/api/subscribers?firstname=Pedro&lastname=Perez&email=pedro3@example.com&city=Caracas&country=Chile&birthday=1982-03-23' \
--header 'Authorization: Bearer siExyCGoRW8QD1pljDU5E1FWBNeRhEv5QJPsrmj0Szq3jBtZz95G8uyVDjMI'`
With that petition you should get this 201 response 
`{
    "created": true,
    "data": {
        "firstname": "Pedro",
        "lastname": "Perez",
        "email": "pedro3@example.com",
        "birthday": "1982-03-23",
        "city": "Caracas",
        "country": "Chile",
        "updated_at": "2021-01-26T11:46:00.000000Z",
        "created_at": "2021-01-26T11:46:00.000000Z",
        "id": 300003
    }
}`

if the request dont pass validation you should get something like this 422 response
`{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "city": [
            "The city field is required."
        ]
    }
}`
