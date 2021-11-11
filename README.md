# REST API 
PHP Native REST API for Technical Test in _confidential_ 

NB: This project purely build with Native PHP with some installed packages.

Author of this Project: Mohamad Febrian Mosii <<febrianaries@gmail.com>>

## Requirements

  - Requires **PHP 8.0** 
  - MariaDB 10.0 or higher for spatial features in MySQL
  - Any PHP Webserver (Apache / Nginx)

## Installation on local machine

Clone this project in the webserver, cd to the project's folder, and run packages installation using below syntax (note: make sure PHP 8.0 installed to your machine)

    composer install

Copy `.env.example` to `.env`

**Create empty database** and configure your database by editing `.env` file and edit these following lines

     APP_HOST     = "your-host"
     APP_DATABASE = "your-database"
     APP_USERNAME = "root"
     APP_PASSWORD = "your-password"

You can change X_API_KEY in `.env` for authorization key in request header or leave it if you want to use default key.

After database **configured properly**, run this line to migrate table and data seeds into your database.

    php migrate.php

Or if you want to import manually to database, you can find dumped sql in "`db/dump.sql`".

## Endpoints

**NB: Make sure to always include index.php in URL to prevent error.**

POSTMAN Documentation is available on `docs` folder.

* `POST - http://localhost:8000/{project-name}/index.php/api/v1/transaction` 

  * Headers: 

    * X-API-KEY - `Fill this value based on X_API_KEY variable in .env file`

  
  * Body Params **(Form-data)**: 
   
    * invoice_id (string) - `Required`
    * items[0][item_name] (string) - `Items parameter required at least one of array object`
    * items[0][amount] (integer) 
    * payment_type:virtual_account (enum) - `Required available: virtual_account || credit_card`
    * customer_name:Febrian (string) - `Required`
    * merchant_id (integer) - `Required, note: merchant id can be seen on ref_merchants table`

  * Body Params Example **(Form-data)**: 
  
    * invoice_id:INV-101121-000103
    * items[0][item_name]:Saos Abc
    * items[0][amount]:3
    * items[1][item_name]:Sambel Terasi
    * items[1][amount]:1
    * items[2][item_name]:Indomie Goreng
    * items[2][amount]:2
    * payment_type:virtual_account
    * customer_name:Febrian
    * merchant_id:1

* `GET - http://localhost:8000/{project-name}/index.php/api/v1/transaction` 

  * Headers: 

    * X-API-KEY - `Fill this value based on X_API_KEY variable in .env file`

  
  * Params: 
   
    * merchant_id (integer) - `Required this field is required if references_id is not being filled`
    * references_id (string) - `Optional`

  * Params Example: 
  
    * // merchant_id:1
    * references_id:da4b9237bacccdf19c0760cab7aec4a8359010b0
     
    OR

    * merchant_id:1
    * // references_id:da4b9237bacccdf19c0760cab7aec4a8359010b0
    
## Updating Transaction Status

Open any of terimnal and cd to the project's folder, and run this following line:

    php transaction-cli.php  {references_id} {status}

Note: please don't include '{' and '}' in the command line

`status` available:
- Pending
- Paid
- Failed

