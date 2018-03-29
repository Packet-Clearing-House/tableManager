<?php
/**
 * Class tableManager
 *
 * @author mrjones@pch.net
 * @version 1.3
 * @copyright PCH, MIT License
 * @see https://github.com/Packet-Clearing-House/tableManager/
 */

/**
 * Class tableManager
 *
 * A Class to handle basic CRUD via a PHP powered GUI for tables **who have a single, primary key**.
 * Goes to great lengths to ensure you will not be subject to SQL injection.
 * Many methods in this class might throw an error from a PDO call, so be sure o wrap
 * all calls in try/catch.
 *
 * Required:
 *      - PHP 5.1 or greater for PDO support http://php.net/manual/en/pdo.installation.php
 *      - jQuery http://jquery.com/
 *
 * Optional:
 *      - stupidtable.js https://joequery.github.io/Stupid-Table-Plugin/
 *      - formvalidation.io http://formvalidation.io
 *      - bootsrap http://getbootstrap.com/
 */
class tableManager {

    /** @var PDO object   */
    var $db;
    /** @var string username for database connection */
    var $username;
    /** @var string mysql server address for database connection */
    var $host;
    /** @var string password for database connection */
    var $password;
    /** @var string database for database connection */
    var $database;
    /** @var string defaults to 'mysql', db type for database connection */
    var $type;
    /** @var int defaults to 3306, por for database connection */
    var $port;
    /** @var string defaults to 'mysql' db type for database connection */
    var $schema;
    /** @var string table to use, bust existing in db */
    var $table;
    /** @var string key to ID the nonce in cookies and posts */
    var $nonceKey;

    /**
     * tableManager constructor - establishes a connection to a database and a specific table
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param string $table
     * @param string $type defaults to 'mysql'.  Other servers untested
     * @param int string $port defaults to '3306'
     * @throws Exception if table name doesn't exist in database
     */
    function __construct($host, $username, $password = '', $database, $table, $type = 'mysql', $port = '3306')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->type = $type;
        $this->port = $port;
        $this->username = $username;
        $this->db = $this->getDbHandle($this->database);
        $this->mysqlDb = $this->getDbHandle('information_schema');
        // use something that hopefully won't ever exist as a field name in a db ;)
        $this->tm_key = 'tableManager_key_473';
        $this->nonceKey = 'tableManager_nonce_261';
        if ($this->validateTableName($table)){
            $this->table = $table;
            $this->schema = $this->getTableSchema();
        } else {
            $error = 'Invalid Table name passed to tableManager()! "'. $table ." was passed";
            error_log($error);
            throw new Exception($error);
        }
    }

    /**
     * Retrieves a associative multi-dimensional array.  Good for passing into $this->getHtmlFromRows()
     * @param string $table defaults to table the class was instantiated with
     * @param string $orderBy defaults to NULL (no sort). field to do initial sort by.
     * @param int $start defaults to 0. row to start from
     * @param int $offset defaults to 50, how many rows from $start to select
     * @param array $rowsToFetchArray huh - i guess this is columns or fields to fetch  - only fetch these
     * @return array of results - will be an empty array if invalid params passed
     */
    public function getRowsFromTable($table = null, $orderBy = null, $start = 0, $offset = 50,
                 $rowsToFetchArray = array(), $filterKey = null, $filterValue = null){
        if ($table == null){
            $table = $this->table;
        }
        $offset = (int)$offset;
        $start = (int)$start;
        if (!$this->validateTableName($table) || !is_int($start) ||
            !is_int($offset)){
            return array();
        } else {
            if (is_array($rowsToFetchArray) && sizeof($rowsToFetchArray) > 0 &&
                $this->validateTableColumns($rowsToFetchArray)){
                $rowsToFetch = implode(", ", $rowsToFetchArray);
            } else {
                $rowsToFetch = '*';
            }
            if ($filterKey != null && $filterValue != null && $this->validateTableColumns(array($filterKey))){
                $whereSql = ' WHERE ' . $filterKey . ' = :filterValue ';
                $bindWhere = true;
            } else {
                $whereSql = '';
                $bindWhere = false;
            }
            if ($orderBy != null && $this->validateTableColumns(array($orderBy))){
                $orderBySql = " ORDER BY $orderBy ASC";
            } else {
                $orderBySql = " ";
            }
            $queryString = "SELECT $rowsToFetch FROM $table $whereSql $orderBySql  LIMIT :start, :offset";
            $query = $this->db->prepare($queryString);
            $query->bindValue(':start', $start, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            if ($bindWhere){
               $query->bindValue(':filterValue', $filterValue, PDO::PARAM_STR);
            }
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * return a single row from a database.  usefull to pass into $this->getAddEditHtml();
     * @param string $id key of row to fetch
     * @param string $tableKey defaults to primary key of table via getKeyFromTable()
     * @return array of results or empty array if invalid params passed
     */
    public function getRowFromTable($id, $tableKey = null){
        if (!$tableKey){
            $tableKey = $this->getKeyFromTable();
        }
        if ($this->validateTableColumns(array($tableKey))) {
            $queryString = "SELECT * FROM " . $this->table . " WHERE $tableKey = :id";
            $query = $this->db->prepare($queryString);
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    /**
     * Delete a row from a database
     * @param $values multi-dimensional array, must have primary key set
     * @param bool $tableKey defaults to primary key of table via getKeyFromTable()
     * @return bool success or failure if invalid params passed
     */
    public function delete($values, $tableKey = false){
        if (!isset($values[$this->tm_key]) || !$this->validNonce()){
            return false;
        } else {
            if (!$tableKey){
                $tableKey = $this->getKeyFromTable();
            }
            $idValue = $values[$this->tm_key];
            $queryString = "DELETE FROM " . $this->table . " WHERE $tableKey = :id LIMIT 1";
            $query = $this->db->prepare($queryString);
            $query->bindValue(':id', $idValue, PDO::PARAM_STR);
            $query->execute();
            return true;
        }
    }

    /**
     * Update row in database
     * @param $values multi-dimensional array, must have primary key set
     * @param bool $tableKey defaults to primary key of table via getKeyFromTable()
     * @return bool
     */
    public function update($values, $tableKey = false){
        if (!isset($values[$this->tm_key])|| !$this->validNonce()){
            return false;
        } else {
            if (!$tableKey){
                $tableKey = $this->getKeyFromTable();
            }
            $idValue = $values[$this->tm_key];
            $values = $this->cleanseValuesAgainstSchema($values);
            $queryString = "UPDATE " . $this->table . " SET ";
            $count = 1;
            foreach (array_keys($values) as $key2){
                $queryString .= "$key2 = :$key2";
                if ($count != sizeof($values)){
                    $queryString .= ", ";
                }
                $count++;
            }
            $queryString .= " WHERE $tableKey = :id LIMIT 1";
            $query = $this->db->prepare($queryString);
            foreach (array_keys($values) as $key2){
                $query->bindValue(":$key2", $values[$key2], PDO::PARAM_STR);
            }
            $query->bindValue(':id', $idValue, PDO::PARAM_STR);
            $query->execute();
            return true;
        }
    }

    /**
     * Insert new row
     * @param $values multi-dimensional array
     * @return bool success or failure if invalid params passed
     */
    public function create($values){
        if ($this->validNonce()){
            $values = $this->cleanseValuesAgainstSchema($values);
            $queryString = "INSERT INTO " . $this->table . " (`";
            $queryString .= implode("`,`", array_keys($values));
            $queryString .= "`) VALUES (:";
            $queryString .= implode(", :", array_keys($values));
            $queryString .= ");";

            $query = $this->db->prepare($queryString);
            foreach (array_keys($values) as $key) {
                $query->bindValue(":$key", $values[$key], PDO::PARAM_STR);
            }
            $query->execute();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate an HTML table
     * @param array $rows associative array of rows returned from getRowsFromTable()
     * @param boolean|string $link - defaults to false, link to be used to edit row.  if false, no link rendered
     * @param array $rowsToShow - associative array of FETCH_ASSOC -> Human name to limit and order columns.
     * if not passed, values from first row will be extracted for FETCH_ASSOC -> FETCH_ASSOC
     * column headers.
     * @param string $tableKey defaults to 'id', this is the primary key of table. will be used
     * to craft edit links on first column
     * @return string of cooked up HTML of table
     */
    public function getHtmlFromRows($rows, $link = false, $rowsToShow = array(),  $tableKey = null){

        if (!$tableKey){
            $tableKey = $this->getKeyFromTable();
        }
        // if rowsToShow is present, use that, or else use native values from FETCH_ASSOC
        // in $rows[0].
        $_rowHeaders = array();
        if (is_array($rowsToShow) && sizeof($rowsToShow) > 0) {
            $_rowHeaders = $rowsToShow;
        } else {
            if (is_array($rows) && isset($rows[0])) {
                $_rowHeadersTemp = array_keys($rows[0]);
                foreach ($_rowHeadersTemp as $_header) {
                    $_rowHeaders[$_header] = $this->getNiceFieldName($_header);
                }
            } else {
                $rows[]['empty'] = 'Table is either empty or invalid table name passed.';
                $_rowHeaders['empty'] = 'No Data Found';
            }
        }

        // build up full table HTML to return
        return "\n<table class='table table-striped table-bordered stupid-sort'>\n"
            . "<thead>\n<tr>\n"
            . $this->getHtmlRowsHead($_rowHeaders)
            . "</tr>\n</thead>\n<tbody>\n"
            . $this->getHtmlRowsBody($rows, $_rowHeaders, $tableKey, $link)
            . "</tbody>\n</table>\n";
    }

    /**
     * generate table body to list rows
     * @param array $rows associative array of rows returned from getRowsFromTable()
     * @param array $rowHeaders associative array of FETCH_ASSOC -> Human name to limit and order columns.
     * @param string $tableKey defaults to 'id', this is the primary key of table. will be used
     * to craft edit links on first column
     * @param bool $link - defaults to false, link to be used to edit row.  if false, no link rendered
     * @return string of cooked up HTML of table body.  Does *not* include outer tbody tags
     */
    public function getHtmlRowsBody($rows = array(), $rowHeaders = array(), $tableKey = 'id',  $link = false){
        $html = '';
        // loop over passed in $rows to build out array
        foreach ($rows as $row){
            $html .= "<tr class='line'>\n";
            $column = 0;

            foreach ($rowHeaders as $key => $value){

                // get column value, checking for first column to add link
                if ($link && $column === 0 && isset($row[$tableKey])){
                    // make sure we have something to link to
                    if (empty($row[$key])){
                        $linkColumnValue = '<em>Empty</em>';
                    } else {
                        $linkColumnValue = $this->cleanse($row[$key]);
                    }
                    $columnValue = "<a href='{$link}{$row[$tableKey]}'>$linkColumnValue</a>";
                } elseif (!empty($row[$key])) {
                    $columnValue =  $this->cleanse($row[$key]);
                } else {
                    $columnValue =  '<em>Empty</em>';
                }
                $html .= "\t<td>$columnValue</td>\n";
                $column++;
            }

            $html .= "</tr>\n";
        }
        return $html;
    }

    /**
     * generate table head html
     * @param array $rowsToShow associative array of FETCH_ASSOC -> Human name to limit and order columns.
     * @return string of cooked up HTML of table head.  Does *not* include outer thead tags
     */
    public function getHtmlRowsHead($rowsToShow = array()){
        $html = '';
        foreach ($rowsToShow as $key => $value){
            $html .= "\t<th id='column_" . $this->cleanse($key) . "' " .
                " data-sort='string'>" .
                $this->cleanse($value) .
                "</th>\n";
        }

        return $html;
    }

    /**
     * Get the HTML to render an add or edit form
     *
     * NOTE: This function sets a cookie to fight CSRF (https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF))
     *
     * @param array $rowData multi-dimensional array from $this->getRowFromTable() to prepoluate
     *      form when editing an existing row
     * @param string $action defaults to 'edit', can be 'add' or 'delete'
     * @param null $actionUrl where to post the form to
     * @param bool $tableKey defaults to primary key of table via getKeyFromTable()
     * @param array $rowsLabels array of column name => display name
     * @param array $customEditArray multi-dimensional array with:
     *      $customEditArray['hide'][COLUMN_NAME] = true // don't output column
     *      $customEditArray['kvPair'][COLUMN_NAME] = string // output html into <input $kvPair />.  good for formvalidation.io
     *      $customEditArray['lookup'][COLUMN_NAME] = associative array // force input to be an enum with these values
     * @param string $keyExistsUrl AJAX endpoint which will return array(true) or array(false) via $this->valueExists()
     * @param array $customOrder multi-dimensional array based off $this->schema()
     * @return string HTML of edit form
     */
    public function getAddEditHtml($rowData = array(),  $action = 'edit' , $actionUrl = null,
                                   $tableKey = false, $rowsLabels = array(), $customEditArray = array(), $keyExistsUrl = null,
                                   $customOrder = array(), $secureCookie = true)
    {
        if (!$tableKey){
            $tableKey = $this->getKeyFromTable();
        }
        if(sizeof($customOrder) == 0){
            $customOrder = $this->schema;
        }

        // get a nonce, write it to a cookie and then create a hidden input
        // which we'll check on add, edit or delete
        $nonce = $this->getRandomId();
        $this->writeNonceCookie($nonce, $secureCookie);

        $formAction = '<form role="form" method="post" action="' . $actionUrl . '" name="tableManagerAddEdit"
            class="tableManager"
            data-valid="true"
            data-fv-framework="bootstrap"
            data-fv-icon-valid="glyphicon glyphicon-ok"
            data-fv-icon-invalid="glyphicon glyphicon-remove"
            data-fv-icon-validating="glyphicon glyphicon-refresh">' ."\n";

        $html = $formAction;
        $html .= '<input type="hidden" value="' . $action . '" id="'. $this->tm_key . '_action" name="'. $this->tm_key . '_action"/>'."\n";
        $html .= $this->getNonceFormInput($nonce);
        foreach ($customOrder as $columnInfoArray){
            $colName = $columnInfoArray['COLUMN_NAME'];
            $colType = $columnInfoArray['DATA_TYPE'];

            if(isset($customEditArray['hide'][$colName])){
                continue;
            }
            if($colType == 'break'){
                $html .= '<div class="form-group break break_' . $colName . '">';
                $html .= $colName;
                $html .= '</div>';
                continue;
            }
            if ($tableKey == $colName){
                if (isset($rowData[$tableKey])){
                    $hiddenOldKey = $rowData[$tableKey];
                } else {
                    $hiddenOldKey = '';
                }
                $html .= "\n<input id='{$this->tm_key}' name='{$this->tm_key}' value='$hiddenOldKey' type='hidden' />\n";
                if ( $columnInfoArray['EXTRA'] == 'auto_increment') {
                    continue;
                }
            } elseif($tableKey == $colName && $columnInfoArray['EXTRA'] == 'auto_increment'){
                continue;
            }
            if (isset($rowData[$colName])){
                $value = $this->cleanse($rowData[$colName]);
            } else {
                $value = '';
            }
            if (isset($rowsLabels[$colName])){
                $cookedKey = $rowsLabels[$colName];
            } else {
                $cookedKey = $this->getNiceFieldName($colName);
            }
            if($columnInfoArray['IS_NULLABLE'] == 'NO'){
                $requiredHtml = ' data-fv-notempty="true" data-fv-notempty-message="This field is required" ';
            } else {
                $requiredHtml = '';
            }
            if ($columnInfoArray['COLUMN_KEY'] == "PRI"){
                $primaryClass = " primaryKey ";
            } else {
                $primaryClass = "  ";
            }
            if (isset($customEditArray['kvPair'][$colName])){
                $kvPairHtml = $customEditArray['kvPair'][$colName];
            } else {
                $kvPairHtml = "  ";
            }
            $html .= '<div class="form-group">';
            $html .= "<label for='$colName'>$cookedKey</label>\n";

            if(isset($customEditArray['lookup'][$colName])){
                $colType = 'enum';
                $columnInfoArray['SIMPLE_VALUES'] = $customEditArray['lookup'][$colName];
            }


            if ($colType == 'varchar') {
                $html .= "<input name='$colName' value='$value' id='$colName' type='text'  class='form-control $primaryClass'
                    maxlength='{$columnInfoArray['SIMPLE_SIZE']}' $requiredHtml $kvPairHtml/>\n";
            } elseif ($colType == 'text') {
                $html .= "<textarea name='$colName' id='$colName' class='form-control $primaryClass' maxlength='{$columnInfoArray['SIMPLE_SIZE']}' 
                    $requiredHtml $kvPairHtml/>$value</textarea>\n";
            } elseif ($colType == 'char') {
                $html .= "<input name='$colName' value='$value' id='$colName' type='text'  
                    class='form-control $primaryClass' maxlength='{$columnInfoArray['SIMPLE_SIZE']}' $requiredHtml $kvPairHtml/>\n";
            } elseif ($colType == 'int') {
                $html .= "<input name='$colName' value='$value' id='$colName' type='number' class='form-control $primaryClass'
                    maxlength='{$columnInfoArray['SIMPLE_SIZE']}' $requiredHtml $kvPairHtml/>\n";
            } elseif ($colType == 'enum') {
                $html .= "<select name='$colName' value='$value' id='$colName' class='form-control $primaryClass' 
                    $requiredHtml $kvPairHtml>\n";
                asort($columnInfoArray['SIMPLE_VALUES']);
                $html .= "<option value='' class='empty-select'><em>Choose One</em></option>\n";
                foreach ($columnInfoArray['SIMPLE_VALUES'] as $key => $option){
                    $selected = '';
                    if ($key == $value){
                        $selected = ' selected="selected" ';
                    }
                    $html .= "<option value='$key' $selected>$option</option>\n";
                }
                $html .= "</select>\n";
            } else {
                $html .= "<input name='$colName' value='$value' id='$colName' type='text' class='form-control $primaryClass' 
                    $requiredHtml $kvPairHtml/>\n";
            }
            $html .= '</div>';
        }
        $html .= '<button type="submit" value="save" class="btn btn-primary pull-right">Save</i></button>';

        $html .= '</form>';
        if($action == 'edit' && isset($rowData[$tableKey])) {
            $html .= $formAction;
            $html .= $this->getNonceFormInput($nonce);
            $html .= '<button type="submit" id=""  value="delete" class="btn btn-danger pull-left" >Delete</i></button>'."\n";
            $html .= "\n<input id='{$this->tm_key}' name='{$this->tm_key}' value='$hiddenOldKey' type='hidden' />\n";
            $html .= '<input type="hidden" value="delete" id="'. $this->tm_key . '_action" name="'. $this->tm_key . '_action"/>'."\n";
            ;
            $html .= '</form>';
        }

        $html .= $this->getFormCheckJS($keyExistsUrl);
        return $html;
    }

    /**
     * Method to check if a row exists with a specific value.
     * @param $key
     * @param $value
     * @return bool
     */
    public function valueExists($key, $value){
        if ( !$this->validateTableColumns(array($key))){
            return false;
        } else {
            $queryString = "
            SELECT count(*) as count 
            FROM " . $this->table . "
            WHERE $key = :value;";
            $query = $this->db->prepare($queryString);
            $query->bindValue(':value', $value, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] === "0"){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Based off a input array of column names, return a cleaned array with only valid columns
     * @param $values
     * @return array
     */
    private function cleanseValuesAgainstSchema($values){
        $cleanArray = array();
        foreach ($this->schema as $column){
            $key = $column['COLUMN_NAME'];
            if (isset($values[$key])) {
                $cleanArray[$key] = $values[$key];
            }
        }

        return $cleanArray;
    }

    /**
     * Get JavaScript for add/edit form
     * @param string|null $keyExistsUrl AJAX endpoint URL to check if value exists
     * @return string
     */
    private function getFormCheckJS($keyExistsUrl){
        if ($keyExistsUrl == null){
            return '';
        } else {
            return "
            <script>
            var tm_key = '#" . $this->tm_key . "';
            var keyExistsUrl = '" . $keyExistsUrl . "';
            
            $(document).ready(function() {
                // only do formValidation() if it is a function
                if ($.isFunction($.fn.formValidation)) {
                    $('.tableManager').formValidation().on('success.form.fv', function(e) {
                        // Prevent form submission
                        e.preventDefault();
                        
                        var oldValue = $(tm_key).val().toLowerCase();
                        var key;
                        var table;
                        
                       // if they're trying to delete, prompt with are you sure?!
                        if ($(e.target).data('formValidation').getSubmitButton().val() == 'delete'){
                            if(confirm('Do you really want to delete this item?')){
                                $(e.target).data('formValidation').defaultSubmit();
                            } else {
                                return false;
                            }
                        }
                        
                        //  process save including check for primary key
                        if ( $('.primaryKey').val() != undefined){          
                            var newValue = $('.primaryKey').val().toLowerCase();
                            key =  $('.primaryKey').attr('id');
                            table = getParameterByName('table');
                            keyExistsUrl = keyExistsUrl + '&key=' + key + '&value=' + newValue; 
                            $.get(keyExistsUrl, function( found ) {
                                if (newValue != oldValue && found[0] == true){
                                    alert('ERROR\\nPrimary key \"' + newValue + '\" already exists for \"' + key + '\".' +
                                        '\\nPlease entere a different value.');
                                    return false;
                                } else  {
                                    $(e.target).data('formValidation').defaultSubmit();
                                }
                            }); 
                        } else {
                            $(e.target).data('formValidation').defaultSubmit();
                        }
                    });
                }
            });

            // thanks http://stackoverflow.com/a/901144 !
            function getParameterByName(name, url) {
                if (!url) {
                  url = window.location.href;
                }
                name = name.replace(/[\[\]]/g, \"\\$&\");
                var regex = new RegExp(\"[?&]\" + name + \"(=([^&#]*)|&|#|$)\"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, \" \"));
            }
            </script>
            ";
        }
    }

    /**
     * Find the primary key of a table - assumes only one primary key
     * @return bool on failure or string on success
     */
    private function getKeyFromTable(){
        foreach ($this->schema as $column){
            if ($column['COLUMN_KEY'] == 'PRI'){
                return $column['COLUMN_NAME'];
            }
        }
        return false;
    }

    /**
     * Do mild human friendly stuff for standard column names
     * @param $field
     * @return string
     */
    private function getNiceFieldName($field){
        return ucwords(str_replace("_", " ", $field));
    }

    /**
     * using the INFORMATION_SCHEMA.COLUMNS table, find table schema
     * @return array
     */
    private function getTableSchema()
    {
        $queryString = "
            SELECT COLUMN_NAME,IS_NULLABLE,DATA_TYPE,COLUMN_TYPE, COLUMN_KEY, EXTRA
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME=:table AND TABLE_SCHEMA = :database;";
        $query = $this->mysqlDb->prepare($queryString);
        $query->bindValue(':table', $this->table, PDO::PARAM_STR);
        $query->bindValue(':database', $this->database, PDO::PARAM_STR);
        $query->execute();
        $schemaArray = $query->fetchAll(PDO::FETCH_ASSOC);

//print '<pre>' . print_r($schemaArray,1) ."</pre>";
        foreach ($schemaArray as $key => $columnInfoArray){
            foreach ($columnInfoArray as $key2 => $value2){
                $type = $columnInfoArray['DATA_TYPE'];
                $COLUMN_TYPE = $columnInfoArray['COLUMN_TYPE'];
//print "type: $type<br />";
                if ($type == 'varchar' || $type == 'char' || $type == 'int' ) {
                    $schemaArray[$key]['SIMPLE_SIZE'] = $this->getFieldMaxFromColumnType($COLUMN_TYPE);
                }
                if ($type == 'enum' ) {
                    $schemaArray[$key]['SIMPLE_VALUES'] = $this->getEnumValuesFromColumnType($COLUMN_TYPE);
                }
                if ($type == 'text' ) {
                    $schemaArray[$key]['SIMPLE_SIZE'] = 65535;
                }
            }
        }
        $cookedArray = array();
        foreach ($schemaArray as $key => $columnInfoArray){
            unset($columnInfoArray['COLUMN_TYPE']);
            $cookedArray[$columnInfoArray['COLUMN_NAME']] = $columnInfoArray;
        }
        return $cookedArray;
    }

    /**
     * Used in $this->getTableSchema() to cook up enem values retrieved from INFORMATION_SCHEMA.COLUMNS
     * @param $COLUMN_TYPE
     * @return array
     */
    private function getEnumValuesFromColumnType($COLUMN_TYPE){
        $replaceArray = array('enum',')','(',"'");
        $values = str_replace($replaceArray,'',$COLUMN_TYPE);
        $valuesArray = array();
        foreach (explode(",", $values) as $value){
            $valuesArray[$value] = $value;
        }
        return $valuesArray;
    }

    /**
     * Used in $this->getTableSchema() to get max chars retrieved from INFORMATION_SCHEMA.COLUMNS
     * @param $COLUMN_TYPE
     * @return null int or false if max can't be found
     */
    private function getFieldMaxFromColumnType($COLUMN_TYPE){
        $replaceArray = array('(',')');
        $sizeArray = explode("%",str_replace($replaceArray,'%',$COLUMN_TYPE));
        if (isset($sizeArray[1])) {
            return $sizeArray[1];
        } else {
            return null;
        }
    }

    /**
     * Query information_schema and see if table name is valid
     * @param $table string of table to validate
     * @return bool if valid or not
     */
    private function validateTableName($table){
        $queryString = "SELECT COUNT(*) as count FROM tables WHERE table_schema = :database AND table_name = :table;";
        $query = $this->mysqlDb->prepare($queryString);
        $query->bindValue(':table', $table, PDO::PARAM_STR);
        $query->bindValue(':database', $this->database, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($result[0]['count'] === "1") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Query information_schema and validate rows for a given table
     * @param $rowsArray array of row names
     * @return bool if valid or not
     */
    private function validateTableColumns($rowsArray){
        foreach ($rowsArray as $column) {
            $queryString = "SELECT count(*) as count FROM COLUMNS WHERE 
            TABLE_SCHEMA = :database AND TABLE_NAME = :table AND COLUMN_NAME = :column";
            $query = $this->mysqlDb->prepare($queryString);
            $query->bindValue(':table', $this->table, PDO::PARAM_STR);
            $query->bindValue(':database', $this->database, PDO::PARAM_STR);
            $query->bindValue(':column', $column, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($result[0]['count'] !== "1") {
                return false;
            }
        }
        return true;
    }

    /**
     * cleanse a string for output in HTML via htmlspecialchars()
     * @param $string dirty
     * @return string clean
     */
    private function cleanse($string){
        return htmlspecialchars($string , ENT_QUOTES, 'UTF-8');
    }

    /**
     * use PDO to establish database handle
     * @param $database
     * @return PDO
     */
    private function getDbHandle($database){
        $dbh = new PDO($this->type . ':host=' . $this->host . ';dbname=' . $database .
            ';port=' . $this->port,
            $this->username, $this->password, array(
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ));
        $dbh->exec("set time_zone = '+00:00';");
        return $dbh;
    }

    /**
     * Generate a random ID - good for use in in a session cookie or a URL parameter
     * in password reset
     * @param integer $length defaults to 50 - length of random ID
     * @return string 50 chars of openssl_random_pseudo_bytes()
     */
    private function getRandomId($length = 40){
        $secure = true;
        $dataBin = openssl_random_pseudo_bytes($length, $secure);
        return bin2hex($dataBin);
    }

    /**
     * look in the passed POST and COOKIE arrays for the $this->nonceKey and make sure they match.
     * value checked is in cookie array is $_COOKIE[$this->nonceKey + $nonce] where we derive the
     * $nonce from $POST[$this->nonceKey]. a little cyclical, but allows for N instances of the
     * same form in the same browser without inadvertent invalidation. should be written
     * with writeNonceCookie()
     * @param array $post defaults to $_POST
     * @param array $cookie defaults to $_COOKIE
     * @return bool
     */
    private function validNonce($cookie = null, $post = null){
        if($cookie === null){
            $cookie = $_COOKIE;
        }
        if($post === null){
            $post = $_POST;
        }
        $result = false;
        if (isset($post[$this->nonceKey]) &&
            isset($cookie[$this->nonceKey . $post[$this->nonceKey]] ) &&
            $post[$this->nonceKey] == $cookie[$this->nonceKey . $post[$this->nonceKey]]){
            $result = true;
        }

        if ($result === false){
            error_log('WARNING tableManager received an invalid nonce. Update, Insert or Delete failed.');
        }
        return $result;
    }

    /**
     * standard way to write nonce to cookie valid for 5 minutes. we write
     * the key of the cookie as "NONCE_KEY + $nonce" so we donate invalidate
     * multiple instances of the same form in the same browser. should be checked
     * with isFromNonce()
     * @param $nonce
     * @param $secureCookie boolean defaults to true, of whether to write cookies securely (https only). Only set this
     * to false in development, *never* in production!!
     * @return boolean result of setcookie()
     */
    public function writeNonceCookie($nonce, $secureCookie = true) {
        if ($secureCookie) {
            $secure = true;
        } else {
            $secure = false;
        }

        $http_only = true;
        // omg epic thread here of SERVER_NAME vs HTTP_HOST: http://stackoverflow.com/a/2297421
        $domain = $_SERVER['SERVER_NAME'];
        return setcookie($this->nonceKey . $nonce, $nonce, time() + 300, "/", $domain, $secure, $http_only);
    }

    private function getNonceFormInput($nonce){
        $name = $this->nonceKey ;
        return "<input type='hidden' value='$nonce' name='$name' />\n";
    }
}
