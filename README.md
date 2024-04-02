# **CRM - User Permission Role Module**

## Overview

The "User Permission Role Module" project in Laravel is all about controlling who can do what in an application. It uses special tools in Laravel to make sure only the right people can access certain parts of the app. It also makes it easy to manage what different types of users, like admins or regular users, are allowed to do. This project helps keep the app safe by only letting authorized users in and keeping track of who's doing what.

## Features

- User Management: Registration, login, and profile management.
- Role Management: Creating, editing, and assigning roles like admin or user.
- Permission Management: Defining and assigning permissions for different actions.
- Access Control Lists (ACL): Enforcing permissions to control user access.
- Middleware Integration: Using middleware for authentication and authorization.
- Logging and Auditing: Tracking user activities and changes for security.
- User-Friendly Interface: Intuitive interface for administrators to manage roles and permissions.
- Security Measures: Implementing measures to ensure application security.
- Scalability and Flexibility: Designing for easy expansion and modification as needed.

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 21.6.2
- NPM >= 10.2.4
- MySQL

## installation

Step 1: Clone the Repository

Clone the repository to your local machine using Git.

```bash
$ git clone https://github.com/shreya-zignuts/user-role-permission-crm.git
```

Step 2: Navigate to the Project Directory

Change your current directory to the project directory.

```bash
$ cd user-permission-crm
```

Step 3: Install Composer Dependencies

Install the PHP dependencies using Composer.

```bash
$ composer install
```

Step 4: Install NPM Dependencies

Install the JavaScript dependencies using NPM.

```bash
$ npm install
```

Step 5: Copy the Environment File

Copy the .env.example file to .env.

```bash
$ cp .env.example .env
```

Step 6: Generate Application Key

Generate an application key.

```bash
$ php artisan key:generate
```

Step 7: Configure Database Connection

Configure your database connection in the .env file.

```make
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Configure your mail connection in the .env file.

```make
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=11791eecc7d5d8
MAIL_PASSWORD=82679e4f755756
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME=null
```

Step 8: Run Migrations and Seeders

Run database migrations and seeders to create database tables and populate them with initial data.

```bash
$ php artisan migrate --seed
```

Step 9: Compile Assets

Compile assets using Laravel Mix.

```bash
$ npm run dev
```

Step 10: Start the Development Server

Start the development server to run the application.

```bash
$ php artisan serve
```

Step 11: Access the Application

Open your web browser and visit http://localhost:8000 to access the application.
