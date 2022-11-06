build:
	docker compose build

rebuild:
	docker compose build --no-cache

create-network:
	docker network create carrent-network

run:
	docker compose up -d
	docker compose exec --user www backend composer install

install:
	docker compose exec --user www backend composer install

swagger:
	docker compose exec --user www backend php artisan l5-swagger:generate

test:
	docker compose exec --user www backend php artisan test

db-wipe:
	docker compose exec --user www backend php artisan db:wipe

migrate:
	docker compose exec --user www backend php artisan migrate

artisan:
	docker compose exec --user www backend php artisan $(COMMAND)

cs-fixer:
	docker compose exec --user www backend ./vendor/bin/php-cs-fixer fix

bash:
	docker compose exec --user www backend sh

bash-su:
	docker compose exec backend sh

stop:
	docker compose stop

down:
	docker compose down

del_database:
	docker compose down -v
