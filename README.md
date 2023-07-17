# Highscore API

This project is a simple API built using PHP Symfony.

## Description

The API provides endpoints for saving scores of a Space Invaders game. It is built using the PHP Symfony framework, which provides a robust and efficient development environment for creating web applications.

## Installation

To get started with the project, follow these steps:

1. Clone the repository: git clone https://github.com/MatijaKocevar/highscoreAPI.git
2. Navigate to the project directory: cd highscoreAPI
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
