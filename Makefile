.DEFAULT_GOAL := server

.PHONY: boot-test
boot-test: vendor
	bin/console --version

.PHONY: cs
cs: vendor
	mkdir -p .build/php-cs-fixer
	vendor/bin/php-cs-fixer fix --diff --verbose

.PHONY: doctrine
doctrine: vendor
	bin/console doctrine:schema:validate --skip-sync

.PHONY: stan
stan: vendor
	mkdir -p .build/phpstan
	vendor/bin/phpstan analyse --configuration=phpstan.neon

.PHONY: server
server: vendor
	bin/console doctrine:database:create
	bin/console doctrine:migrations:migrate --no-interaction
	bin/console server:run

.PHONY: tests
tests: stan cs twig yaml doctrine unit boot-test

.PHONY: twig
twig:
	bin/console lint:twig templates

.PHONY: unit
unit: vendor
	mkdir -p .build/phpunit
	vendor/bin/phpunit

.PHONY: vendor
vendor: composer.json composer.lock
	composer validate
	composer install
	composer normalize

.PHONY: yaml
yaml: vendor
	bin/console lint:yaml templates
