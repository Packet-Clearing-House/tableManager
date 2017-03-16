<?php

require_once ("../tableManager.php");
require_once ("./libs/helpers.php");
require_once ("./config.php");

try {
    $tm = new tableManager(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_TABLE);
    $actionKey = $tm->tm_key . '_action';

    $home = "list_rows_with_links_sortable.php";
    if (isset($_POST) && isset($_POST[$actionKey])) {
        if ($_POST[$actionKey] == 'delete') {
            $tm->delete($_POST);
        } elseif ($_POST[$actionKey] == 'edit') {
            $tm->update($_POST);
        } elseif ($_POST[$actionKey] == 'add') {
            $tm->create($_POST);
        }
    }

    header("Location: $home", true, 302);
    exit;
} catch (Exception $e){
    show503($e->getMessage());
}