# API Gateway
API Gateway enables microservice architecture in the API Resources. The Gateway acts as an access point for accessing different resources instead of having different links for different APIs. By also implementing the gateway, API Resouces doesn't need to problem about security, and response type.

## Installation
This project uses Laravel framework. Follow the steps for the basic installation:
1. composer install
2. git submodule update --init --recursive
3. git submodule update --recursive --remote
4. composer dump-autoload
5. composer update
6. php artisan key:generate
7. php artisan jwt:secret
8. php artisan config:cache
9. php artisan migrate
10. php artisan db:seed
