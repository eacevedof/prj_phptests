help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

remlogs: ## remove logs
	rm -fr ./logs/custom/*.log
	rm -fr ./logs/debug/*.log
	rm -fr ./logs/emails/*.log
	rm -fr ./logs/errors/*.log
	rm -fr ./logs/queries/*.log
	rm -fr ./logs/queries/delete/*.log
	rm -fr ./logs/queries/insert/*.log
	rm -fr ./logs/queries/select/*.log
	rm -fr ./logs/queries/update/*.log
	rm -fr ./logs/session/*.log
	rm -fr ./logs/shellscripts/*.log

gitpush: ## git push m=any message
	clear;
	git add .; git commit -m "$(m)"; git push;

server: ## localhost:1024
	php -S localhost:1024 -t ./public

CURRENT_BRANCH := $(shell git rev-parse --abbrev-ref HEAD)
update-branch:  ## update main branches
	git fetch --all;

	git checkout master; git reset --hard origin/master;
	git checkout dev; git reset --hard origin/dev;
	git checkout dev-eduardo; git reset --hard origin/dev-eduardo;

	git checkout $(CURRENT_BRANCH);