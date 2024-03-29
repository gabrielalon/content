.PHONY: build
build: ## initialize composer and project dependencies
		composer install

.PHONY: update
update: ## initialize composer update
		composer update

.PHONY: phpunit
phpunit: db ## execute project unit tests
		./bin/phpunit $(conf)

.PHONY: style
style: ## executes php analizers
		./vendor/bin/phpstan analyse -l 6 -c phpstan.neon src tests

.PHONY: cs
cs: ## executes php cs fixer
		./vendor/bin/php-cs-fixer --no-interaction --diff -v fix

.PHONY: cs-check
cs-check: ## executes php cs fixer in dry run mode
		./vendor/bin/php-cs-fixer --no-interaction --dry-run --diff -v fix

.PHONY: test
test: ## executes phpunit tests
		./vendor/bin/phpunit --do-not-cache-result --colors=always

.PHONY: cs-style
cs-style: cs cs-check test ## executes php cs fixer, executes php cs fixer in dry run mode and executes php analizers

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
