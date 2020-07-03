.PHONY: up down stop rm build build-dev build-all ssh setup

PROJECT_NAME=oauth2-server
COMPOSE_FILE=.docker/dev/docker-compose.yml

setup: rm build-all

up:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} up -d

down:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} down

stop:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} stop

rm: stop
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} rm -f

build:
	docker build . --tag oauth2-server:latest --file .docker/prod/Dockerfile

build-dev:
	docker build . --tag oauth2-server-dev:latest --file .docker/dev/Dockerfile

build-all: build build-dev

ssh:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} exec app sh
