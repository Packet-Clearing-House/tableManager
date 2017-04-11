<p><a href="./">Sample Home</a></p>
<script src="./libs/jquery.js"></script>
<script src="./libs/formvalidation.js"></script>
<script src="./libs/formvalidation-bootstrap.js"></script>

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

    print $tm->getAddEditHtml($row, $action, "./save_validate.php?table={$tm->table}", false, array(), array(), true, array(), SECURE_NONCE_COOKIE);
} catch (Exception $e){
    show503($e->getMessage());
}

?>

<hr/>

<P>
    PHP Code is:


</p>