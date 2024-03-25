#!/bin/bash
TODAY := $(shell date +'%Y-%m-%d')

help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"


gitpush: ## git push m=any message
	clear;
	git add .; git commit -m "$(m)"; git push;

dev-debug: ## shows debug-TODAY.log
	clear;
	php shell.php dev "tail -100 storage/logs/debug-$(TODAY).log"

dev-error: ## shows laravel.log
	clear;
	php shell.php dev "tail -100 storage/logs/laravel-$(TODAY).log"

qa-debug: ## shows debug-TODAY.log
	clear;
	php shell.php dev "tail -100 storage/logs/debug-$(TODAY).log"

qa-error: ## shows laravel.log
	clear;
	php shell.php dev "tail -100 storage/logs/laravel-$(TODAY).log"

stage-debug: ## shows debug-TODAY.log
	clear;
	php shell.php stage "tail -100 storage/logs/debug-$(TODAY).log"

stage-error: ## shows laravel.log
	clear;
	php shell.php stage "tail -100 storage/logs/laravel-$(TODAY).log"