Basic CRUD and JWT Authentication with Passport in Laravel

This is a sample Laravel project that demonstrates how to implement basic CRUD operations and JWT authentication with Passport. It includes a simple API for managing users.
Requirements

    PHP 7.3 or higher
    Laravel 7 or higher
    Composer
    MySQL

Installation

    Clone the repository:

bash

git clone https://github.com/your_username/basic-crud-jwt-auth-laravel.git

    Install dependencies:

composer install

    Create a new database in MySQL.

    Copy the .env.example file and rename it to .env. Edit the database credentials in this file.

makefile

DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

    Generate a new application key:

vbnet

php artisan key:generate

    Run the database migrations:

php artisan migrate

    (Optional) Seed the database with sample data:

php artisan db:seed

    Start the server:

php artisan serve

Usage
Authentication

To authenticate a user, send a POST request to /api/auth/login with the following parameters:

    email: the user's email address
    password: the user's password

If the credentials are correct, the API will return a JSON response containing a JWT token:

json

{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMwOGUwOTZkNj...",
    "token_type": "Bearer",
    "expires_in": 3600
}

Include this token in the Authorization header of subsequent requests:

makefile

Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMwOGUwOTZkNj...

To logout, send a POST request to /api/auth/logout. This will invalidate the token.
Users

The API includes endpoints for managing users:

    GET /api/users: get a list of all users
    POST /api/users: create a new user
    GET /api/users/{id}: get a single user by ID
    PUT /api/users/{id}: update a user by ID
    DELETE /api/users/{id}: delete a user by ID

You must include a valid JWT token in the Authorization header for these requests.
Example Requests

To create a new user:

bash

POST /api/users

{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "password"
}

To update a user:

bash

PUT /api/users/1

{
    "name": "Jane Doe",
    "email": "jane.doe@example.com"
}

To delete a user:

bash

DELETE /api/users/1

License

This project is licensed under the MIT License. See the LICENSE file for details.
