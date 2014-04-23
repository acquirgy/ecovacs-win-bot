<?php

function print_rr($array, $exit = true) {

  echo '<pre>';
  print_r($array);
  echo '</pre>';
  if($exit) exit();

}

function order_columns() {
  return array('id',
               'string_id',
               'ip',
               'src',
               's_first_name',
               's_last_name',
               'total',
               'payment_type',
               'option',
               'source',
               'created_at',
               'ordered_at',
               'status'
  );
}


function file_columns() {
  return array('id',
               'created_at',
               'file_name',
               'type',
               'order_count'
    );
}

function job_columns() {
  return array('id',
               'initiated',
               'method',
               'status',
               'created_at'
    );
}

function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function money($s) {
  return number_format(round($s,2),2);
}

function date_to_output($date) {
  $date = date("m/d/Y", strtotime($date));
  return $date;
}

function datetime_to_output($datetime) {
  $datetime = date("m/d/Y h:i:s a", strtotime($datetime));
  return $datetime;
}

function format_date($date) {
  $date = date("m/d/Y", strtotime($date));
  return $date;
}

function format_date_time($datetime) {
  if(!$datetime || $datetime == '0000-00-00 00:00:00') {
    return '<small>n/a</small>';
  } else {
    $datetime = date("m/d/Y h:i:s a", strtotime($datetime));
    return $datetime;
  }
}

function format_option($color) {
  $color = ucwords(str_replace("-", " ", $color));
  return $color;
}

function nice_string($string) {
  $string = str_replace("_", " ", $string);
  return str_replace("-", " ", $string);
}

function special_characters($string) {
  return '=?UTF-8?B?'.base64_encode($string).'?=';
}

function states() {
  $states = array(
          '' => 'Select',
          'AL' => 'Alabama',
          'AK' => 'Alaska',
          'AZ' => 'Arizona',
          'AR' => 'Arkansas',
          'CA' => 'California',
          'CO' => 'Colorado',
          'CT' => 'Connecticut',
          'DE' => 'Delaware',
          'DC' => 'District of Columbia',
          'FL' => 'Florida',
          'GA' => 'Georgia',
          'HI' => 'Hawaii',
          'ID' => 'Idaho',
          'IL' => 'Illinois',
          'IN' => 'Indiana',
          'IA' => 'Iowa',
          'KS' => 'Kansas',
          'KY' => 'Kentucky',
          'LA' => 'Louisiana',
          'ME' => 'Maine',
          'MD' => 'Maryland',
          'MA' => 'Massachusetts',
          'MI' => 'Michigan',
          'MN' => 'Minnesota',
          'MS' => 'Mississippi',
          'MO' => 'Missouri',
          'MT' => 'Montana',
          'NE' => 'Nebraska',
          'NV' => 'Nevada',
          'NH' => 'New Hampshire',
          'NJ' => 'New Jersey',
          'NM' => 'New Mexico',
          'NY' => 'New York',
          'NC' => 'North Carolina',
          'ND' => 'North Dakota',
          'OH' => 'Ohio',
          'OK' => 'Oklahoma',
          'OR' => 'Oregon',
          'PA' => 'Pennsylvania',
          'RI' => 'Rhode Island',
          'SC' => 'South Carolina',
          'SD' => 'South Dakota',
          'TN' => 'Tennessee',
          'TX' => 'Texas',
          'UT' => 'Utah',
          'VT' => 'Vermont',
          'VA' => 'Virginia',
          'WA' => 'Washington',
          'WV' => 'West Virginia',
          'WI' => 'Wisconsin',
          'WY' => 'Wyoming'
  );
  return $states;
}

function provinces() {
  $provinces = array(
          "" => "Select",
          "AB" => "Alberta",
          "BC" => "British Columbia",
          "MB" => "Manitoba",
          "NB" => "New Brunswick",
          "NL" => "Newfoundland and Labrador",
          "NT" => "Northwest Territories",
          "NS" => "Nova Scotia",
          "NU" => "Nunavut",
          "ON" => "Ontario",
          "PE" => "Prince Edward Island",
          "QC" => "Quebec",
          "SK" => "Saskatchewan",
          "YT" => "Yukon"
  );
  return $provinces;
}

function job_methods() {
    return array(
    'charge_payments' => 'Charge Payments',
    'import_orders' => 'Import Orders',
    'capture_transactions' => 'Capture Transactions',
    'payment_reminders' => 'Payment Reminders',
    'schedule_batch' => 'Schedule Batch'
  );
}

function order_statuses() {
  return array(
    'started' => 'Started',
    'failed_duplicate_ip' => 'Failed - duplicate IP',
    'failed_fraud' => 'Failed - fraud',
    'failed_declined_card' => 'Failed - declined card',
    'processed' => 'Processed',
    'shipped' => 'Shipped',
    'completed' => 'Completed',
    'refunded' => 'Refunded',
    'returned' => 'Returned',
    'canceled' => 'Canceled',
    'bad_debt' => 'Bad Debt'
  );
}


function product_types() {
  return array(
    'primary' => 'Primary',
    'upsell' => 'Upsell',
  );
}

function promotion_types() {
  return array(
    '0' => 'None',
    'free_shipping' => 'Free Shipping'
  );

}


function file_types() {
  return array(
    'new_orders' => 'New Orders',
    'canceled_orders' => 'Canceled Orders',
    'shipped_orders' => 'Shipped Orders',
    'returned_orders' => 'Returned Orders',
    'daily_orders_export' => 'Daily Orders Export'
  );
}


function months($start_year = false, $start_month = false, $count = false) {
     $months = array("" => "month", "01" => "01 - January", "02" => "02 - February",
        "03" => "03 - March", "04" => "04 - April", "05" => "05 - May", "06" => "06 - June",
        "07" => "07 - July", "08" => "08 - August", "09" => "09 - September", "10" => "10 - October", "11" => "11 - November", "12" => "12 - December");

     if($start_year && $start_month && $count) {
        $months = array();
        for($i=0; $i <= $count; $i++) {
            $m = date('m', strtotime("$start_year-$start_month + {$i}months"));
            $M = date('F', strtotime("$start_year-$start_month + {$i}months"));
            $months[$m] = "$M";
        }
     }

     return $months;
}

function years($start_year = false, $start_month = false, $count = 64) {

     if(!$start_year) $start_year = date("Y");
     if(!$start_month) $start_month = date("m");
     $years = array(""=>'year');
     for($i=0; $i <= $count; $i++) {
        $y = date('Y', strtotime("$start_year-$start_month + {$i}months"));
        $years[$y] = $y;
     }
     return $years;
}

function na($string) {
  return $string ? $string : '<small>n/a</small>';
}

function file_path($file) {

  if(isset($file['type'])) $type = $file['type'];
  if(isset($file['files__type'])) $type = $file['files__type'];

  if(isset($file['file_name'])) $file_name = $file['file_name'];
  if(isset($file['files__file_name'])) $file_name = $file['files__file_name'];

  switch($type) {
    case 'new_orders':
      $sub_path = 'order_imports';
      break;
    case 'order_updates':
    case 'shipped_orders':
    case 'canceled_orders':
    case 'returned_orders':
      $sub_path = 'order_updates';
      break;
    case 'daily_orders_export':
      $sub_path = 'order_exports';
      break;
    default:
      $sub_path = 'na';
      break;
  }

  return '/uploads/' . $sub_path . '/' . $file_name;

}

function create_ajax_links($current_page, $total_pages) {
  $links = "<ul class='pagination'>";

  if($current_page >= 5) {
    $back_arrow = $current_page - 4;
    $links = $links . "<li><a href='#' data-page='" . $back_arrow . "' class='page'> << </a></li>";
  }

  $min_range = $current_page - 3;
  $max_range = $current_page + 3;

  for($i = 1; $i <= $total_pages; $i++) {
    if($i == $current_page) {
      $links = $links . "<li class='selected'>" . $i . "</li>";
    } else if($i >= $min_range && $i <= $max_range) {
      $links = $links . "<li><a href='#' data-page='" . $i . "' class='page'>" . $i . "</a></li>";
    }
  }

  if($current_page != $total_pages) {
    $forward_arrow = $current_page + 4;
    if($forward_arrow < $total_pages) {
      $links = $links . "<li><a href='#' data-page='" . $forward_arrow . "' class='page'> >> </a></li>";
    }
  }

  $links = $links . "</ul>";
  return $links;
}

function clean_phone($number) {
  $number = str_replace('-','',$number);
  $number = str_replace(' ','',$number);
  $number = str_replace('(','',$number);
  $number = str_replace(')','',$number);
  return $number;
}
