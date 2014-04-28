<?php
function csv_to_array($csv, $delimiter = ',', $enclosure = '"', $escape = '\\', $terminator = "\n") {
    $r = array();
    $rows = explode($terminator,trim($csv));
    $names = array_shift($rows);
    $names = str_getcsv($names,$delimiter,$enclosure,$escape);
    $nc = count($names);
    foreach ($rows as $row) {
        if (trim($row)) {
            $values = str_getcsv($row,$delimiter,$enclosure,$escape);
            if (!$values) $values = array_fill(0,$nc,null);
            $r[] = array_combine($names,$values);
        }
    }
    return $r;
}

function array_to_csv($array, $delimiter = ',') {
  $result = false;
  if(!empty($array)) {
    $f = fopen('php://memory', 'w');
    fputcsv($f, array_keys($array[0]));
    foreach ($array as $line) {
      fputcsv($f, $line, $delimiter);
    }
    fseek($f, 0);
    $result = stream_get_contents($f);
    fclose($f);
  }
  return $result;
}

function array_to_tab_delimited($array) {
  $result = false;
  if(!empty($array)) {
    $f = fopen('php://memory', 'w');
    fputcsv2($f, array_keys($array[0]), chr(9));
    foreach ($array as $line) {
      fputcsv2($f, $line, chr(9));
    }
    fseek($f, 0);
    $result = stream_get_contents($f);
    fclose($f);
  }
  return $result;
}

function fputcsv2($filePointer,$dataArray,$delimiter) {
  // Write a line to a file
  // $filePointer = the file resource to write to
  // $dataArray = the data to write out
  // $delimeter = the field separator

  // Build the string
  $string = "";

  // No leading delimiter
  $writeDelimiter = FALSE;
  foreach($dataArray as $dataElement)
   {
    // Replace double quotes
    $dataElement=str_replace("\"", "", $dataElement);

    // Adds a delimiter before each field (except the first)
    if($writeDelimiter) $string .= $delimiter;

    // Encloses each field with $enclosure and adds it to the string
    $string .= $dataElement;

    // Delimiters are used every time except the first.
    $writeDelimiter = TRUE;
   } // end foreach($dataArray as $dataElement)

  // Append new line
  $string .= PHP_EOL;

  // Write the string to the file
  fwrite($filePointer,$string);
}