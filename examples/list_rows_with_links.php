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
    print $tm->getHtmlFromRows($tm->getRowsFromTable(), './edit.php?table=people&id=', $rowsToShow);
} catch (Exception $e) {
    show503($e->getMessage());
}

?>
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
    <span style='color:#800000; font-weight:bold; '>print</span> $tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getHtmlFromRows<span style='color:#808030; '>(</span>$tm<span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getRowsFromTable<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>,</span> <span style='color:#696969; '>'./edit.php?table=people&amp;id=', $rowsToShow);</span>
} catch <span style='color:#808030; '>(</span>Exception <span style='color:#008c00; '>$e</span><span style='color:#808030; '>)</span> {
    show503<span style='color:#808030; '>(</span><span style='color:#008c00; '>$e</span><span style='color:#808030; '>-</span><span style='color:#808030; '>></span>getMessage<span style='color:#808030; '>(</span><span style='color:#808030; '>)</span><span style='color:#808030; '>)</span><span style='color:#808030; '>;</span>
}
</pre>

</P>
