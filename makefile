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


server: ## dumpdb
	php -S localhost:1024 -t ./public
