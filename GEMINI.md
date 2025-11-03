# Project Overview

This is a web application for selling used goods, built with the Laravel framework. The frontend is built using Tailwind CSS and Alpine.js, and it is compiled with Vite. The application allows users to browse and view products, while authenticated users can manage their own products, and administrators can manage categories, users, and feedback.

# Building and Running

**Prerequisites:**

*   PHP >= 8.2
*   Composer
*   Node.js & npm

**Installation:**

1.  Clone the repository.
2.  Install PHP dependencies: `composer install`
3.  Install Node.js dependencies: `npm install`
4.  Create a `.env` file by copying `.env.example`: `cp .env.example .env`
5.  Generate an application key: `php artisan key:generate`
6.  Create a database and configure the `.env` file with the database credentials.
7.  Run database migrations: `php artisan migrate`

**Running the application:**

*   To start the development server, run: `npm run dev`
*   This will start the Vite development server and the Laravel development server.

**Testing:**

*   To run the test suite, use the following command: `php artisan test`

# Development Conventions

*   The project follows the standard Laravel project structure.
*   Frontend assets are located in the `resources` directory and compiled to the `public/build` directory.
*   Routes are defined in the `routes/web.php` file.
*   Controllers are located in the `app/Http/Controllers` directory.
*   Models are located in the `app/Models` directory.
*   Views are located in the `resources/views` directory.
