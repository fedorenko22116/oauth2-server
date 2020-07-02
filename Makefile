.PHONY: up down stop build build-dev

PROJECT_NAME?=oauth2-server

up:
	docker-compose -p ${PROJECT_NAME} -f .docker/dev/docker-compose.yml up -d

down:
	docker-compose -p ${PROJECT_NAME} -f .docker/dev/docker-compose.yml down

stop:
	docker-compose -p ${PROJECT_NAME} -f .docker/dev/docker-compose.yml stop

build:
	docker build . --tag oauth2-server:latest --file .docker/prod/Dockerfile

build-dev: build
	docker build . --tag oauth2-server-dev:latest --file .docker/dev/Dockerfile
