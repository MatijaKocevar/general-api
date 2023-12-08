# Php Symfony API

This project is a simple API built using PHP Symfony.

## Description

This project will be a general API for storing and getting data from a MySql database.

## Installation

To get started with the project, follow these steps:

1. Clone the repository: git clone https://github.com/MatijaKocevar/general-api.git
2. Navigate to the project directory: cd general-api
3. Install dependencies: composer install
4. Configure the database connection in the .env file.
5. Create the database: php bin/console doctrine:database:create
6. Apply database migrations: php bin/console doctrine:migrations:migrate
7. Start the development server: symfony serve

## Usage

To use the API, follow these steps:

1. Make sure the development server is running.
2. Open your preferred API testing tool (e.g., Postman).
3. Send HTTP requests to the available endpoints.
