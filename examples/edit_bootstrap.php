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

    $formHtml = $tm->getAddEditHtml($row, $action, "./save_bootstrap.php?table={$tm->table}", false, array(), array(), true, array(),SECURE_NONCE_COOKIE);
} catch (Exception $e){
    show503($e->getMessage());
}

?>

<div class="container">
    <div class=" col-md-5 ">
        <p><a href="./">Sample Home</a></p>
        <script src="./libs/jquery.js"></script>
        <script src="./libs/bootstrap.js"></script>
        <script src="./libs/formvalidation.js"></script>
        <script src="./libs/formvalidation-bootstrap.js"></script>
        <link rel="stylesheet" href="./libs/bootstrap.css">
        <link rel="stylesheet" href="./libs/fancy.css">
        <?php echo $formHtml ?>
    </div>


    <div class="container col-md-12">
        <hr/>

        <P>
            PHP Code is:
        <pre style='color:#000000;background:#ffffff;'><span style='color:#808030; '>&lt;</span>?php

require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"../tableManager.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"./libs/helpers.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"./config.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>

try {
    $tm <span style='color:#808030; '>=</span> <span style='color:#800000; font-weight:bold; '>new</span> tableManager<span style='color:#808030; '>(</span>DB_HOST<span style='color:#808030; '>,</span> DB_USER<span style='color:#808030; '>,</span> DB_PASS<span style='color:#808030; '>,</span> DB_DATABASE<span style='color:#808030; '>,</span> DB_TABLE<span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
    <span style='color:#800000; font-weight:bold; '>if</span> <span style='color:#808030; '>(</span>isset<span style='color:#808030; '>(</span>$_GET<span style='color:#808030; '>[</span><span style='color:#696969; '>'id'])) {</span>
        $row <span style='color:#808030; '>=</span> $tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getRowFromTable<span style='color:#808030; '>(</span>$_GET<span style='color:#808030; '>[</span><span style='color:#696969; '>'id']);</span>
        $action <span style='color:#808030; '>=</span> <span style='color:#696969; '>'edit';</span>
    } <span style='color:#800000; font-weight:bold; '>else</span> {
        $row <span style='color:#808030; '>=</span> <span style='color:#800000; font-weight:bold; '>array</span><span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
        $action <span style='color:#808030; '>=</span> <span style='color:#696969; '>'add';</span>
    }

    $formHtml <span style='color:#808030; '>=</span> $tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getAddEditHtml<span style='color:#808030; '>(</span>$row<span style='color:#808030; '>,</span> $action<span style='color:#808030; '>,</span> <span style='color:#0000e6; '>"./save_bootstrap.php?table={$tm->table}"</span><span style='color:#808030; '>,</span> <span style='color:#0f4d75; '>false</span><span style='color:#808030; '>,</span> <span style='color:#800000; font-weight:bold; '>array</span><span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>,</span> <span style='color:#800000; font-weight:bold; '>array</span><span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>,</span> <span style='color:#0f4d75; '>true</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
} catch <span style='color:#808030; '>(</span>Exception <span style='color:#008c00; '>$e</span><span style='color:#808030; '>)</span>{
    show503<span style='color:#808030; '>(</span><span style='color:#008c00; '>$e</span><span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getMessage<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
}

?<span style='color:#808030; '>></span>

<span style='color:#808030; '>&lt;</span>div <span style='color:#800000; font-weight:bold; '>class</span><span style='color:#808030; '>=</span><span style='color:#0000e6; '>"container"</span><span style='color:#808030; '>></span>
    <span style='color:#808030; '>&lt;</span>div <span style='color:#800000; font-weight:bold; '>class</span><span style='color:#808030; '>=</span><span style='color:#0000e6; '>" col-md-5 "</span><span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>p<span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span>a href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./"</span><span style='color:#808030; '>></span>Sample Home<span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>a<span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>p<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/jquery.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/bootstrap.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/formvalidation.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/formvalidation-bootstrap.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>link rel<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"stylesheet"</span> href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/bootstrap.css"</span><span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>link rel<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"stylesheet"</span> href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/fancy.css"</span><span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>?php echo $formHtml ?<span style='color:#808030; '>></span>
    <span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>div<span style='color:#808030; '>></span>

<span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>div <span style='color:#808030; '>></span>
</pre>

        </p>
    </div>
</div >


