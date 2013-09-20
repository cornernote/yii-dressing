<?php
class YdCsv
{
    /*
     usage:
         $sample=array(
             array(
                 'key'=>'value',
                 'key2'=>'value2',
                 ),
             array('key'=>'value2',),
         );
         $sample=PutCaptionsOnCSVArray($sample);
         $csvString=GetCVsString($sample);
         SendCSVInHeader($csvString);


     */
    static function escapeCSVElement($dataElement, $delimiter = ",", $enclosure = "\"")
    {

        $dataElement = str_replace("\"", "\"\"", $dataElement);

        return $dataElement;
    }

    static function getCVsString($dataArray, $delimiter = ",", $enclosure = "\"")
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
                $dataElement = self::escapeCSVElement($dataElement, $delimiter, $enclosure);

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

    static function sendCSVInHeader($cvsString, $filename = "csvreport.csv")
    {
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment; filename=$filename");

        echo $cvsString;
    }

    static function putCaptionsOnCSVArray($rows)
    {
        if ($rows) {
            $FirstRow = $rows[0];
            $Fields = array();
            foreach ($FirstRow as $key => $value) {
                $Fields[$key] = $key;
            }
            $FieldsZero[0] = $Fields;
            $RowsWithCaption = array_merge($FieldsZero, $rows);

            // printr($FieldsZero,"FieldsZero");
            // printr($rows,"rows");
            // printr($RowsWithCaption,"RowsWithCaption");

        }
        else {
            $RowsWithCaption = $rows;
        }
        return $RowsWithCaption;

    }

    static function outputCSVFromKeyValueArray($keyValueArray, $delimiter = ",", $enclosure = "\"", $filename = "csvreport.csv")
    {
        $arrayWithCaptions = self::putCaptionsOnCSVArray($keyValueArray);
        $csvString = self::getCVsString($arrayWithCaptions, $delimiter, $enclosure);
        self::SendCSVInHeader($csvString, $filename);
    }

    //echo "<br/> result is $result <br/>";

    static function csvToArray($fileName, $delimiter = ",")
    {
        $handle = fopen($fileName, "r");
        $rows = array();
        $header = fgetcsv($handle, null, $delimiter);
        while (($data = fgetcsv($handle, null, $delimiter)) !== FALSE) {
            $row = array();
            foreach ($header as $key => $heading) {
                $heading = trim($heading);
                $row[$heading] = (isset($data[$key])) ? Encoding::toUTF8($data[$key]) : '';
            }
            $rows[] = $row;
        }
        fclose($handle);
        return $rows;
    }
}