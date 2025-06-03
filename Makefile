dev-up:
	docker-compose -f docker-compose.dev.yml up --build

dev-down:
	docker-compose -f docker-compose.dev.yml down

dev-clear:
	docker-compose -f docker-compose.dev.yml down -v

prod:
	export $(cat .env.prod | xargs) && docker-compose up -d
