up:
	docker-compose -f .docker/docker-compose.yml up -d

down:
	docker-compose -f .docker/docker-compose.yml down

stop:
	docker-compose -f .docker/docker-compose.yml stop

build:
	docker-compose -f .docker/docker-compose.yml build
