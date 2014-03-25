<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
  }

  public function index() {
    $this->cart->destroy();               // MOVE TO Confirmation Page!!
    $this->product_model->add_MultipayWinbot();
    $this->load->view('front/main/index');
  }

  public function shopping_cart() {

    $data['products'] = $this->product_model->get_many_by('type', 'primary');
    $data['upsells'] = $this->product_model->get_many_by('type', 'upsell');
    $data['cart'] = $this->cart->contents();

    $this->load->view('front/main/shopping_cart', $data);
  }

  function add() {

    $product = $this->product_model->get($this->input->post('id'));

    if ($this->cart->total_items() > 0){
      foreach ($this->cart->contents() as $item){
        if ($item['id']== $this->input->post('id')){
          $data = array('rowid'=>$item['rowid'],'qty'=>++$item['qty']);
          $this->cart->update($data);
        }  else {
         $insert = array(
          'id' => $this->input->post('id'),
          'qty' => 1,
          'price' => $product['price'],
          'name' => $product['title']
          );

         $this->cart->insert($insert);
       }
     }
   }

   redirect('main/shopping_cart');
 }

  function remove($rowid) {
    $data = array(
      'rowid'=> $rowid,
      'qty' => '0'
      );

    $this->cart->update($data);

    redirect('main/shopping_cart');
  }

  function removeMultiPayWinbot() {
    $is_ajax = $this->input->post('ajax');

    if ($is_ajax) {
              $data = array(
      'rowid'=> $this->input->post('rowid'),
      'qty' => '0'
      );

    $this->cart->update($data);

    $this->product_model->add_SinglepayWinbot();

    } else {
      echo 'Failure!';
    }


  }


}

