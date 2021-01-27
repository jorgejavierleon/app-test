<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements
- [x] Estimation 
- [x] Install laravel v.8
- [x] Do the authentication process
- [x] Admin layout
- [x] Manage subscribers with CRUD in the admin panel
- [x] Export csv of subscribers in admin panel
- [x] Import csv via cli
- [x] Add support for heavy load with PHP generators lazycollections
- [x] Make and API endpoint to store subscribers
- [x] Make the landing website 
- [x] Make the subscription form endpoint
- [x] Make the validation email template
- [x] Send email in a queue job with redis for performance
- [x] Add meta tarit for custom fields 
- [] Add CRUD for products (optional for reusability)
- [] Documentation to run the app
- [] Documentations of work done
- [] Document the api with postmant

### Test
The app has a set of functional test that cover the basic requirements. You can run the suit with `vendor/bin/phpunit`
To see the tests go to `tests/Features/SubscribersTest.php`

### Fake data
The app have seeders that populate the database with 300.000 fake subscribers.
Depending on the enviroment that run the seeders, the operation may take a while. 
In my machine it took about 45 seconds to complete the oepretation.

You can see the seeders in `database/seeders/DatabaseSeeder.php`. In that file are the credentials for admin pannel

- email: admin@example.com
- password: 123456
- api_token: siExyCGoRW8QD1pljDU5E1FWBNeRhEv5QJPsrmj0Szq3jBtZz95G8uyVDjMI

### Email verification
To see the verification email that the apps generates when a subscriber register, go to /mailable/{id} 
where 'id' correspond to the id of the subscriber. If the seeds has been run, 'id' could be any number between 1 and 300.000.

The subscriber model has a method to generate a secure signed url, with a expiration time of a day.
That url is sended in the email and lets the user confirm the email address when he visited that route. This is an example of a url generated
http://synolia.test/verify?email=ukeebler%40example.net&expires=1611830808&subscriber=178&signature=f35c6bec51a418e46d3ba8ced6764cabb4e43fa01700649f47308c030743a5ea
if the user change any part of the url, the subscriber id for expample, the signature would be invalidated.

### Performance
I Think that the most consuming operation in the landing, that could affect the performance in case of a user spike, 
is the validation email that is send when the user submit the form. To eliminated the impact in performance 
I configured a queue worker that would do that job in the backgroung. This functionality requires Redis to be installed on the server.
To start the worker you need to have `php artisan horizon` running in the backgroung, idealy with a supervisor.
Once it is running, you can monitor the jobs been executed in a dashboard, just go to http://synolia.test/horizon/dashboard/ 

### CLI tool to import subscribers in csv file
The app has a command to import subscriber from .csv into the database. The command is `php artisan synolia:import` 
It has to options (`php artisan synolia:import --help`):
- chunks: The ammount of resources to insert in the database at a time. Defaults to 600
 if the file have 2000 and you run `php artisan synolia:import --chunks=200` it will perform 10 inserts with 200 subscribers at a time.
- filename: by default it will look for 'storage/app/subscribers.csv', but you can overwrite the last part `php artisan synolia:import --filename=another.csv`
It doesn't do validations for the field. I have time only for the happy path, with the subscribers table clean in order to prevent unique email collisions, and with the file that I give as example.
The file has 300.000 lines. It was generated with the admin dashboard export functionality.
You can review the command in app/Commmands/ImportSubscribers.php

### Export subscribers
There is a button in the admin pannel subscribers view to download a csv with all the subscribers.
The functionality do a forech in chunk to be able to process a large ammount of data without exaustiong the php memory.
You can see the implementation in app/Exports/ExportSubscribers.php

### Api for subscribers store
The app expose a endpoint for creating a subscribers by an API. It is protected by a toke authentication. 
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

### Meta fields for Reusanility
For the user to be able to add custom fields to the subscribers, or any other model, I created a Trait `HasMeta` 
that manage the relation between the models and a meta table. The meta table have fields for key and value 
and a foreign key constraint to the model id. In a patter similar to variuos CMS like wordpress.


