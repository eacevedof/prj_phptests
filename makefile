remlogs: ## remove logs
	rm -fr ./logs/custom/*
	rm -fr ./logs/debug/*

compile: ## npm run dev
	npm run dev

dumpdb: ## dumpdb
	py.sh dump eduardoaf
