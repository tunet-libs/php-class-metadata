SHELL := /bin/sh



docker-up: docker-down
	docker compose up -d --build

docker-down:
	docker compose down

docker-restart: docker-up

run-php:
	docker compose exec php zsh

run-tests:
	vendor/bin/phpunit

run-check-codestyle:
	vendor/bin/phpcs src tests --standard=phpcs.xml

run-static-analyze:
	vendor/bin/phpstan analyse src --configuration phpstan.neon



.PHONY: tests
