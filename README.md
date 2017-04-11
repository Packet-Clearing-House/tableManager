# tableManager
tableManager is an easy to use PHP library to create a web GUI for handling database CRUD for MySQL. 
While the canonical MySQL web GUI is [phpMyAdmin](https://www.phpmyadmin.net/), it is substantially 
more complicated than tableManager.  If you're looking for a framework to easily implement a way to Create, 
Read, Update and Delete (C.R.U.D.) rows from a MySQL database using a PHP server and a web front end, this 
tool is what you've always been looking for.

For version 1.3, tableManager niavely assumes that each table has a single field primary key.  As well, 
while it use [PDO](http://php.net/manual/en/pdo.installation.php),  it is untested on anything but MySQL. 
Finally, for the best user experience, I recommend using all of the libraries in the optional section below 
(stupidtable, formvalidation.io and bootstrap).


### Security

tableManager uses extensive protection to ensure there's no MySQL injection vectors through this library. It protects against cross site request forgery. All cookies are written to be SSL only and are http only. Finally, all output us cleansed to ensure there's no cross site scripting vectors.

To cite OWASP, tableManager does the following:

* [Sanitize database output](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet#RULE_.236_-_Sanitize_HTML_Markup_with_a_Library_Designed_for_the_Job)
* [Query Parameterization](https://www.owasp.org/index.php/Query_Parameterization_Cheat_Sheet)
* [Secure Cookies](https://www.owasp.org/index.php/SecureFlag)
* [HTTP Only Cookies](https://www.owasp.org/index.php/HttpOnly)
* [Anti-CSRF Nonces](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)_Prevention_Cheat_Sheet)

## Requirements
*  MySQL 5.02 or greater for [INFORMATION_SCHEMA](https://dev.mysql.com/doc/refman/5.7/en/information-schema.html)  support
*  PHP 5.1 or greater for [PDO](http://php.net/manual/en/pdo.installation.php) support

Optional:
* [stupidtable.js](https://joequery.github.io/Stupid-Table-Plugin/) 
* [formvalidation.io](http://formvalidation.io)
* [bootsrap](http://getbootstrap.com/)

## Examples

The example images shown here are taken from the ``examples`` directory which has a functional PHP app using the ``tableManager`` class:

### List Rows

Customizable, sortable table with click to edit links for each row:

![](./examples/rows.png)

### Edit Form

Dynamic edit form based on table schema including error handling:

![](./examples/edit.png)

## Installation 

While you're welcome to use code from the examples area, the tl;dr 
is to [download the latest release](https://github.com/Packet-Clearing-House/tableManager/releases/latest) and 
extract the ``tableManager.php`` file.  See "Methods" below for how to use.

Please note that all ``tableManager`` calls may throw an error, including the constructor.  Be sure to 
wrap all your calls in a ``try{}catch(Exception $e){}``

## Methods

This is the most simple calls to the methods.  See the [examples](https://github.com/Packet-Clearing-House/tableManager/tree/add-examples/examples) section and [phpdocs](https://github.com/Packet-Clearing-House/tableManager/tree/add-examples/phpdoc) for details on all calls.

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

Note - The ``getAddEditHtml()`` sets a cookie. Please be aware of this if you're not expecting it!

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

## Development

Pull requests are always welcome! 

Please ensure your code has no warnings in the error log.  Also, do as I do, which is: 

1. ``cd``ing into the ``examples`` directory 
1. running a web server via ``php -S  localhost:8000``
1. cut a new branch for my changes
1. edit ``tableManager.php`` and ensure there's a working example which tests my change
1. update readme.md if needed
1. opening a pull request for my change
1. code review/QA pull request
1. merge to master



## Release history

* 1.3 - Apr 11th, 2017 - Update security docs per [#5](https://github.com/Packet-Clearing-House/tableManager/issues/5), add way to do development with non-ssl per [#6](https://github.com/Packet-Clearing-House/tableManager/issues/6), add sort to enum/drop downs per [#7](https://github.com/Packet-Clearing-House/tableManager/issues/7)
* 1.2 - Mar 18th, 2017 - Add protection against [CSRF](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF))
* 1.1 - Mar 16th, 2017 - Add Examples & phpDocs, fixed minor bug in edit form CSS
* 1.0 - Mar 15th, 2017 - First post

## License 

MIT