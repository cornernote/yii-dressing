<?php
Yii::import('vendor.php-excel-reader.spreadsheet-reader.src.PHPExcelReader.SpreadsheetReader');

/**
 * @package dressing.components
 */
class YdExcelReader
{
    /**
     * @param $filename
     * @return Spreadsheet_Excel_Reader
     */
    public static function read($filename)
    {
        $data = new PHPExcelReader\SpreadsheetReader();
        $data->setOutputEncoding('CP1251');
        $data->read($filename);
        return $data->sheets;
    }
}