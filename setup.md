##Steps are as follows:

1. git clone https://github.com/YatinChachra/url-encoder.git
2. composer install 
3. vim .env [and add the database credentials to the env file]
4. php artisan key:generate
5. php artisan migrate
6. php artisan serve
7. Visit http:/localhost/admin/url-encoder [to test the application] 

NOTE: if facing issue with composer install, try composer install --ignore-platform-reqs

NOTE: This is a laravel admin based application

 