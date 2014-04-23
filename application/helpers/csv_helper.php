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