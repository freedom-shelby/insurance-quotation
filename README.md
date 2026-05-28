# Insurance Quotation

A travel insurance quotation API built with Laravel 13 and PHP 8.5, with JWT authentication and a minimal frontend.

## Requirements

- Docker & Docker Compose

## Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd insurance-quotation

# 2. Copy environment file and configure
cp .env.example .env

# Edit .env:
# DB_CONNECTION=mysql
# DB_HOST=db
# DB_DATABASE=insurance_quotation
# DB_USERNAME=root
# DB_PASSWORD=root

# 3. Start containers
docker compose up -d --build

# 4. Install PHP dependencies
docker exec insurance_app composer install

# 5. Generate application and JWT keys
docker exec insurance_app php artisan key:generate
docker exec insurance_app php artisan jwt:secret

# 6. Run migrations and seed the database
docker exec insurance_app php artisan migrate --seed
```

The application is now available at **http://localhost:8080**

## Seeded Demo User Credentials

```
Email: test@test.com
Password: test
```
