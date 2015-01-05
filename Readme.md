# Box Support Test App

# About this app

This is a test app that was written as part of the recruitment process for a PHP Developer position. As I spent quite some time doing the app, I thought that it would be a good idea to upload it to my Github account so that potential employers or partners could familiarise themselves with my style of coding by looking at the test app.

**Please note that the Readme is quite long because originally it was meant to be reviewed by the recruiters at the company which I wrote the app for, but as it contains really useful info, I decided to retain it as is.**

## Technologies and Components Used

The app is written in object-oriented PHP using the popular [Laravel Framework](http://www.laravel.com/). In addition, the app uses the following dependancies to run correctly (the versions are the ones installed on my machine, not the minimum versions that the app would potentially support):

- PHP V 5.4.0 or greater,
- MySQL V 5.20 or greater,
- A recent version of the [Composer package manager for PHP](https://getcomposer.org/)
- Twitter Bootstrap V 3
- jQuery 1.11.1
- jQuery UI is also included as an asset just in case, but is not used anywhere

**Please note that all of the PHP and Java Script libraries mentioned above are contained within the zip archive, so there should be no need for you to do anything else to run the app. There is a small script that Twitter Bootstrap uses for IE debugging purposes which is hosted on the Internet and is called from a CDN directly, so I would advise you to run the app on a machine that has Internet access, in case you are using IE 8/9, etc.**

## Installation Instructions

In order to install the app, you need to do the following:
1. Extract the zip file that contains the app into a directory on your server. From now on, I will refer to this directory as `app_path`.
2. Download and install the [Composer package manager for PHP](https://getcomposer.org/).
3. Pull the Laravel Framework and its dependencies with composer by going into the route directory of the app and executing the following:

```
PHP composer.phar install
```

4. Go into your database software and create a new database named 'boxsupport' or whatever you wish to call it (the default name I used in the config is 'boxsupport').
If you are using the default MySQL command line interface, you can do:

```
create database boxsupport;
```

5. Go and edit the following file, /pathh_to_app/app/config/database.php and find the section where it says:

```
'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'boxsupport',
			'username'  => 'root',
'password'  => 'root',
'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		)
```

and change the database name, host, username and password to match the name of the database you created and the credentials of your particular server
6. Next, you need to load the database schema into the newly created database. In order to do it, you have two options:
  6.1. Through the special Laravel migration I have created. Simply go into the main directory of the application and from a command line or shell, execute the following PHP command:
  ```
  PHP artisan migrate
  ```
  
  If artisan complains that the aplication is currently in production mode, type 'Yes' and then press enter to confirm the operation.
  If you see a successful migration message similar to this:
  
  ```
  Generating autoload files
  Generating optimized class loader
  ```
  
  You can assume that the data is being loaded, but just in case, go to your database and see whether any tables were imported. You should be able to see 6 tables in total. The original 5 tables from the data.sql file you supplied as part of the test instructions and a table called 'migrations' that is used internally by the Laravel framework to track its own migrations.
  6.2. Through an own database software. I have put the data.sql file into the following directory, from where you can take it and import it either with mysqldump, PHPMyAdmin, etc. `/app_path/app/database/seeds/data.sql`
7. As I have included all of my dependancies and components within the zip file, you should be ready to go, but if you have any issues, please contact me and I will try to help you to solve whatever happens not to be working as expected. For your convenience, I have left my .git directory within the main `app_path` directory, so if you have git installed on your system, you can do:

```
GIT status
```

If git says that the directory is tracked by git, you can then do:

```
GIT LOG
```

to check the changes I have made since starting the project. In addition, if Laravel complains that any dependancies might be missing or does not work as expected, you can go to the main app directory and run
`PHP composer.phar update`
to fetch any missing or newer dependencies.

## Running

In order to run the application, you need to visit its public directory within a browser, so assuming that you have installed it in the main route of your web server and the web server is on a local host, you would need to go to the following address to see the web interface:
```
http://localhost/public
```
If you have decided to put it into a boxsupport directory, the path would be:
```
http://localhost/boxsupport/public
```
The public directory is the only web facing directory where all requests should come from.

The only sample account that I have included by default is account with ID `123`, so if you wish to test the app with more than one account, you will have to add additional accounts, products, boxes or ratings directly into the database by yourself. The app does not have an interface for adding neither of those.

## What I have written

Here I will take a moment to explain what parts of the whole application I have written, because if you have not used Laravel before, you might not be able to distinguish what was written by me and what came as part of Laravel.

In the app_path/app directory, the subdirectories 'controllers', 'models', 'views' contain almost exclusively code written by me for this specific app. The controllers' directory contains a BaseController.php file that comes with Laravel and abstracts Laravel's underlying controller class, so all of my custom controllers call it in order to get instantiated properly.
In the models directory, I have defined all database models except the model called 'User.php' which comes with the framework by default.
The views directory contains many files, but the only ones not written by me are the 'hello.php' file and the files in the 'emails' subdirectory, which come with Laravel by default.
In addition, I have written everything in the directory called 'boxsupport', which contains my services and helpers, the files 'style.css' and 'main.js' in 'app_path/public/assets/css' and 'app_path/public/assets/js' respectively, and also, I have written a lot of custom code in the 'filters.php' and 'routes.php' files in the main directory.

## Observations, explanations and justifications

As this was a small task, I decided to follow the MVC pattern and mix in a lot of business logic within the controllers of the app. In particular, the difference between products and boxes is a bit blurred because the products did not warrant their own controller, therefore, I have included the products' functionality into some unused methods of the box controller. I am aware that in a production environment, I should stick to the 'separation of concerns' principle as much as possible and either use a lot of dependency injection to manage trivial things such as pagination, sorting and data validation, or should use the repository pattern, in which case I would have to write my own repositories to abstract out Framework’s common functionality such as database querying, sending of emails, etc., that could then be injected into the framework and could be easily replaced if such a need arise.

It was a bit difficult to define all relationships in Laravel's orm component called Eloquent as initially the company I wrote this app for, supplied their own MySQL schema that the app had to conform to, and as their custom tables did not conform to the rules Eloquent uses to figure out the different relationships, in some models, I had to create additional models to get the proper relation, or to simply format the delivery date properly, for example. Ideally, in a live environment, it should be possible to match all individual tables to their own models and manage them almost exclusively with the ORM of your choice, without needing a lot of extra methods or raw MySQL queries.

I have created different pages for the different actions within the interface, for example, I do not load all products next to the boxes once the information for the given account is retrieved. I felt that I would waste a lot of time letting Laravel to parse that with AJAX and jQuery, so I used the old-fashioned method of having a dedicated action on the boxes controller that displays all boxes for a user and a separate action that displays all products in a box with their ratings on a separate page.

The only two dependency injections I used to demonstrate that pattern is the small validation of the account ID on the main page and the session management which is implemented as a small helper that uses a few static methods to do the tasks needed to save an account ID to a session, get it from one or destroy the session with this information. The validation service is used on the home page if the user is not logged in to check that the account Id is passed in the proper format, for example if you type an invalid ID that consists of letters and digits, e.g. 1022GHY, you would get a warning about that discrepancy and the system would ask you to try again. I managed to do this by reusing a service that I already defined for another side project with Laravel, which really shows how powerful this concept is.

The most difficult part of the task was the mapping of models to controllers and controllers to routes. Since the app was so small, it was very difficult for me to figure out what to put where exactly and how to organise my code properly. For example, in other projects I usually define restful controllers that directly map to the CRUD actions for an object, but here I was not able to utilise this, because most of the controllers required only the show and index methods to be used. The product did not even need a dedicated controller by itself, as it was shown only on the individual box page, but in a live version, it would definitely need one.

## Missing features, best practises and bugs

As I said already, I know that this app is missing various vital features of an app that could go into commercial use. On the back-end side, the most important of them are proper data verification and integrity, code testing (both user acceptance, functional and browser testing) and a better code organisation in terms of following a specific pattern in addition to and within the constraints of the MVC architecture imposed by the modern PHP frameworks, such as a service-oriented, repository or test-driven development pattern.

In terms of front-end interface and user experience, the interface is missing features such as sorting of the table of boxes by delivery date, for example, but I thought that this is not really needed as it would have taken an enormous amount of time to do properly, for such a small test app. In addition, the routes of the application are not that well protected in terms of showing user-friendly errors. For example, if you make up some user account and box IDs and type something like:
http://localhost/boxsupport/account/2012abc/boxes/123
Instead of a normal 404 page not found error, or a custom error page, you would end up seeing a lot of Laravel debug messages and a default Laravel exception page. Also, if you do not specifically log out of one account and then close your browser and try to log back in again with a different account, you will be returned back to the same account you were viewing before, so you would need to always log out from the app's menu before you can log back in with another account ID.

# Conclusion

I hope I have explained why I have decided to write the app the way I did it and the limitations of my approach. I know that it is not perfect from a commercial standpoint, but I believe that it shows enough PHP / MySQL, HTML and CSS skills for you to familiarise yourself with my thinking and coding style.