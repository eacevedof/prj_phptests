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
	php shell.php dev "tail -n 500 storage/logs/debug-$(TODAY).log"

dev-error: ## shows laravel.log
	clear;
	php shell.php dev "tail -n 500 storage/logs/laravel-$(TODAY).log" | nl

qa-debug: ## shows debug-TODAY.log
	clear;
	php shell.php dev "tail -n 500 storage/logs/debug-$(TODAY).log" | nl

qa-error: ## shows laravel.log
	clear;
	php shell.php dev "tail -n 500 storage/logs/laravel-$(TODAY).log" | nl

stage-debug: ## shows debug-TODAY.log
	clear;
	php shell.php stage "tail -n 500 storage/logs/debug-$(TODAY).log" | nl

stage-error: ## shows laravel.log
	clear;
	php shell.php stage "tail -n 500 storage/logs/laravel-$(TODAY).log" | nl

prod-mt-debug: ## shows debug-TODAY.log
	clear;
	php shell.php prod-mt "tail -n 500 storage/logs/debug-$(TODAY).log" | nl

prod-mt-error: ## shows laravel.log
	clear;
	php shell.php prod-mt "tail -n 500 storage/logs/laravel-$(TODAY).log" | nl