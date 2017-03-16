<h1>tableManager Examples</h1>

<p>
    These samples assume you have edited config.php to be
    able to connect to your database. As well, you should
    have run sample.sql against your database.  This will
    create a database called tableManagerSample with a table
    called people and some sample rows.
</p>

<h2>Basics</h2>

<p>
    Using as few lines of code, render the output of your table.
</p>
<ul>
    <li><a href="list_rows.php">List Rows</a> - Simplest way to list the first 50 rows in a table.</li>
    <li><a href="list_rows_with_links.php">List Rows w/ Edit Links</a> - List all rows, remove the leading
        "id" column</li>
    <li><a href="edit.php">Add Row</a> - Using field types, automatically generate the edit form.</li>
    <li><a href="edit.php?id=1">Edit Row</a> - Using field types, automatically generate the edit form
        pre-polated with ID #1's data.</li>
</ul>

<h2>Helpers JS</h2>

<p>
    These show how stupidsort and formvalidation.io can make your UI easy to use
</p>

<ul>
    <li><a href="list_rows_with_links_sortable.php">List rows, Edit links, Styles and Sortable</a>
    <li><a href="editf.php?id=1">Edit Row</a> - With formvalidation.io</li>
</ul>


<h2>Looking great</h2>

<P>
    Add Bootstrap to make your forms shine.
</P>

<ul>
    <li><a href="list_rows_with_links_sortable.php">List rows, Edit links, Styles and Sortable</a>
    <li><a href="edit.php?id=1">Edit Row</a> - With formvalidation.io</li>
</ul>
