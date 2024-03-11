docker-up:
	./vendor/bin/sail up -d

docker-down:
	./vendor/bin/sail down

docker-test:
	./vendor/bin/sail composer test

docker-coverage-html:
	./vendor/bin/sail composer test-coverage-html

docker-seed:
	./vendor/bin/sail artisan db:seed

docker-migrate:
	./vendor/bin/sail artisan migrate
