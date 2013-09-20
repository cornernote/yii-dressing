<?php

require_once(bp() . '/../../vendors/phpExcelReader/Excel/oleread.php');
require_once(bp() . '/../../vendors/phpExcelReader/Excel/reader.php');

/**
 *
 */
class YdExcelReader
{
    /**
     * @param $filename
     * @return Spreadsheet_Excel_Reader
     */
    public static function read($filename)
    {
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($filename);
        return $data->sheets;
    }
}