#!/bin/bash

echo "Running composer api-gateway..."
cd api-gateway
composer install

echo "Running composer  payment-service..."
cd ../payment-service
composer install

echo "Running composer  for finansbak-service..."
cd ../finansbank-service
composer install

echo "Running composer  for garanti-service..."
cd ../garanti-service
composer install

cd ../hsbc-service
composer install

echo "Setup completed."