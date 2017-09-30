.PHONY: build

build:
	docker-compose run node npm run build
	docker build -t pimcore-boilerplate .
