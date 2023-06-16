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



.PHONY: tests
