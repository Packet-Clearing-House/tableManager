<?php

require_once ("../tableManager.php");
require_once ("./libs/helpers.php");
require_once ("./config.php");

try {
    $tm = new tableManager(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_TABLE);
    if (isset($_GET['id'])) {
        $row = $tm->getRowFromTable($_GET['id']);
        $action = 'edit';
    } else {
        $row = array();
        $action = 'add';
    }

    print $tm->getAddEditHtml($row, $action, "./save.php?table={$tm->table}");
} catch (Exception $e){
    show503($e->getMessage());
}

?>

<script src="./libs/jquery.js"></script>
<script src="./libs/formvalidation.js"></script>
<hr/>

<P>
    PHP Code is:


</p>