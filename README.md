# Blog/Post Application

This project is a web application built with PHP and the Laravel framework. It was initiated as a basic Laravel project and has since had several new features implemented.

## Database Schema

The database for this project is structured to support the Urls Repository feature. The tables in the database are the `post`, `users`, `comments` and `tags` table, which stores data related to the urls.

The `comments` table has a polymorphic relationship with the `posts` tables. The `tags` table has a many-to-many relationship with the `posts` table.

The polymorphic relationship was done so that it could be potentially used for other models in the future.

### There is also an export from Postman with all the requests that I have tested

## New Features

### Repositories and Repository Interfaces

The `App\Repositories` directory contains the `{Model}Repository` and `{Model}RepositoryInterface` classes. 

The `{Model}Repository` class implements the `{Model}RepositoryInterface` and contains methods for interacting with the `{model}` table in the database.
The methods included in the `UrlRepositoryInterface` are basic CRUD methods and various database queries.

Soft deletes are also implemented in the project.

### Repository binding

In `config/app.php` under `providers` the `App\Providers\RepositoryServiceProvider::class` was added thus allowing us to bind the `Model`RepositoryInterface with the `Model`Repository.

### Routes

The routes are in `api.php`.

The routes for the posts are:

- GET api/posts
- GET api/posts/{uuid}
- POST api/posts
- PUT api/posts/{uuid}
- DELETE api/posts/{uuid}

In order to create a comment, the route is /api/posts/comments/{uuid} and the method is POST. The uuid is the uuid of the post that you want to comment on.

In order to create a post with optional tags, the payload is saved in Postman as a JSON object. The tags are passed as an array of strings.

### Requests

Everything is in the `App\Http\Requests` directory.

#### JWT

I have implemented JWT for authentication. The package used is `tymon/jwt-auth`.

[JWT Auth](https://jwt-auth.readthedocs.io/en/develop/)

## Installation

1. Clone the repository.
2. Run `composer install` to install the PHP dependencies.
3. Set up your `.env` file with your database and other environment settings. Copy the `.env.example` file and rename it to `.env` - then fill in the necessary values with your own.
4. Run `php artisan migrate` to create the database tables.
5. Run `php artisan serve` to start the Laravel server.
6. I used [Laravel Herd](https://herd.laravel.com/windows) to run the server on Windows.

## Testing with Postman

1. Import the `Bridge.postman_collection.json` file into Postman
2. Run the requests in the collection
3. Be sure to firstly register and then login to get the token for the requests that require authentication.
4. The token is passed in the separate Authentication tab in Postman -> Bearer Token and you paste the token there that you receive when you login.
5. The {{baseUrl}} variable can be set in the Postman environment settings to the URL of your Laravel server.
