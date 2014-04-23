<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {

    $this->data['products'] = $this->product_model->get_all();
    $this->data['upsells'] = $this->product_model->get_many_by(array('type' => 'upsell'));
    $this->data['$orders'] = $this->order_model->get_all();
    $this->data['$order_lines'] = $this->order_line_model->get_all();

  }

  public function submit() {

    $this->view = false;

    // Lets create our order
    $order = array(
      's_first_name' => $this->input->post('s_first_name'),
      's_last_name' => $this->input->post('s_last_name')
    );

    $order_id = $this->order_model->insert($order);

    // Create order lines

    $post_order_lines = $this->input->post('order_line');
    $total = 0;

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
        $total = $total + ($product['price'] * $post_order_line['qty']);
      }

    }

    // Update order with totals
    $order_update = array(
      'total' => $total
    );
    $this->order_model->update($order_id,$order_update);

    // Redirect to confirmation page!
    redirect('/test/confirmation/' . $order_id);

  }

  public function confirmation($order_id = false) {

    if($order_id && $this->data['order'] = $this->order_model->get($order_id)) {

      $this->data['order_lines'] = $this->order_line_model->get_many_by(array('order_id' => $order_id));

    } else {
      redirect('/');
    }

  }

  public function get_discount($code = false) {

    $this->view = false;

    $discounts = array(
      array(
        'code' => 'SpyPoint30',
        'type' => 'percent',
        'value' => '.3'
      ),
      array(
        'code' => 'Flat20',
        'type' => 'flat',
        'value' => '20'
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