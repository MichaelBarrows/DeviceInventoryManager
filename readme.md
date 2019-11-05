## Device Inventory Manager
This application provides an API for managing devices assigned to people and their associated assets.

### installation
To install this application, run:
 ```
 git clone https://github.com/MichaelBarrows/DeviceInventoryManager.git
 composer install
 npm install
 ```
 Then either run ``` cp .env.example .env ``` or rename the ``` .env.example``` file to ``` .env ```.

 Add your database details to the ``` .env ``` file so that the database can be created and populated.

 Then run:
 ```
 php artisan key:generate
 php artisan migrate --seed
 php artisan serve
 ```

 the API will be available at ``` http://localhost:8000/api ``` and the front-end page will be available at ``` http://localhost:8000/users ```.

``` Note:  ```  all of the routing can be found in the table in the documentation or by running ``` php artisan route:list ```
