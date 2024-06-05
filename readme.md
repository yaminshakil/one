# About OneSevenOne

A NIST 800-171 assessment tool by Redport Information Systems


Flash Messaging:
https://github.com/Infinety/alerts

Pretty Icons
https://linearicons.com/free

Excel Generation
http://phpspreadsheet.readthedocs.io/

## TODO

Email Verification: ?
https://github.com/jrean/laravel-user-verification


## Dev Setup on Windows

1. Install WSL and Ubuntu 20
1. Install PHP CLI `sudo apt install php7.4-cli`
1. And some extensions that Laravel needs: `sudo apt install php7.4-xml php7.4-curl php7.4-mbstring php7.4-gd php7.4-zip php7.4-sqlite3`
1. And some tings we need: `sudo apt install php7.4-json`
1. Install Composer https://getcomposer.org/download/
1. Install NVM https://github.com/nvm-sh/nvm
1. Install Node `nvm install node`
1. Run composer `composer update`
1. Update your `.env` file to use a local SQLite database
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=/FULL_PATH_TO/database/database.sqlite`
1. Create the database `touch ./database/database.sqlite`
1. Install the database `php artisan migrate:install && php artisan migrate && php artisan db:seed`
1. Spool up the server: `php -S localhost:3000 -t public`
1. Navigate to http://localhost:3000/

    