<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends MY_Controller {

    public function __construct() {
    parent::__construct();

  }

  public function index() {

  }

  private function _sftp() {

    set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'third_party/phpseclib');

    include(APPPATH . '/third_party/phpseclib/Net/SSH2.php');
    include(APPPATH . '/third_party/phpseclib/Net/SFTP.php');

    $sftp = new Net_SFTP('sftp.acquirgy.com:3822');
    if (!$sftp->login('ecovacs', '')) {
        $sftp = false;
    }
    return $sftp;

  }

  public function create_export_file() {

    $this->layout = false;
    $this->view = false;

    // $orders =  $this->order_model->get_all();
    $sql = "SELECT
    'WEB' AS 'SourceCode'
  , DATE_FORMAT(orders.created_at,'%m/%d/%Y') AS 'DateOrdered'
  , orders.id AS 'ReferenceNumber'
  , CASE
    WHEN orders.opt_out = 0 THEN 'no'
    ELSE 'yes'
    END AS 'Opt-In'
  , orders.b_first_name AS 'FirstName'
  , orders.b_last_name AS 'LastName'
  , orders.b_address AS 'BillingAddress1'
  , orders.s_apt AS 'BillingAddress2'
  , orders.b_city AS 'BillingCity'
  , orders.b_state AS 'BillingState'
  , REPLACE(orders.b_zip, '-', '')  AS 'BillingZip'
  , orders.b_country AS 'BillingCountry'
  , orders.phone AS 'Phone'
  , orders.email AS 'Email'
  , orders.payment_type AS 'PaymentMethod'
  , '' AS 'CreditCardNumber'
  , '' AS 'ExpDate'
  , '' AS 'CVV2'
  , '' AS 'AuthCode'
  , '' AS 'ExtendedTransItem'
  , '' AS 'CheckRouting#'
  , '' AS 'Account#'
  , '' AS 'Check#'
  , '' AS 'Amount Paid'
  , CASE
    WHEN orders.shipping_type = 'Rush' THEN 'UP2'
    WHEN orders.s_country = 'Canada' THEN 'UP9'
    WHEN orders.s_country = 'Puerto Rico' OR orders.s_state = 'AK' OR orders.s_state = 'HI' THEN 'UPC'
    ELSE ''
    END AS 'Special Ship Method'
  , orders.s_first_name AS 'Shipping FirstName'
  , orders.s_last_name AS 'Shipping LastName'
  , orders.s_address AS 'Shipping Address1'
  , orders.s_apt AS 'Shipping Address2'
  , orders.s_city AS 'Shipping City'
  , orders.s_state AS 'Shipping State'
  , REPLACE(orders.s_zip, '-', '')  AS 'Shipping Zip'
  , orders.s_country AS 'Shipping Country'
  , CONVERT(orders.tax_total, char(6)) AS 'Order Tax'
  , NULL AS 'ORDER S&H'
  , orders.discount_total AS 'Order Discount'
  , NULL AS 'MB Code'
  , ol.qty AS 'QTY1'
  , ol.product_sku AS 'PROD1'
  , ol.product_price AS 'EXT1'
  , CASE
    WHEN ol.qty > 0 THEN orders.shipping_total
    ELSE ''
    END  AS 'SH1'
  , ol2.qty AS 'QTY2'
  , ol2.product_sku AS 'PROD2'
  , ol2.product_price AS 'EXT2'
  , CASE
    WHEN ol2.qty > 0 THEN orders.shipping_total
    ELSE ''
    END  AS 'SH2'
  , ol3.qty AS 'QTY3'
  , ol3.product_sku AS 'PROD3'
  , ol3.product_price AS 'EXT3'
  , CASE
    WHEN ol3.qty > 0 THEN orders.shipping_total
    ELSE ''
    END  AS 'SH3'
  , ol4.qty AS 'QTY4'
  , ol4.product_sku AS 'PROD4'
  , ol4.product_price AS 'EXT4'
  , CASE
    WHEN ol4.qty > 0 THEN orders.shipping_total
    ELSE ''
    END  AS 'SH4'
  , ol5.qty AS 'QTY5'
  , ol5.product_sku AS 'PROD5'
  , ol5.product_price AS 'EXT5'
  , CASE
    WHEN ol5.qty > 0 THEN orders.shipping_total
    ELSE ''
    END  AS 'SH5'
FROM
    orders
    LEFT OUTER JOIN order_lines ol ON ol.order_id = orders.id
      AND ol.product_id IN (1,2)
    LEFT OUTER JOIN order_lines ol2 ON ol2.order_id = orders.id
      AND ol2.product_id = 3
    LEFT OUTER JOIN order_lines ol3 ON ol3.order_id = orders.id
      AND ol3.product_id = 4
    LEFT OUTER JOIN order_lines ol4 ON ol4.order_id = orders.id
      AND ol4.product_id = 5
    LEFT OUTER JOIN order_lines ol5 ON ol5.order_id = orders.id
      AND ol5.product_id = 6
WHERE orders.created_at >= CURDATE()-1 AND orders.created_at < CURDATE()
ORDER BY orders.created_at";

    $query = $this->db->query($sql);
    $orders = $query->result_array();

    $this->load->helper('csv_helper');
    $text = array_to_tab_delimited($orders);

    $filename = 'Ecovacs_' . date('Ymd') . '_' . date('hi') . '.txt';

    $this->load->helper('download');
    force_download($filename, $text);

    // Connect to sftp
    $sftp = $this->_sftp();
  }

  public function sendRecordCount() {
    $this->layout = false;
    $this->view = false;

    $this->db->where('created_at >=', date('Y-m-d', strtotime(' -1 day')) . ' 00:00:00');
    $this->db->where('created_at <', date('Y-m-d') . ' 00:00:00');
    $rowcount = $this->db->count_all_results('orders');

    $exportfilename = 'Ecovacs_' . date('Ymd') . '.txt';
    $message = 'File: ' . $exportfilename . ' containing ' . $rowcount . ' records has been posted to SFTP.';

    $this->appemail->fulfillment($message);
  }

  public function create_dailyreport_file() {

    $this->layout = false;
    $this->view = false;

    $sql = "SELECT
    DATE_FORMAT(orders.created_at,'%m/%d/%Y') AS 'DateOrdered'
    , orders.id AS 'OrderId'
    , CASE
    WHEN orders.shipping_type = 'Rush' THEN 'UP2'
    WHEN orders.s_country = 'Canada' THEN 'UP9'
    WHEN orders.s_country = 'Puerto Rico' OR orders.s_state = 'AK' OR orders.s_state = 'HI' THEN 'UPC'
    ELSE ''
    END AS 'Special Ship Method'

    ,  CASE
    WHEN ol.product_id = 1
    THEN ol.qty
    ELSE ''
    END AS 'Main Offer - 1 Pay'
    ,  CASE
    WHEN ol.product_id = 2
    THEN ol.qty
    ELSE ''
    END AS 'Main Offer - 5 Pay'
    , IFNULL(CAST(ol2.qty as char(2)), '') AS 'UPSELL1'
    , IFNULL(CAST(ol3.qty as char(2)), '') AS 'UPSELL2'
    , IFNULL(CAST(ol4.qty as char(2)), '') AS 'UPSELL3'
    , IFNULL(CAST(ol5.qty as char(2)), '') AS 'Additional WINBOT'
    FROM
    orders
    LEFT OUTER JOIN order_lines ol ON ol.order_id = orders.id
    AND ol.product_id IN (1,2)
    LEFT OUTER JOIN order_lines ol2 ON ol2.order_id = orders.id
    AND ol2.product_id = 3
    LEFT OUTER JOIN order_lines ol3 ON ol3.order_id = orders.id
    AND ol3.product_id = 4
    LEFT OUTER JOIN order_lines ol4 ON ol4.order_id = orders.id
    AND ol4.product_id = 5
    LEFT OUTER JOIN order_lines ol5 ON ol5.order_id = orders.id
    AND ol5.product_id = 6
    WHERE orders.created_at >= CURDATE()-1 AND orders.created_at < CURDATE()
    ORDER BY orders.created_at";

    $query = $this->db->query($sql);
    $orders = $query->result_array();

    $this->load->helper('csv_helper');
    $text2 = array_to_tab_delimited($orders);

    $filename2 = 'EcovacsOrders_' . date('mdY') . '.txt';

    $this->load->helper('download');
    force_download($filename2, $text2);

    // Connect to sftp
    $sftp = $this->_sftp();
  }

}