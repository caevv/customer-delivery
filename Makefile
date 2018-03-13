install:
	composer install

test:
	./vendor/bin/behat -p domain && ./vendor/bin/behat -p domain && ./vendor/bin/phpspec run

prepare-invite:
	./bin/cli prepare-invite customers.txt
