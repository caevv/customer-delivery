test:
	./vendor/bin/behat && ./vendor/bin/phpspec run

prepare-invite:
	./bin/cli prepare-invite customers.txt
