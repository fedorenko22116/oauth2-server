.PHONY: up down stop rm build ssh setup pull

PROJECT_NAME?=oauth2-server
COMPOSE_FILE?=docker/dev/docker-compose.yml

setup: rm pull build

up:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} up -d

down:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} down

stop:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} stop

rm: stop
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} rm -f

pull: rm
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} pull

build:
	docker build . --tag 22116/oauth2-server:latest --file docker/prod/Dockerfile

ssh:
	docker-compose -p ${PROJECT_NAME} -f ${COMPOSE_FILE} exec app sh
