.PHONY: help build up down restart logs shell migrate seed fresh

help:
	@echo "Available commands:"
	@echo "  make build    - Build Docker images"
	@echo "  make up       - Start containers"
	@echo "  make down     - Stop containers"
	@echo "  make restart  - Restart containers"
	@echo "  make logs     - View container logs"
	@echo "  make shell    - Access app container shell"
	@echo "  make migrate  - Run database migrations"
	@echo "  make seed     - Seed the database"
	@echo "  make fresh    - Fresh install (migrate fresh and seed)"

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose down && docker-compose up -d

logs:
	docker-compose logs -f

shell:
	docker-compose exec app bash

migrate:
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed

fresh:
	docker-compose exec app php artisan migrate:fresh --seed