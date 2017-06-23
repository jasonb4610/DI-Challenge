## Jason Bell - Dealer Inspire Code Challenge

I ended up taking a bit more time that I felt I was going to by integrating the stuff you guys passed on into a Laravel project. Lots of things turned out really well, but it certainly added a level of complexity I hadn't initially planned for. I'm including below the installation procedures and set up requirements needed for the project. Most of everything is handled by just cloning the repo and running composer but a few database commands need to be run, environment variables set, and running a few artisan commands.

I've also set up mail transport service with mailgun. I'll provided the credentials for my account below as this is the only thing I've used it for or if you have some you want to supply just add in the domain and API key in the config/services.php file. Likewise with the database credentials, I'm providing what I used but those can be overriden if you need for any reason.

Aside from the standard Laravel (5.4) components and the css/js/image assets included with the challenge, I've only integrated three extra libraries.
- [Laravel collective html library for easier form creation](https://github.com/LaravelCollective/html)
- [Guzzle library for mail transport handling](https://github.com/guzzle/guzzle)
- [Sweet Alert 2 for pretty alert messages](https://limonte.github.io/sweetalert2/)


## Application Installation

```
git clone https://github.com/jasonb4610/DI-Challenge.git [TARGET_DIRECTORY]
cd [TARGET_DIRECTORY]
composer install
php artisan key:generate
```

Once those tasks are completed, refer to the following for proper environment configuration. All that is modified here is the information for the database connection and I've removed a fair bit from the entire file in my case which you can do at your discretion.

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:****************************************
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=di_challenge
DB_USERNAME=di_challenge
DB_PASSWORD=7kV1VR6a3r5S2XsDyN3VbqwOm

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

Now run the following commands to prepare the database instance for this application, including creation of a user and the database itself. Structure will be handled by artisan commands.

```
mysql> CREATE USER 'di_challenge'@'localhost' IDENTIFIED BY '7kV1VR6a3r5S2XsDyN3VbqwOm';
mysql> CREATE DATABASE di_challenge;
mysql> GRANT ALL ON di_challenge.* TO 'di_challenge'@'localhost';
mysql> FLUSH PRIVILEGES;
```

I would probably check to make sure the user created can access the database created just in case, but all should be OK.
At this point the configuration is all done and we just need to initialize the database migrations and apply the initial structure for the database. Run the following two artisan commands.

```
php artisan migrate:install
php artisan migrate
```

Fire it all up with the built in php webserver.

```
php -S 127.0.0.1:9999 -t public
```

## Other information

[Mailgun Login Credentials](https://app.mailgun.com/sessions/new)
```
Email = jabell4610@gmail.com
Password = /;9+x(-|B .n;6|4>5?*<.n~Q
```

If there are any questions at all about any of this please don't hesistate to reach out to me. I'd be happy to answer them if something is not working or you're just curious about any particular part.

