# Simple Blog API

## Description

This is a Simple Blog API built using PHP 8, Laravel 8, MySQL 8, Redis, WSS, and JWT tokens. It features user registration, login, and logout, as well as CRUD operations for blog posts and users.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Authentication](#authentication)
- [Endpoints](#endpoints)
- [Roles and Privileges](#roles-and-privileges)
- [Built With](#built-with)
- [Contributing](#contributing)
- [License](#license)

## Installation

```bash
# Clone the repository
git clone https://github.com/SRUchlewicz/Simple-Blog-API.git

# Navigate into the directory
cd simple-blog-api

# Install dependencies
composer install

# Copy .env.example to .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seed the database
php artisan migrate
Php artisan db:seer RolesTableSeeder

# link storage
php artisan storage:link

# Start the server
php artisan serve
```

## Configuration

This application relies on several services and configurations to work correctly. Make sure you have the following services running and configured in your `.env` file:

### Horizon

[Laravel Horizon](https://laravel.com/docs/8.x/horizon) is used for managing queues. Make sure you install it and run it:

```bash
php artisan horizon
```

### Redis

The application uses [Redis](https://redis.io/) for caching and as a queue driver. Make sure Redis is installed and running. Update the following `.env` settings accordingly:

```env
REDIS_HOST=your_redis_host
REDIS_PASSWORD=your_redis_password
REDIS_PORT=your_redis_port
```

### Queue Worker

Laravel's [queue worker](https://laravel.com/docs/8.x/queues#running-the-queue-worker) is used for background job processing. Make sure to run the queue worker:

```bash
php artisan queue:work
```

### WebSockets (WSS)

For real-time features, the application uses WebSockets. Configure the WebSocket settings in your `.env`:

```env
WEBSOCKET_BROADCAST_HOST=your_websocket_host
WEBSOCKET_BROADCAST_PORT=your_websocket_port
WEBSOCKET_BROADCAST_SCHEME=your_websocket_scheme
```

### JWT Secret

JWT authentication is used, make sure to generate a JWT secret key:

```bash
php artisan jwt:secret
```

And update your `.env`:

```env
JWT_SECRET=your_generated_jwt_secret
```

### Custom Configurations

The application has a few custom configurations for features like password reset token TTL, roles allowed for login, and pagination. Update these in your `.env`:

```env
RESET_PASSWORD_TOKEN_TTL=your_value_in_minutes
ALLOWED_ROLES_FOR_LOGIN=role1,role2
NUMBER_OF_ENTITIES_PER_PAGE=your_pagination_value
```


## Usage

### Base URL
Local development: `http://localhost:8000/api/v1`

### Examples

#### Register a User
```bash
curl --request POST \
  --url http://localhost:8000/api/v1/register \
  --header 'Content-Type: application/json' \
  --data '{
	"firstname": "johndoe",
	"email": "john.doe@email.com",
	"password": "yourpassword"
}'
```

#### Create a Post
```bash
# You will need a valid JWT token here
curl --request POST \
  --url http://localhost:8000/api/vi/posts \
  --header 'Authorization: Bearer YOUR_JWT_TOKEN' \
  --header 'Content-Type: application/json' \
  --data '{
	"title": "My first post",
	"body": "This is the content of my first post."
}'
```

## Authentication

The API uses JWT for authentication. Obtain a token by logging in, and use the token in the `Authorization` header for subsequent requests.

## Endpoints

For detailed endpoint documentation, refer to the auto-generated Swagger documentation available at `http://localhost:8000/api/documentation`.

## Roles and Privileges

The API supports multiple roles:
- User: Currently nothing
- Editor: Inherits User privileges, can create, edit, delete and list posts.
- Admin: Inherits all privilege and can manage users.

## Built With

- PHP 8
- Laravel 8
- MySQL 8
- Redis
- WSS
- JWT

## Contributing

To contribute to this project, please make a fork, create a feature branch, and submit a pull request.

## License

This project is licensed under the MIT License.

---

Feel free to modify this template to better suit the specifics of your project.