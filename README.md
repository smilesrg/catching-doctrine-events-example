# Example of listening and catching database interaction using Doctrine

To set up this project:

Clone it and run `composer install` 

By default, it uses SQLite for database connection, the database itself should be located in `/var/data.db`. If you use SQLite, you don't need to set up any connection, but if you want to change database, just edit .env file and replace the DATABASE_URL parameter accordingly.

The directories must be writable by a terminal user, if something goes wrong, [please fix it according to the manual](https://symfony.com/doc/current/setup/file_permissions.html)

Run `bin/console doctrine:migrations:migrate --no-interaction`

Then, run `bin/console inspector:catch-doctrine-events` which should output interaction with database using Doctrine ORM
