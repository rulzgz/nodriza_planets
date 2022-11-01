error:
	@echo "Por favor elige una opción válida (help, build, run, stop, status, composer-install, composer-update, shell)"

build:
	docker-compose up -d --build && docker-compose exec php composer install -n && sleep 5 && docker-compose exec php php bin/console doctrine:migrations:migrate

run:
	docker-compose up -d

stop:
	docker-compose stop

status:
	@docker-compose ps

composer-install:
	docker-compose exec php composer install

composer-update:
	docker-compose exec php composer update

shell:
	docker-compose exec php /bin/bash

help:
	@echo ""
	@echo "------------------------------------------------------------------------------------"
	@echo " Están disponibles las siguientes opciones:"
	@echo "------------------------------------------------------------------------------------"
	@echo ""
	@echo "   make help             - Muestra esta ayuda"
	@echo "   make build            - Construye los contenedores docker e instala la aplicación"
	@echo "   make run              - Ejecuta la aplicación"
	@echo "   make stop             - Detiene la aplicación"
	@echo "   make status           - Muestra status de los contenedores"
	@echo "   make composer-install - Ejecuta 'composer install' en la aplicación"
	@echo "   make composer-update  - Ejecuta 'composer update' en la aplicación"
	@echo "   make shell            - Inicia una shell en el contenedor php"

	
