<?php

/**
 * Class YdPhpMyAdminUrl
 *
 * @package dressing.components
 */
class YdPhpMyAdminUrl extends CApplicationComponent
{

    /**
     * @var string
     */
    public $url = 'http://localhost/phpmyadmin/';

    /**
     * @static
     * @param CActiveRecord $activeRecord
     * @return string
     */
    public function phpMyAdminUrl($activeRecord)
    {
//        $tableName = $activeRecord->tableName();
//        if (!$whereClause) {
//            $whereClause = '`' . $tableName . '`.`' . $activeRecord->tableSchema->primaryKey . '`=' . $activeRecord->primaryKey;
//        }
//        $dbName = $activeRecord->dbConnection->connectionString
// http://localhost/phpmyadmin/tbl_change.php?db=factory_oc&table=order&where_clause=%60order%60.%60order_id%60+%3D+8975844&clause_is_unique=1&sql_query=SELECT+%2A++FROM+%60order%60+WHERE+%60order_id%60+%3D+8975844&goto=sql.php&default_action=update&token=d59d0fdb6b45307adaccc131a2b56761
        return $this->url . 'tbl_select.php?db=test&table=' . $tableName . '&where_clause=' . urlencode($whereClause) . '&clause_is_unique=1';
    }

}