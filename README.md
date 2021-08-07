

## Kadonation - PHP Developer Challenge

- Navigate to project's root directory
- Copy local environment config - `cp .env.example .env`
- Install PHP dependencies - `composer install`
- Configure Sail bash alias - `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'`
- Run Sail - `sail up -d`
- Generate app key - `sail artisan key:generate`
- Run migrations with seed data - `sail artisan migrate --seed`
- Run tests - `sail artisan test`

### Notes

- Swagger API Documentation can be found here - http://localhost/api/documentation
- Postman collection - https://documenter.getpostman.com/view/500686/TzskDNYf
