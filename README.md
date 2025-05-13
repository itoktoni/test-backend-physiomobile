# Patient Management API

A Laravel-based RESTful API for managing patient records with secure access key authentication.

## Features

- Patient CRUD operations
- Access key authentication
- Input validation
- Error handling
- API documentation, please refer to http://physiomobile.itoktoni.com/docs

## Requirements

- PHP >= 8.1
- Composer
- SQLite/MySQL
- Git

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd patient

copy .env .env.testing

APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
API_ACCESS_KEY=test-access-key-123

php artisan test

## IN Production

to access API key in header using

please put X-API-Key=12345