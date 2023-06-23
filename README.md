## Carrot Food Service

This is a food ordering, management and delivery service. 

This project was built using Laravel and database postgres. However, any database i.e mysql can also be used.

## Installation Guide

- clone the repo and run *composer install* to get packages.
- run *php artisan jwt:secret* to generate the JWT secret for security.
- set up your database (postgres/mysql) in the .env and run *php artisan migrate* to migrate relations.
- run *php artisan serve* to start development server,
- import the POSTMAN collection inside /collections/Carrot Food Service.postman_collection.json into POSTMAN.
- run the *Create User* endpoint to create a new user/customer/business_owner 
- then use the *Login* endpoint to generate the bearer token for subsequent requests.


## Thank You!
