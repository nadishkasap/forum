# Codeignitor res api forum endpoints

## Project setup
composer install

## .env file changes with database configuration 
JWT_SECRET_KEY=7EF157EA6E994E954B6381E165B41A2CBC8E1084C6CF96E2A1A35A9D46CA090B 
JWT_TIME_TO_LIVE=3600

database.default.hostname <br>
database.default.database <br>
database.default.username <br>
database.default.password <br>

## run database migrations in codeignitor 4
 php spark migrate
