# Docker Setup for Laravel Moneybag E-Commerce App

This project has been dockerized with PHP-FPM and Nginx for easy deployment.

## Prerequisites

- Docker
- Docker Compose

## Quick Start

1. **Build and start the containers:**
   ```bash
   make build
   make up
   ```
   
   Or using docker-compose directly:
   ```bash
   docker-compose build
   docker-compose up -d
   ```

2. **Access the application:**
   - Open your browser and visit: http://localhost:8000

3. **Update Moneybag API Key:**
   - Edit `.env.docker` file and update `MONEYBAG_MERCHANT_API_KEY` with your actual key
   - Restart containers: `make restart`

## Available Commands

Using Make:
- `make build` - Build Docker images
- `make up` - Start containers in detached mode
- `make down` - Stop and remove containers
- `make restart` - Restart all containers
- `make logs` - View container logs
- `make shell` - Access the app container shell
- `make migrate` - Run database migrations
- `make seed` - Seed the database
- `make fresh` - Fresh install (migrate fresh and seed)

Using Docker Compose:
- `docker-compose up -d` - Start containers
- `docker-compose down` - Stop containers
- `docker-compose logs -f` - View logs
- `docker-compose exec app bash` - Access container shell
- `docker-compose exec app php artisan migrate` - Run migrations

## Docker Configuration

### Services

1. **app** (PHP-FPM 8.3)
   - Laravel application
   - SQLite database
   - All PHP extensions required

2. **webserver** (Nginx)
   - Serves the application
   - Proxies PHP requests to PHP-FPM

### Volumes

- Application code is mounted as a volume for development
- SQLite database persists in `database/database.sqlite`

### Environment

- Environment variables are in `.env.docker`
- Copy to `.env` on first run (handled automatically)

## Troubleshooting

1. **Port already in use:**
   - Change port in `docker-compose.yml` from `8000:80` to another port

2. **Permission issues:**
   - Run: `docker-compose exec app chown -R www-data:www-data storage bootstrap/cache`

3. **Database not found:**
   - Run: `docker-compose exec app php setup-db.php`
   - Or: `make fresh`

4. **Clear caches:**
   ```bash
   docker-compose exec app php artisan config:clear
   docker-compose exec app php artisan cache:clear
   ```

## Production Deployment

For production:
1. Update `.env.docker` with production values
2. Set `APP_DEBUG=false` and `APP_ENV=production`
3. Use proper Moneybag production API URL
4. Consider using external database instead of SQLite
5. Add SSL/TLS configuration to Nginx