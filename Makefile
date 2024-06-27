build:
	docker-compose build

start:
	docker-compose up -d

stop:
	docker stop aeestarreja_app
	docker stop aeestarreja_db

fix:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/public:/var/www/html -v $(CURDIR)/phpcs.xml:/var/www/html/phpcs.xml php:7.4-apache bash -c "cd /var/www/html && php vendor/bin/phpcbf"

stan:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/phpstan.neon:/var/www/html/phpstan.neon -v $(CURDIR)/app:/var/www/html php:7.4-apache bash -c "cd /var/www/html && php vendor/bin/phpstan analyse"

phpcs:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/phpcs.xml:/var/www/html/phpcs.xml -v $(CURDIR)/app:/var/www/html php:7.4-apache bash -c "cd /var/www/html && php vendor/bin/phpcs"

ssh:
	docker exec -it aeestarreja_app bash

ssh-db:
	docker exec -it aeestarreja_db bash

open:
	open http://localhost:8090/

ui:
	docker exec -it aeestarreja_app sh -c "cd /var/www/html/application/themes/aee/assets && yarn install && yarn production"

composer:
	docker exec -it aeestarreja_app sh -c "cd /var/www/html && composer install"

doctrine:
	docker exec -it aeestarreja_app sh -c "cd /var/www/html && concrete/bin/concrete5 orm:generate:proxies"

git-pull:
	eval $(ssh-agent -s) && ssh-add ~/.ssh/aeestarreja_rsa && git pull

deploy:
	$(MAKE) git-pull
	$(MAKE) composer
	$(MAKE) doctrine
	$(MAKE) ui

sync-files:
    cd /Users/pedropiedade/Documents/http/pedro/aeestarreja/aeestarreja/service/application && rsync -arv --stats --exclude='cache' root@68.183.78.54:/var/www/html/public/application/files .