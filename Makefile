
project-up:
	cp ./src/.env.example ./src/.env
	docker compose build
	docker compose up -d
	docker compose exec app php artisan key:generate --ansi
	docker compose exec app php artisan migrate
	docker compose exec app php artisan l5-swagger:generate
