 **Technology**

- PHP 7.1.3

- Data was persisted with MySql 5.6 
    - Connection details:
        - port: `3306`
        - MYSQL_DATABASE: `voucher_pool_db`
        - MYSQL_USER: `voucher_pool`
        - MYSQL_PASSWORD: `voucher_pool`

- Testing was done with PhpUnit 

 **Packages**

- This can be found in the composer.json in the root directory of the project

-PhpUnit 7.0 was used for testing , am more familiar with this than others like Codeception and Behat


 **How to run**
- Clone for Github
```bash
git clone git@github.com:liman4u/voucher-pool.git

cd voucher-pool
```

- To start the application server and run tests, run the following from root of application:
```bash
sh ./install.sh
```
- Tests can also be run separately by running[from the project's root folder] "composer test" when the docker container is up and running

- In case the install.sh does not seem to be runnable, use chmod 400 install.sh

 **Features**

The API  conformed to REST practices and  provide the following functionality:

- Generate voucher codes for recipients given Special Offer and Expiration Date
- Validate voucher codes and return percentage discounts
- Return all voucher codes with Special Offer of a recipient

 **Endpoints**

- The postman documentation link is https://documenter.getpostman.com/view/3189851/RWToRJ8R

- This application conform to the specified endpoint structure given and return the HTTP status codes appropriate to each operation.  


 **Environment Variables**

- These are found in .env of the root directory of the project

- For production deployments , DEBUG should be switched to 'false' and APP_ENV changed to 'production'


 **Data Initial Migration**

- This is found in database/db_migration.sql in the root directory of the project

- This contains initial database schema migration as well as sample data seeds 

 **Routes**

- This can be found in app/Context/Api/routes.php in the root directory of the project