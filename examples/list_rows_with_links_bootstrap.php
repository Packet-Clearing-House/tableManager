<?php

require_once ("../tableManager.php");
require_once ("./libs/helpers.php");
require_once ("./config.php");

$rowsToShow = array(
    'first' => 'First Name',
    'last' => 'Last Name',
    'sex' => 'Gender',
);

try {
    $tm = new tableManager(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_TABLE);
    $rowsHtml = $tm->getHtmlFromRows($tm->getRowsFromTable(), './edit_bootstrap.php?table=people&id=', $rowsToShow);
} catch (Exception $e) {
    show503($e->getMessage());
}

?>
<div class="container">
    <div class="col-md-6">
        <p><a href="./">Sample Home</a></p>
        <p>
            Click column headers to sort by that column or <a href="edit_bootstrap.php">add a row</a>:
        </p>

        <script src="./libs/jquery.js"></script>
        <script src="./libs/stupidtable.js"></script>
        <script src="./libs/bootstrap.js"></script>
        <link rel="stylesheet" href="./libs/bootstrap.css">
        <link rel="stylesheet" href="./libs/fancy.css">

        <?php echo $rowsHtml ?>

        <script>$("table").stupidtable();</script>
    </div>
    <div class="col-md-12">


        <hr/>

        <P>
            PHP Code is:
        <pre style='color:#000000;background:#ffffff;'><span style='color:#808030; '>&lt;</span>?php

require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"../tableManager.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"./libs/helpers.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
require_once <span style='color:#808030; '>(</span><span style='color:#0000e6; '>"./config.php"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>

$rowsToShow <span style='color:#808030; '>=</span> <span style='color:#800000; font-weight:bold; '>array</span><span style='color:#808030; '>(</span>
    <span style='color:#696969; '>'first' => 'First Name',</span>
    <span style='color:#696969; '>'last' => 'Last Name',</span>
    <span style='color:#696969; '>'sex' => 'Gender',</span>
<span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>

try {
    $tm <span style='color:#808030; '>=</span> <span style='color:#800000; font-weight:bold; '>new</span> tableManager<span style='color:#808030; '>(</span>DB_HOST<span style='color:#808030; '>,</span> DB_USER<span style='color:#808030; '>,</span> DB_PASS<span style='color:#808030; '>,</span> DB_DATABASE<span style='color:#808030; '>,</span> DB_TABLE<span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
    $rowsHtml <span style='color:#808030; '>=</span> $tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getHtmlFromRows<span style='color:#808030; '>(</span>$tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getRowsFromTable<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>,</span> <span style='color:#696969; '>'./edit_bootstrap.php?table=people&amp;id=', $rowsToShow);</span>
} catch <span style='color:#808030; '>(</span>Exception <span style='color:#008c00; '>$e</span><span style='color:#808030; '>)</span> {
    show503<span style='color:#808030; '>(</span><span style='color:#008c00; '>$e</span><span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getMessage<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
}

?<span style='color:#808030; '>></span>
<span style='color:#808030; '>&lt;</span>div <span style='color:#800000; font-weight:bold; '>class</span><span style='color:#808030; '>=</span><span style='color:#0000e6; '>"container"</span><span style='color:#808030; '>></span>
    <span style='color:#808030; '>&lt;</span>div <span style='color:#800000; font-weight:bold; '>class</span><span style='color:#808030; '>=</span><span style='color:#0000e6; '>"col-md-6"</span><span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>p<span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span>a href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./"</span><span style='color:#808030; '>></span>Sample Home<span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>a<span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>p<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>p<span style='color:#808030; '>></span>
            Click column headers <span style='color:#800000; font-weight:bold; '>to</span> sort by that column or <span style='color:#808030; '>&lt;</span>a href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"edit_bootstrap.php"</span><span style='color:#808030; '>></span>add a row<span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>a<span style='color:#808030; '>></span><span style='color:#808030; '>:</span>
        <span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>p<span style='color:#808030; '>></span>

        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/jquery.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/stupidtable.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/bootstrap.js"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>link rel<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"stylesheet"</span> href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/bootstrap.css"</span><span style='color:#808030; '>></span>
        <span style='color:#808030; '>&lt;</span>link rel<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"stylesheet"</span> href<span style='color:#808030; '>=</span><span style='color:#0000e6; '>"./libs/fancy.css"</span><span style='color:#808030; '>></span>

        <span style='color:#808030; '>&lt;</span>?php echo $rowsHtml ?<span style='color:#808030; '>></span>

        <span style='color:#808030; '>&lt;</span>script<span style='color:#808030; '>></span>$<span style='color:#808030; '>(</span><span style='color:#0000e6; '>"table"</span><span style='color:#808030; '>)</span><span style='color:#808030; '>.</span>stupidtable<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span>
    <span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>div<span style='color:#808030; '>></span>
<span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>div<span style='color:#808030; '>></span>
</pre>
        </P>
    </div>
</div>
