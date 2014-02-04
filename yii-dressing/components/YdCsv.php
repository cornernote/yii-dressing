<?php

/**
 * Class YdCsv
 *
 * usage:
 * $sample=array(
 *   array(
 *     'key'=>'row1 value',
 *     'key2'=>'row1 value2',
 *   ),
 *   array(
 *     'key'=>'row2 value',
 *     'key2'=>'row2 value2',
 *   ),
 * );
 * $sample = addCsvHeader($sample);
 * $csvString = getCsvData($sample);
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
     * @param $dataElement
     * @param string $delimiter
     * @param string $enclosure
     * @return mixed
     */
    static function escapeCsvElement($dataElement, $delimiter = ",", $enclosure = "\"")
    {

        $dataElement = str_replace("\"", "\"\"", $dataElement);

        return $dataElement;
    }

    /**
     * @param $dataArray
     * @param string $delimiter
     * @param string $enclosure
     * @return string
     */
    static function getCsvData($dataArray, $delimiter = ",", $enclosure = "\"")
    {
        // Write a line to a file
        // $filePointer = the file resource to write to
        // $dataArray = the data to write out
        // $delimeter = the field separator

        // Build the string
        $string = "";

        // for each array element, which represents a line in the csv file...
        foreach ($dataArray as $line) {

            // No leading delimiter
            $writeDelimiter = FALSE;

            foreach ($line as $dataElement) {
                // Replaces a double quote with two double quotes
                $dataElement = self::escapeCsvElement($dataElement, $delimiter, $enclosure);

                // Adds a delimiter before each field (except the first)
                if ($writeDelimiter)
                    $string .= $delimiter;

                // Encloses each field with $enclosure and adds it to the string
                $string .= $enclosure . $dataElement . $enclosure;

                // Delimiters are used every time except the first.
                $writeDelimiter = TRUE;
            }
            // Append new line
            $string .= "\n";

        } // end foreach($dataArray as $line)

        // Write the string to the file
        return $string;
    }

    /**
     * @param $cvsString
     * @param string $filename
     */
    static function sendCsvInHeader($cvsString, $filename = "csvreport.csv")
    {
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment; filename=$filename");

        echo $cvsString;
    }

    /**
     * @param $rows
     * @return array
     */
    static function addCsvHeader($rows)
    {
        if ($rows) {
            $FirstRow = $rows[0];
            $Fields = array();
            foreach ($FirstRow as $key => $value) {
                $Fields[$key] = $key;
            }
            $FieldsZero[0] = $Fields;
            $RowsWithCaption = array_merge($FieldsZero, $rows);
        }
        else {
            $RowsWithCaption = $rows;
        }
        return $RowsWithCaption;

    }

    /**
     * @param $keyValueArray
     * @param string $delimiter
     * @param string $enclosure
     * @param string $filename
     */
    static function outputCsvFromKeyValueArray($keyValueArray, $delimiter = ",", $enclosure = "\"", $filename = "csvreport.csv")
    {
        $csvString = self::getCsvString(self::addCsvHeader($keyValueArray), $delimiter, $enclosure);
        self::SendCSVInHeader($csvString, $filename);
    }

    //echo "<br/> result is $result <br/>";

    /**
     * @param $fileName
     * @param string $delimiter
     * @return array
     */
    static function csvToArray($fileName, $delimiter = ",")
    {
        $handle = fopen($fileName, "r");
        $rows = array();
        $header = fgetcsv($handle, null, $delimiter);
        while (($data = fgetcsv($handle, null, $delimiter)) !== FALSE) {
            $row = array();
            foreach ($header as $key => $heading) {
                $heading = trim($heading);
                $row[$heading] = (isset($data[$key])) ? YdEncoding::toUTF8($data[$key]) : '';
            }
            $rows[] = $row;
        }
        fclose($handle);
        return $rows;
    }
}