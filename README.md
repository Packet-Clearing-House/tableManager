# tableManager
tableManager is an easy to use PHP library to create a web GUI for handling database CRUD for MySQL.  While the canonical MySQL web GUI is [phpMyAdmin](https://www.phpmyadmin.net/), it is substantially more complicated than tableManager.  If you're looking for a framework to easily implement a way to Create, Read, Update and Delete (C.R.U.D.) rows from a MySQL database using a PHP server and a web front end, this tool is what you've always been looking for.

For version 1.0, tableManager niavely assumes that each table has a single field primary key.  As well, while it use [PDO](http://php.net/manual/en/pdo.installation.php),  it is untested on anything but MySQL.  Finally, for the best user experience, I recommend using all of the libraries in the optional section below (stupidtable, formvalidation.io and bootstrap).

## Requirements
*  PHP 5.1 or greater for [PDO support](http://php.net/manual/en/pdo.installation.php) 
* [jQuery](http://jquery.com/)

Optional:
* [stupidtable.js](https://joequery.github.io/Stupid-Table-Plugin/) 
* [formvalidation.io](http://formvalidation.io)
* [bootsrap](http://getbootstrap.com/)


## Installation 

TBD

## Examples

TBD

## Release history

* 1.0 - Mar 15th, 2017 - First post

## License 

MIT