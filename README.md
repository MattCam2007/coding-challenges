# Senior PHP Developer Challenge

## Matthew Cameron

### Introduction
As requested, I have created a basic API service which is capable of full CRUD operations on a basic product object
and perform a read operation on the Product Categories in the system.

I used Symfony 4, PHP 7.2, MySQL 5.7 and Docker to complete the challenge.

Overall, the request hits the router, and is routed to the correct method on the controller based on the request method.
The method will then do any necessary pre-processing and pass the call to the `ProductService` class. This is a 
light-weight service class which receives an object of type `ProductHandlerInterface`. The services.yaml configuration 
file defines that `DoctrineHandler` will be used. This approach allows for the database and all requisite code specific
to the datasource can be abstracted and switched with very littler refactor work. The handler passes
the data back up to the controller where the response is crafted and returned as a JSON object.

It has been some time since I last worked in Symfony, and time was a little short for me, but I have tried to follow 
(and learn)Symfony standards while also demonstrating some of my code style.

### Product Controller

**GET** requests can receive either and ID or no ID. If an ID is passed, the application will return a single product 
based on the ID that is passed.

*These requests do not require authentication*

**POST** requests do not receive an ID. These are used to create new products. The body of the request is expecting:
* Name
* ProductCategory
* Quantity
* Price
* Sku

*These requests do require authentication - explained later*

**PATCH** requests require an ID. These requests are for updating a product. The body of the request can contain any
of the following:
* Name
* ProductCategory
* Quantity
* Price
* Sku

*These requests do require authentication - explained later*

**DELETE** requests require an ID. These requests will delete the product (by ID) from the database.

*These requests do require authentication - explained later*

### Product Category Controller

**GET** These requests do not accept and ID. This will return all of the distinct Product Categories from the database.

*These requests do not require authentication*

### Authentication

Normally when I am working with services, I would have a dedicated service for authentication. These endpoints would
receive a Username and a Password and generate a token with an expiry date. Each call would receive the request and
parse the header for the token, and validate the token against the same authentication service.

Due to limited time, I have written a basic username and password into the necessary requests.

To validate, pass as a header the values of `email` and `password`. The 2 provided users are in the system with the
password of `qwert`. User CRUD has not been written, if additional users are desired, it is a basic `md5` has being
stored. Easy enough to create new records as needed.

### Documentation
Provided as supplemental documentation is the Postman collection that I used to develop and test the API. I find this
helpful for validating functionality and testing for errors. The most up to date and tested version before sending this
off has been provided. I am assuming if you are writing API's you have the ability to consume a Postman Collection.

### Installation
* The first step is just execute `composer install` to install the dependencies.

* Execute `docker-compose up` from the root directory to start the apache and mysql containers. The apache container
has a startup script that waits for 15 seconds, then executes the initial Doctrine migration script. If there are 
database issues (table does not exist), it may be that the timing needs to be adjusted in `bin/start`. I have prepared 
this challenge with a slight adjustment to my standard dockerized process for creating APIs. I generally use 
docker-compose to manage my docker environments in development for the ease of use and edits.


* After that, the API should be accessible at `http://localhost:10802/`

If the seed data is desired for testing, there is an endpoint coded that will parse the provided JSON data and insert.
`[GET] http://localhost:10802/api/seed` will populate the database with the seed data.

### API Format
*Standard Response*
```
{
    "payload": {
        "Product": [
            {
                "ProductId": 15,
                "Name": "Pong",
                "ProductCategoryController": "Games",
                "Sku": "A0001",
                "Price": "69.99",
                "Quantity": 20
            }
        ]
    }
}
```

The content returned from the service is wrapped in a payload object. I have learned to like this format because it
allows for a meta object which can include versions and response time to process the request.
---
*Error Response*
```
{
    "payload": {
        "Error": "Product 1 not found!"
    }
}
```
All errors that are managed by the API are returned as en Error object.

### Logging
All logging in the system is being managed by the php `error_log` function. In a perfect world with more time, I would
like to see a PSR-3 compliant logging module to be installed and configured to work with the docker container.