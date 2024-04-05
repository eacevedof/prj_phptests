#!/bin/bash
TODAY := $(shell date +'%Y-%m-%d')

help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"


NLINES := 1000
gitpush: ## git push m=any message
	clear;
	git add .; git commit -m "$(m)"; git push;

dev-debug: ## shows debug.log
	clear;
	php shell.php dev "tail -n $(NLINES) storage/logs/debug-$(TODAY).log"

dev-error: ## shows laravel.log
	clear;
	php shell.php dev "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

qa-debug: ## shows debug.log
	clear;
	php shell.php qa "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

qa-error: ## shows laravel.log
	clear;
	php shell.php qa "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

qa-al-debug: ## shows debug.log
	clear;
	php shell.php qa-al "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

qa-al-error: ## shows laravel.log
	clear;
	php shell.php qa-al "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

dev-al-debug: ## shows debug.log
	clear;
	php shell.php dev-al "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

dev-al-error: ## shows laravel.log
	clear;
	php shell.php dev-al "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

stage-debug: ## shows debug.log
	clear;
	php shell.php stage "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

stage-error: ## shows laravel.log
	clear;
	php shell.php stage "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

pre-mt-debug: ## shows debug.log
	clear;
	php shell.php pre-mt "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

pre-mt-error: ## shows laravel.log
	clear;
	php shell.php pre-mt "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

pre-nor-debug: ## shows debug.log
	clear;
	php shell.php pre-nor "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

pre-nor-error: ## shows laravel.log
	clear;
	php shell.php pre-nor "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

pre-fa-debug: ## shows debug.log
	clear;
	php shell.php pre-fa "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

pre-fa-error: ## shows laravel.log
	clear;
	php shell.php pre-fa "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

prod-mt-debug: ## shows debug.log
	clear;
	php shell.php prod-mt "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

prod-mt-error: ## shows laravel.log
	clear;
	php shell.php prod-mt "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

prod-nor-debug: ## shows debug.log
	clear;
	php shell.php prod-nor "tail -n $(NLINES) storage/logs/debug-$(TODAY).log" | nl

prod-nor-error: ## shows laravel.log
	clear;
	php shell.php prod-nor "tail -n $(NLINES) storage/logs/laravel-$(TODAY).log" | nl

del-redis-dev: ## del redis dev
	php redis.php del-by-tenant dev-

del-redis-qa: ## del redis qa
	php redis.php del-by-tenant qa-

del-redis-stage: ## del redis stage
	php redis.php del-by-tenant stage-

del-redis-pre: ## del redis pre
	php redis.php del-by-tenant pre-

redis-get-keys: ## del redis pre
	php redis.php get-keys

health:
	php health.php qa
	@echo
	php health.php qa-al
	@echo
	php health.php stage
	@echo
	php health.php pre-mt
	@echo
	php health.php pre-nor
	@echo
	php health.php pre-fa


