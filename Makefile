# VARIÁVEIS
CONTAINER = ""


dev-up:
	docker-compose -f docker-compose.dev.yml up -d --build

dev-up-interact:
	docker-compose -f docker-compose.dev.yml up --build

dev-down:
	docker-compose -f docker-compose.dev.yml down

dev-clear:
	docker-compose -f docker-compose.dev.yml down -v

dev-app-logs:
	docker exec -it tinder-app-dev cat storage/logs/laravel.log

prod-up:
	docker-compose -f docker-compose.prod.yml up -d --build

prod-container-logs:
	docker logs $(CONTAINER)

prod-app-logs:
	docker exec -it tinder-app-prod cat storage/logs/laravel.log

prod-down:
	docker-compose -f docker-compose.prod.yml down

prod-down-apagatudosemdonaouseisso:
	docker-compose -f docker-compose.prod.yml down -v

prod-migrate-database:
	docker exec tinder-app-prod php artisan migrate --force
	docker exec tinder-app-prod php artisan db:seed --force
