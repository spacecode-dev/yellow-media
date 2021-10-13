# Test Task for Yellow Media

## Task Description

### Stack:
- Lumen
- PostgreSQL

### Task:
Create RESTFull API.

### Description:
Create the API to share the company's information for the logged users.

### Details:

Create DB migrations for the tables: users, companies, etc.
Suggest the DB structure. Fill the DB with the test data.

#### Endpoints:

https://domain.com/api/user/register
- method POST
- fields: first_name [string], last_name [string], email [string], password [string], phone [string]

https://domain.com/api/user/sign-in
- method POST
- fields: email [string], password [string]

https://domain.com/api/user/recover-password
- method POST/PATCH
- fields: email [string] // allow to update the password via email token

https://domain.com/api/user/companies
- method GET
- fields: title [string], phone [string], description [string]
- show the companies, associated with the user (by the relation)

https://domain.com/api/user/companies
- method POST
- fields: title [string], phone [string], description [string]
- add the companies, associated with the user (by the relation)

## Server Requirements

- PHP >= 7.3
- OpenSSL PHP Extension
- PDO PHP Extension
- PDO pgSQL PHP Extension
- Mbstring PHP Extension
- Postgres 14.0 (latest)

## Deploy the application

- fill .env file
- composer install
- php artisan key:generate (\App\Console\CommandsKeyGenerateCommand.php)
- php artisan migrate
- php artisan db:seed 
- Test User Email - user@gmail.com
- Test User Password - password

### Development solutions

1. https://domain.com/api/user/recover-password with method PATCH was changed to https://domain.com/api/user/recover-password/{$token} with methods POST with fields: email, password. Because method POST (https://domain.com/api/user/recover-password) return email_token (password_resets table) and this token we use in method POST (https://domain.com/api/user/recover-password/{$token} with email and new password fields) to update User Password.
