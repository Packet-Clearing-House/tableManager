# tableManager
tableManager is an easy to use PHP library to create a web GUI for handling database CRUD for MySQL. 
While the canonical MySQL web GUI is [phpMyAdmin](https://www.phpmyadmin.net/), it is substantially 
more complicated than tableManager.  If you're looking for a framework to easily implement a way to Create, 
Read, Update and Delete (C.R.U.D.) rows from a MySQL database using a PHP server and a web front end, this 
tool is what you've always been looking for.

For version 1.0, tableManager niavely assumes that each table has a single field primary key.  As well, 
while it use [PDO](http://php.net/manual/en/pdo.installation.php),  it is untested on anything but MySQL. 
Finally, for the best user experience, I recommend using all of the libraries in the optional section below 
(stupidtable, formvalidation.io and bootstrap).

tableManager uses extensive protection to ensure there's no MySQL injection vectors through this library.

## Requirements
*  MySQL 5.02 or greater for [INFORMATION_SCHEMA](https://dev.mysql.com/doc/refman/5.7/en/information-schema.html)  support
*  PHP 5.1 or greater for [PDO](http://php.net/manual/en/pdo.installation.php) support

Optional:
* [stupidtable.js](https://joequery.github.io/Stupid-Table-Plugin/) 
* [formvalidation.io](http://formvalidation.io)
* [bootsrap](http://getbootstrap.com/)


## Installation 

While you're welcome to use code from the examples area, the tl;dr 
is to [download the latest release](https://github.com/Packet-Clearing-House/tableManager/releases/latest) and 
extract the ``tableManager.php`` file.  See "Methods" below for how to use.

Please note that all ``tableManager`` calls may throw an error, including the constructor.  Be sure to 
wrap all your calls in a ``try{}catch(Exception $e){}``

## Methods

This is the most simple calls to the methods.  See the examples section and phpdocs for details on all calls.

You need to instantiate the class with valid parameters to set up a database handle. TYPE and PORT default 
to 'mysql' and 3306 respectively: 

```php
$tm = new tableManager(DB_SERVER, DB_USER, DB_PASS, DATABASE, TABLE);
```

To get all the rows from a table use the ``getRowsFromTable()`` method.  This will default to the table 
you passed into the constructor

```php
$rowsArray = $tm->getRowsFromTable();
```

To show the rows you just retrieved, call ``getHtmlFromRows()`` and pass in the rows 
from ``getRowsFromTable()`` as well as the URI where to edit a row.  The second parameter will 
depend on your implementation, but the ID of the row will be appended to a query string.  
It's handy to use the ``$tm->table`` member variable here:

```php
print $tm->getHtmlFromRows($rowsArray, "/edit?table={$tm->table}&id=");
```

To show the create form  (also the edit form) for a table us ``getAddEditHtml()``.  Pass 
in ``null``, ``add`` and the action for adding a row:

```php
print $tm->getAddEditHtml(null, 'add', "/save?table={$this->table}");
```

Or, use ``getRowFromTable()`` to prefetch a row when you're editing a row.  This will pre-
populate the form with the data from ``$row``:

```php
$row = $tm->getRowFromTable($_GET['id']);
print $tm->getAddEditHtml($row, 'edit', "/save?table={$this->table}");
```

To delete, update or add a row, use the following methods which assume you're posting using 
the form from ``getAddEditHtml()`` which passes the ``tm_key_action`` member variable value with any submitted form:

```php
$action = $tm->tm_key . '_action';
if ($_POST[$action] == 'delete') {
    $tm->delete($_POST);
} elseif ($_POST[$action] == 'edit') {
    $tm->update($_POST);
} elseif ($_POST[$action] == 'add') {
    $tm->create($_POST);
}
```

## Examples

TBD

## Release history

* 1.0 - Mar 15th, 2017 - First post

## License 

MIT