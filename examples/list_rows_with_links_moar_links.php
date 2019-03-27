<p><a href="./">Sample Home</a></p>
<p>
    Click column headers to sort by that column:
</p>
<?php

require_once ("../tableManager.php");
require_once ("./libs/helpers.php");
require_once ("./config.php");

$rowsToShow = array(
    'first' => 'First Name',
    'last' => 'Last Name',
    'sex' => 'Gender',
    'age' => 'Age',
);

try {
    $tm = new tableManager(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_TABLE);
    $tm->setFieldLink('https://how_awesome_is_my_age.com/ageIs/', 'age');
    print $tm->getHtmlFromRows($tm->getRowsFromTable(), './edit_validate.php?table=people&id=', $rowsToShow);
} catch (Exception $e) {
    show503($e->getMessage());
}

?>
<script src="./libs/jquery.js"></script>
<script src="./libs/stupidtable.js"></script>
<link rel="stylesheet" href="./libs/simple.css">
<script>$("table").stupidtable();</script>

<hr/>

<P>
    PHP Code is:

<!-- HTML generated using hilite.me --><div style=""><pre style="margin: 0; line-height: 125%">&lt;p&gt;
Click column headers to sort by that column:
&lt;/p&gt;
<span style="color: #557799">&lt;?php</span>

<span style="color: #008800; font-weight: bold">require_once</span> (<span style="background-color: #fff0f0">&quot;../tableManager.php&quot;</span>);
<span style="color: #008800; font-weight: bold">require_once</span> (<span style="background-color: #fff0f0">&quot;./libs/helpers.php&quot;</span>);
<span style="color: #008800; font-weight: bold">require_once</span> (<span style="background-color: #fff0f0">&quot;./config.php&quot;</span>);

<span style="color: #996633">$rowsToShow</span> <span style="color: #333333">=</span> <span style="color: #008800; font-weight: bold">array</span>(
    <span style="background-color: #fff0f0">&#39;first&#39;</span> <span style="color: #333333">=&gt;</span> <span style="background-color: #fff0f0">&#39;First Name&#39;</span>,
    <span style="background-color: #fff0f0">&#39;last&#39;</span> <span style="color: #333333">=&gt;</span> <span style="background-color: #fff0f0">&#39;Last Name&#39;</span>,
    <span style="background-color: #fff0f0">&#39;sex&#39;</span> <span style="color: #333333">=&gt;</span> <span style="background-color: #fff0f0">&#39;Gender&#39;</span>,
    <span style="background-color: #fff0f0">&#39;age&#39;</span> <span style="color: #333333">=&gt;</span> <span style="background-color: #fff0f0">&#39;Age&#39;</span>,
);

<span style="color: #008800; font-weight: bold">try</span> {
    <span style="color: #996633">$tm</span> <span style="color: #333333">=</span> <span style="color: #008800; font-weight: bold">new</span> tableManager(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_TABLE);
    <span style="color: #996633">$tm</span><span style="color: #333333">-&gt;</span><span style="color: #0000CC">setFieldLink</span>(<span style="background-color: #fff0f0">&#39;https://how_awesome_is_my_age.com/ageIs/&#39;</span>, <span style="background-color: #fff0f0">&#39;age&#39;</span>);
    <span style="color: #008800; font-weight: bold">print</span> <span style="color: #996633">$tm</span><span style="color: #333333">-&gt;</span><span style="color: #0000CC">getHtmlFromRows</span>(<span style="color: #996633">$tm</span><span style="color: #333333">-&gt;</span><span style="color: #0000CC">getRowsFromTable</span>(), <span style="background-color: #fff0f0">&#39;./edit_validate.php?table=people&amp;id=&#39;</span>, <span style="color: #996633">$rowsToShow</span>);
} <span style="color: #008800; font-weight: bold">catch</span> (Exception <span style="color: #996633">$e</span>) {
    show503(<span style="color: #996633">$e</span><span style="color: #333333">-&gt;</span><span style="color: #0000CC">getMessage</span>());
}
</pre></div>
