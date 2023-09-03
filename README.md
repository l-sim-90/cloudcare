## Getting started

### Prerequisites
- Docker
- Docker Compose

### Installation
1. Clone the repo
   ```sh
   git clone
    ```
2. Build the docker image
    ```sh
    docker-compose build
    ```
3. Run the docker container
    ```sh
    docker-compose up
    ```
4. Open the browser and go to http://localhost:8080

### Seed the database
1. Run the laravel migration
    ```sh
    docker-compose exec app php artisan migrate
    ```
2. Run the laravel seeder
    ```sh
    docker-compose exec app php artisan db:seed
    ```
3. Open the browser and go to http://localhost:8081 to verify the data

### Run the test

1. Run the laravel test
    ```sh
    docker-compose exec app php artisan test
    ```
