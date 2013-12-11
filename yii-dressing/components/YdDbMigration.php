<?php

/**
 * Class YdDbMigration
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdDbMigration extends CDbMigration
{

    /**
     * @param $sql
     * @return integer number of rows affected by the execution.
     */
    protected function q($sql)
    {
        $r = $this->dbConnection->createCommand($sql)->execute();
        if (isset(Yii::app()->cache)) {
            Yii::app()->cache->flush();
        }
        return $r;
    }

    /**
     * @param $sql
     * @param string $separator
     * @return array of numbers of rows affected by the executions.
     */
    protected function qs($sql, $separator = ';')
    {
        $rs = array();
        $qs = explode($separator, $sql);
        foreach ($qs as $q) {
            if (trim($q)) {
                $rs[] = $this->q($q);
            }
        }
        return $rs;
    }

    /**
     * @param string $file
     * @throws Exception
     * @return bool
     */
    public function import($file)
    {
        $file = Yii::app()->basePath . '/migrations/' . $file;
        $pdo = Yii::app()->db->pdoInstance;
        if (!file_exists($file)) {
            throw new Exception('File ' . $file . ' was not found');
        }
        $sqlStream = file_get_contents($file);
        $sqlStream = rtrim($sqlStream);
        $newStream = preg_replace_callback("/\((.*)\)/", create_function('$matches', 'return str_replace(";"," $$$ ",$matches[0]);'), $sqlStream);
        $sqlArray = explode(";", $newStream);
        foreach ($sqlArray as $value) {
            if (!empty($value)) {
                $sql = str_replace(" $$$ ", ";", $value) . ";";
                $pdo->exec($sql);
            }
        }
        return true;
    }

}