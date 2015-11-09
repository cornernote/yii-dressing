<?php

/**
 * Class YdCsv
 *
 * usage:
 * $csv = array(
 *   array(
 *     'key' => 'row1 value',
 *     'key2' => 'row1 value2',
 *   ),
 *   array(
 *     'key' => 'row2 value',
 *     'key2' => 'row2 value2',
 *   ),
 * );
 * $csvString = YdCsv::addCsvHeader($csv);
 * $csvString = YdCsv::getCsvData($csvString);
 * YdCsv::sendCsvInHeader($csvString);
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdCsv
{

    /**
     * @param $dataArray
     * @param string $delimiter
     * @param string $enclosure
     * @param string $newLine
     * @return string
     */
    static function getCsvData($dataArray, $delimiter = ',', $enclosure = '"', $newLine = "\n")
    {
        $string = '';
        foreach ($dataArray as $line) {
            $writeDelimiter = false;
            foreach ($line as $dataElement) {
                $dataElement = str_replace($enclosure, $enclosure . $enclosure, $dataElement);
                if ($writeDelimiter)
                    $string .= $delimiter;
                $string .= $enclosure . $dataElement . $enclosure;
                $writeDelimiter = true;
            }
            $string .= $newLine;
        }
        return $string;
    }

    /**
     * @param $cvsString
     * @param string $filename
     */
    static function sendCsvInHeader($cvsString, $filename = 'csvreport.csv')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $cvsString;
    }

    /**
     * @param $rows
     * @return array
     */
    static function addCsvHeader($rows)
    {
        if ($rows) {
            $firstRow = current($rows);
            $fields = array();
            foreach ($firstRow as $key => $value) {
                $fields[$key] = $key;
            }
            $fieldsZero[0] = $fields;
            $rowsWithCaption = array_merge($fieldsZero, $rows);
        } else {
            $rowsWithCaption = $rows;
        }
        return $rowsWithCaption;

    }

    /**
     * @param $keyValueArray
     * @param string $delimiter
     * @param string $enclosure
     * @param string $filename
     */
    static function outputCsvFromArray($keyValueArray, $delimiter = ',', $enclosure = '"', $filename = 'csvreport.csv')
    {
        $csvString = self::getCsvData(self::addCsvHeader($keyValueArray), $delimiter, $enclosure);
        self::sendCsvInHeader($csvString, $filename);
    }

    /**
     * @param $fileName
     * @param string $delimiter
     * @param int $headerRow
     * @return array
     */
    static function csvToArray($fileName, $delimiter = ',', $headerRow = 1)
    {
        $handle = fopen($fileName, 'r');
        $rows = array();
        while ($headerRow > 1) {
            $headerRow--;
            fgetcsv($handle, null, $delimiter);
        }
        $header = $headerRow ? fgetcsv($handle, null, $delimiter) : false;
        while (($data = fgetcsv($handle, null, $delimiter)) !== FALSE) {
            $row = array();
            if ($header) {
                foreach ($header as $key => $heading) {
                    $heading = trim($heading);
                    $row[$heading] = (isset($data[$key])) ? YdEncoding::toUTF8($data[$key]) : '';
                }
                $rows[] = $row;
            } else {
                $rows[] = $data;
            }
        }
        fclose($handle);
        return $rows;
    }

}
