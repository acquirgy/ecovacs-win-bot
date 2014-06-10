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
    $sad = $this->input->post('shipping_address_different');
    $order = array(
      'ip' => $this->input->ip_address(),
      'email' => $this->input->post('email'),
      'opt_out' => $this->input->post('opt-in'),
      'phone' => $this->input->post('phone'),
      'phone_extension' => $this->input->post('phone_extension'),
      'b_first_name' => $this->input->post('b_first_name'),
      'b_last_name' => $this->input->post('b_last_name'),
      'b_address' => $this->input->post('b_address'),
      'b_apt' => $this->input->post('b_apt'),
      'b_city' => $this->input->post('b_city'),
      'b_state' => $billingState,
      'b_zip' => $this->input->post('b_zip'),
      'b_country' => $this->input->post('country'),
      's_first_name' => $sad ? $this->input->post('s_first_name') : $this->input->post('b_first_name'),
      's_last_name' => $sad ? $this->input->post('s_last_name') : $this->input->post('b_last_name'),
      's_address' => $sad ? $this->input->post('s_address') : $this->input->post('b_address'),
      's_apt' => $sad ? $this->input->post('s_apt') : $this->input->post('b_apt'),
      's_city' => $sad ? $this->input->post('s_city') : $this->input->post('b_city'),
      's_state_province' => $sad ? $this->input->post('s_state_province') : $this->input->post('b_state_province'),
      's_zip' => $sad ? $this->input->post('s_state_province') : $this->input->post('b_state_province'),
      's_country' => $sad ? $this->input->post('s_state_province') : $this->input->post('b_state_province'),
      'payment_option' => $this->input->post('payment_option'),
      'shipping_type' => $this->input->post('shipping'),
      'coupon_code' =>  $this->input->post('coupon_code')
    );

    // Get pricing
    require_once(APPPATH . 'services/Pricer.php');
    $pricer = new Pricer();
    $pricing = $pricer->calculate($this->input->post());

    // Combine pricing array with order array so it can be inserted
    $order = array_merge($order, $pricing);

    // Insert actual order
    $order_id = $this->order_model->insert($order);

    // Create order lines
    $post_order_lines = array();
    $post_order_lines = $this->input->post('order_line');

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

    // Process order

  }

  public function get_pricing() {

    $this->view = false;
    require_once(APPPATH . 'services/Pricer.php');
    $pricer = new Pricer();
    $pricing = $pricer->calculate($this->input->post());
    echo json_encode($pricing);

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


  public function get_coupon() {

    $this->view = false;
    $result = array('coupon' => false, 'error' => false);

    // Get coupon
    require_once(APPPATH . 'services/Discounter.php');
    $discounter = new Discounter();

    // Confirm we have a coupon
    if($coupon = $discounter->get_coupon($this->input->post('coupon_code_temp'))) {

      // Now that we have a coupon, lets see if its valid with this order
      $result['error'] = $discounter->is_invalid($coupon, $this->input->post());
      $result['coupon'] = $coupon;

    } else {
      $result['error'] = 'Coupon not valid.';
      $result['coupon'] = false;
    }

    echo json_encode($result);

  }

}

