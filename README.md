### Requirements
- [x] Estimation 
- [x] Install laravel v.8
- [x] Do the authentication process
- [x] Admin layout
- [x] Manage subscribers with CRUD in the admin panel
- [x] Export csv of subscribers in admin panel
- [x] Import csv via cli
- [x] Add support for heavy load csv files 
- [x] Make and API endpoint to store subscribers
- [x] Make the landing website 
- [x] Make the subscription form endpoint
- [x] Make the validation email template
- [x] Send email in a queue job with redis for performance
- [x] Add Meta Trait for custom fields 
- [ ] Add CRUD for products (optional for reusability)
- [x] Documentation to run the app
- [x] Documentations of work done
- [x] Document the API

### Running the app
This is a laravel 8 application. It requires 
- php >=7.3
- Mysql
- composer
- Redis

To run the app, you need to clone the repo and them you have several options, you could use [ laravel sail ](https://laravel.com/docs/8.x/installation#your-first-laravel-projec) 
which is the default Docker development environment for laravel. 
But I will assume that you have a development environment already configured for php apps. 
So the steps you need to complete are the following: 

1. Clone the repo `git clone git@github.com:jorgejavierleon/synolia-test.git synolia-test`
2. cd into the root folder `cd synolia-test`
4. Run `composer install`
5. Create the environment file `cp .env.example .env`
6. Generate the app key `php artisan key:generate`
7. Create the database `CREATE DATABASE synolia_test`
8. Add the database credentials to .env file 
9. Run the database migration and seed the tables `php artisan migrate --seed` It shoul take about 45 seconds
10. If you don't have any virtual host configurated, like valet, run `php artisan serve` and the app should be available in http://127.0.0.1:8000/

And that should be all.

(Optional)
11. If you have Redis configured on your server you can run `php artisan horizon` to start the queue worker.

### Technology used
The stack used for the app is the TALL stack
- [Tailwindcss](https://tailwindcss.com/) for styles. Is a utility first css framework.
- [Laravel](https://laravel.com/) PHP framework
- [Livewire](https://laravel-livewire.com/) Is a tool to make dynamic requests with ajax but in a PHP kind of way.
- [Alpine.js](https://github.com/alpinejs/alpine) For simple DOM manipulation that doesn't require vue.js or react


### Structure of the app
- The root http://synolia.test corresponds to the landing with the subscribers form.
- There is a admin panel protected by login in http://synolia.test/admin/subscribers
- In the admin panel you can do simple CRUD operations on the subscribers resource.

I decided to call it "subscribers" to let "users" be the authenticable resource, the ones that can enter the admin panel.

### Tests
The app has a set of functional tests that cover the basic requirements. You can run the suit with 

`vendor/bin/phpunit`

To see the tests go to `tests/Features/SubscribersTest.php`

### Fake data
The app has seeders that populate the database with 300.000 fake subscribers.
Depending on the environment that runs the seeders the operation may take some time. 
In my machine it took about 45 seconds to complete the operation.

You can see the seeders in `database/seeders/DatabaseSeeder.php`. In that file are the credentials for admin panel

- email: admin@example.com
- password: 123456
- api_token: siExyCGoRW8QD1pljDU5E1FWBNeRhEv5QJPsrmj0Szq3jBtZz95G8uyVDjMI

### Email verification
To see the verification email that the apps generates when a subscriber register, go to `http://synolia.test/mailable/{id}` 
where 'id' corresponds to the id of the subscriber. If the seeds had been run, 'id' could be any number between 1 and 300.000.

The subscriber model has a method to generate a secure signed url, with an expiration time of a day.
That url is sent in the email and lets the user confirm the email address when he visits that route. This is an example of a url generated

`http://synolia.test/verifyemail=ukeebler%40example.net&expires=1611830808&subscriber=178&signature=f35c6bec51a418e46d3ba8ced6764cabb4e43fa01700649f47308c030743a5ea`

if the user changes any part of the url, the subscriber id for example, the signature would be invalidated.

### Performance
I Think that the most consuming operation in the landing, that which could affect the performance in case of a user spike, 
is the validation email that is sent when the user submit the form. To eliminated the impact on performance 
I configured a **queue worker** that would do that job in the background. This functionality requires **Redis** to be installed on the server.

To start the worker you need to have `php artisan horizon` running in the background, ideally with a supervisor.
Once it is running, you can monitor the jobs been executed in a dashboard, just go to `http://synolia.test/horizon/dashboard/` 

### CLI tool to import subscribers from csv file
The app has a command to import subscribers from .csv into the database. The command is `php artisan synolia:import` 
It has to options (`php artisan synolia:import --help`):

![cli tool](/public/images/synolia_cli.png "cli tool")

- **chunks**: The amount of resources to insert in the database at a time. Defaults to 600.
 If the file has 2000 lines and you run `php artisan synolia:import --chunks=200` it will perform 10 inserts with 200 subscribers at a time.
- **filename**: by default it will look for `storage/app/subscribers.csv`, but you can overwrite the last part `php artisan synolia:import --filename=another.csv`

It doesn't do validations for the fields. I have time only for the happy path, with the subscribers table clean in order to prevent unique email collisions, and with the file that I give as an example.
The file has 300.000 subscribers. It was generated with the admin dashboard export functionality.
You can review the command in `app/Commands/ImportSubscribers.php`

### Export subscribers
There is a button in the admin panel, subscribers view, to download a csv with all the subscribers.
The functionality does a foreach in chunks to be able to process a large amount of data without ever exhausting the php memory.
You can see the implementation in `app/Exports/ExportSubscribers.php`

### API for subscribers store
The app exposes an endpoint for creating a subscriber by an API. It is protected with a token authentication. 
This is a cURL example of a post to the api
```
curl --location --request POST 'http://synolia.test/api/subscribersfirstname=Pedro&lastname=Perez&email=pedro3@example.com&city=Caracas&country=Chile&birthday=1982-03-23' \
--header 'Authorization: Bearer siExyCGoRW8QD1pljDU5E1FWBNeRhEv5QJPsrmj0Szq3jBtZz95G8uyVDjMI'
```
With that petition you should get this 201 response
```javascript
{
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
}
```

if the request doesn't pass the validation you should get something like this 422 response
```javascript
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "city": [
            "The city field is required."
        ]
    }
}
```

### Meta fields for Reusability
For the user to be able to add custom fields to the subscribers, or any other model, I created a Trait `HasMeta` 
that manage the relation between the models and a meta table. The meta table have fields for key and value 
and a foreign key constraint to the model id, in a pattern similar to various CMSs like wordpress. 

