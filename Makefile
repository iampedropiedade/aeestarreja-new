build:
	docker compose build

start:
	docker compose up -d

stop:
	docker stop aeestarreja_app
	docker stop aeestarreja_db

fix:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/public:/var/www/html -v $(CURDIR)/phpcs.xml:/var/www/html/phpcs.xml php:8.2-apache bash -c "cd /var/www/html && php vendor/bin/phpcbf"

stan:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/phpstan.neon:/var/www/html/phpstan.neon -v $(CURDIR)/app:/var/www/html php:8.2-apache bash -c "cd /var/www/html && php vendor/bin/phpstan analyse"

phpcs:
	docker run --entrypoint "" --rm -it -v $(CURDIR)/phpcs.xml:/var/www/html/phpcs.xml -v $(CURDIR)/app:/var/www/html php:8.2-apache bash -c "cd /var/www/html && php vendor/bin/phpcs"

bash:
	docker exec -it aeestarreja_app bash

bash-db:
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
	eval $(ssh-agent -s) && ssh-add ~/.ssh/id_rsa && git pull

permissions:
	docker exec -it aeestarreja_app sh -c "cd /var/www/html && sudo chmod -R 775 application/config/generated_overrides && sudo chown -R www-data:www-data application/config/generated_overrides && sudo chmod -R 775 application/config/doctrine && sudo chown -R www-data:www-data application/config/generated_overrides && sudo chmod -R 775 application/files/cache && sudo chown -R www-data:www-data application/files/cache"

deploy:
	$(MAKE) git-pull
	$(MAKE) build
	$(MAKE) stop
	$(MAKE) start
	$(MAKE) permissions
	$(MAKE) doctrine
	$(MAKE) ui

sync-files-down:
	cd /Users/pedropiedade/Documents/http/pedro/aeestarreja/aeestarreja/service/application && rsync -arv --stats --exclude='cache' root@68.183.78.54:/var/www/html/public/application/files .

sync-files-up:
	cd /Users/pedropiedade/Documents/http/pedro/aeestarreja/aeestarreja/service/application/files && rsync -arv --stats --exclude='cache' . root@164.92.227.63:/home/aeestarreja/service/application/files

ssh:
	ssh root@164.92.227.63