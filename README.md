# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can also run this command. 

	php composer.phar start

Run this command to run the test suite

	php composer.phar test

That's it! Now go build something cool.

## Challenge

* Certs are available [here](https://bitbucket.org/etm-v/etm-php-challenge/downloads/soap_cert.zip). Pass to container: 123456zZ
* login/pass/hashkey - test1/7mkn6XC9L54p/b2cbf0f711

1. Change end-point to https://soap.etm-system.ru/.
2. Generate new certs. Manual [here](https://bitbucket.org/etm-v/etm-php-challenge/downloads/ETM%20system%20Certificate%20Request%20Form%20v0.3.pdf).
3. Run.
4. Cover code with unit tests.
5. Refactor code if needed.
6. Publish code yo public repo.