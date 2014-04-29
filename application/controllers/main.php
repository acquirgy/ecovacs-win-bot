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

    if ($this->input->post('Country') == 'United States') {$billingState = $this->input->post('b_state');}
    if ($this->input->post('Country') == 'Canada') {$billingState= $this->input->post('b_province');}
    if ($this->input->post('Country') == 'Puerto Rico') {$billingState= $this->input->post('b_region');}
    if ($this->input->post('s_country') == 'United States') {$ShippingState = $this->input->post('s_state');}
    if ($this->input->post('s_country') == 'Canada') {$ShippingState= $this->input->post('s_province');}
    if ($this->input->post('s_country') == 'Puerto Rico') {$ShippingState= $this->input->post('s_region');}

    // Lets create our order
    $order = array(
      'ip' => $this->input->ip_address(),
      'email' => $this->input->post('email'),
      'opt_out' => $this->input->post('opt-in'),
      'phone' => $this->input->post('phone'),
      'phone_extension' => $this->input->post('phone-extension'),
      'b_first_name' => $this->input->post('b_first_name'),
      'b_last_name' => $this->input->post('b_last_name'),
      'b_address' => $this->input->post('b_address'),
      'b_apt' => $this->input->post('b_apt'),
      'b_city' => $this->input->post('b_city'),
      'b_state' => $billingState,
      'b_zip' => $this->input->post('b_zip'),
      'b_country' => $this->input->post('Country'),
      's_first_name' => $this->input->post('s_first_name'),
      's_last_name' => $this->input->post('s_last_name'),
      's_address' => $this->input->post('s_address'),
      's_apt' => $this->input->post('s_apt'),
      's_city' => $this->input->post('s_city'),
      's_state' => $ShippingState,
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


  public function get_discount($code = false, $address) {

    $this->view = false;

    $address = urldecode($address);

    $redeemed = false;
    $this->db->where('discount_code', $code);
    $this->db->where('b_address', $address);
    $rowcount = $this->db->count_all_results('orders');
    if ($rowcount > 0) {
      $redeemed = true;
    }

    $discounts = array(
      array(
        'code' => 'SpyPoint30',
        'type' => 'flat',
        'value' => '30',
        'expiration' => '08/17/2013'
        ),
      array(
        'code' => 'SkyPoint30',
        'type' => 'flat',
        'value' => '30',
        'expiration' => '08/17/2013'
        ),
      array(
        'code' => 'Percent30',
        'type' => 'percent',
        'value' => '.3',
        'expiration' => '08/17/2015'
        )
      );

    // Loop through our available discounts and if it matches on of our discounts, match it.
    $matched_discount = false;
    foreach($discounts as $discount) {
      if($discount['code'] == $code) {
        $matched_discount = $discount;
        if ($redeemed == true) {$matched_discount['message'] = "discount used";}
      }
    }

    if($matched_discount) {
      echo json_encode($matched_discount);
    } else {
      echo json_encode(false);
    }

  }

}

