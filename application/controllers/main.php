<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

  public function __construct() {
    parent::__construct();

  }

  public function index() {

  }

  public function cart() {

    $this->data['products'] = $this->product_model->get_all();
    $this->data['upsells'] = $this->product_model->get_many_by(array('type' => 'upsell'));

    $this->data['$orders'] = $this->order_model->get_all();
    $this->data['$order_lines'] = $this->order_line_model->get_all();

  }

  public function submit() {

    $this->view = false;

    // Lets create our order
    $order = array(
      'email' => $this->input->post('email'),
      'opt_out' => $this->input->post('opt-in'),
      'phone' => $this->input->post('phone'),
      'phone_extension' => $this->input->post('phone-extension'),
      'b_first_name' => $this->input->post('b_first_name'),
      'b_last_name' => $this->input->post('b_last_name'),
      'b_address' => $this->input->post('b_address'),
      'b_apt' => $this->input->post('b_apt'),
      'b_city' => $this->input->post('b_city'),
      'b_state' => $this->input->post('b_state'),
      'b_zip' => $this->input->post('b_zip'),
      'b_country' => $this->input->post('Country'),
      's_first_name' => $this->input->post('s_first_name'),
      's_last_name' => $this->input->post('s_last_name'),
      's_address' => $this->input->post('s_address'),
      's_apt' => $this->input->post('s_apt'),
      's_city' => $this->input->post('s_city'),
      's_state' => $this->input->post('s_state'),
      's_zip' => $this->input->post('s_zip'),
      's_country' => $this->input->post('s_country'),
      'payment_type' => $this->input->post('cardType'),
      'payment_option' => $this->input->post('payment-option'),
      'shipping_type' => $this->input->post('shipping'),
      'shipping_total' => $this->input->post('shipping-total'),
      'discount_code' =>  $this->input->post('discount-code'),
      'discount_total' => $this->input->post('discount-total'),
      'tax_rate' => $this->input->post('tax-rate'),
      'tax_total' => $this->input->post('tax-total'),
      'taxable_subtotal' => $this->input->post('taxable-subtotal'),
      'grand_total' => $this->input->post('grandtotal'),
      'first_payment_subtotal' => $this->input->post('sub-total'),
      'first_payment_total' => $this->input->post('total'),
      );

    $order_id = $this->order_model->insert($order);

    // Create order lines
    $post_order_lines = array();
    $post_order_lines = $this->input->post('order_line');

    $subtotal = 0;

    foreach($post_order_lines as $post_order_line) {

      if(is_numeric($post_order_line['qty']) && $post_order_line['qty'] > 0) {
        $product = $this->product_model->get($post_order_line['id']);
        $order_line = array(
          'order_id' => $order_id,
          'qty' => $post_order_line['qty'],
          'product_id' => $product['id'],
          'product_price' => $product['price'],
          'product_sku' => $product['sku'],
          'product_title' => $product['title']
          );
        $this->order_line_model->insert($order_line);
      }

    }

    // Redirect to confirmation page!
    redirect('/main/confirmation/' . $order_id);

  }

  public function confirmation($order_id = false) {

    if($order_id && $this->data['order'] = $this->order_model->get($order_id)) {

      $this->data['order_lines'] = $this->order_line_model->get_many_by(array('order_id' => $order_id));

      $email = array(
        'to' => $this->data['order']['email'],
        'subject' => special_characters('Your WINBOT Order Confirmation #' . $this->data['order']['string_id']),
        'data' => array('order' => $this->data['order'], 'order_lines' => $this->data['order_lines'] )
      );

      $this->appemail->customer($email);

     } else {
       redirect('/');
     }

  }

  public function csv_test() {

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
  , '' AS 'PaymentMethod'
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
    WHEN orders.s_country = 'Puerto Rico' OR orders.s_state = 'AK' OR orders.s_state = 'HI' THEN 'UP9'
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
  , orders.shipping_total AS 'SH1'
  , ol2.qty AS 'QTY2'
  , ol2.product_sku AS 'PROD2'
  , ol2.product_price AS 'EXT2'
  , orders.shipping_total AS 'SH2'
  , ol3.qty AS 'QTY3'
  , ol3.product_sku AS 'PROD3'
  , ol3.product_price AS 'EXT3'
  , orders.shipping_total AS 'SH3'
  , ol4.qty AS 'QTY4'
  , ol4.product_sku AS 'PROD4'
  , ol4.product_price AS 'EXT4'
  , orders.shipping_total AS 'SH4'
  , ol4.qty AS 'QTY5'
  , ol4.product_sku AS 'PROD5'
  , ol4.product_price AS 'EXT5'
  , orders.shipping_total AS 'SH5'
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
ORDER BY orders.created_at";

    $query = $this->db->query($sql);
    $orders = $query->result_array();

    $this->load->helper('csv_helper');
    $csv = array_to_csv($orders);

    $this->load->helper('download');
    force_download('mycsvfile.csv', $csv);
  }

  public function get_discount($code = false) {

    $this->view = false;

    $discounts = array(
      array(
        'code' => 'SpyPoint30',
        'type' => 'flat',
        'value' => '30',
        'expiration' => '08/17/2013 '
        ),
      array(
        'code' => 'SkyPoint30',
        'type' => 'flat',
        'value' => '30',
        'expiration' => '08/17/2013 '
        ),
      array(
        'code' => 'Percent30',
        'type' => 'percent',
        'value' => '.3',
        'expiration' => '08/17/2013 '
        )
      );

    // Loop through our available discounts and if it matches on of our discounts, match it.
    $matched_discount = false;
    foreach($discounts as $discount) {
      if($discount['code'] == $code) {
        $matched_discount = $discount;
      }
    }

    if($matched_discount) {
      echo json_encode($matched_discount);
    } else {
      echo json_encode(false);
    }

  }

}

