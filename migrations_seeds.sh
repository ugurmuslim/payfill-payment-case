#!/bin/bash

echo "Running migrations for api-gateway..."
docker-compose exec api-gateway php artisan migrate:refresh

echo "Running migrations for payment-service..."
docker-compose exec payment-service php artisan migrate:refresh

echo "Seeding the database for api-gateway..."
docker-compose exec api-gateway php artisan db:seed

echo "Seeding the database for payment-service..."
docker-compose exec payment-service php artisan db:seed

echo "Running migrations for finansbank-service..."
docker-compose exec finansbank-service php artisan migrate:refresh

echo "Running migrations for garanti-service..."
docker-compose exec garanti-service php artisan migrate:refresh

echo "Running migrations for hsbc-service..."
docker-compose exec hsbc-service php artisan migrate:refresh



# Step 5: Show the status of the containers
echo "Displaying the status of the containers..."
docker-compose ps

echo "Setup completed."