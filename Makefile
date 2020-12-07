all:
	@awk 'BEGIN {FS = ":.*##"; printf "Usage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"}'
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'

# QA

cs: ## Check PHP files coding style
	"vendor/bin/phpcs" app --standard=build/phpcs.xml $(ARGS)

csf: ## Fix PHP files coding style
	"vendor/bin/phpcbf" app --standard=build/phpcs.xml $(ARGS)

phpstan: ## Analyse code with PHPStan
	"vendor/bin/phpstan" analyse app -c build/phpstan.src.neon $(ARGS)

# Local

loc-database-stop: ## Stop MariaDB for local development
	docker stop xnoname_mariadb || true
	docker rm xnoname_mariadb || true

loc-database: loc-database-stop ## Run MariaDB for local development
	docker run -it -d -p 3306:3306 --name xnoname_mariadb -e MYSQL_ROOT_PASSWORD=noname -e MYSQL_DATABASE=noname -e MYSQL_USER=noname -e MYSQL_PASSWORD=noname mariadb:10.3

loc-web: ## Run php webserver for local development
	PHP_CLI_SERVER_WORKERS=4 php -S 0.0.0.0:8000 -t www/$(FINBAKERS_WEBSITE) app/Boot/dev-server.php
