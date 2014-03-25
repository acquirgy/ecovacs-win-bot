<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
  }

  public function add() {

    $data = array(
        'id' => '42',
        'name' => 'Pants',
        'qty' => 1,
        'price' => 19.99
      );

    $this->cart->insert($data);

    echo "add() called";
  }

  function show() {
    $cart = $this->cart->contents();

    echo "<pre>";
    print_r($cart);
  }

  function addTshirt() {

        $data = array(
        'id' => '44',
        'name' => 'T-Shirt',
        'qty' => 2,
        'price' => 7.99
      );

    $this->cart->insert($data);

     echo "add2() called";
  }

  function updateTshirt() {

    $data = array(
      'rowid'=> 'f7177163c833dff4b38fc8d2872f1ec6',
      'qty' => '5'
      );

    $this->cart->update($data);
  }

  function total() {

    echo $this->cart->total();
  }

  function removeTshirt() {

      $data = array(
      'rowid'=> 'f7177163c833dff4b38fc8d2872f1ec6',
      'qty' => '0'
      );

    $this->cart->update($data);
  }

  function destroy() {
    $this->cart->destroy();
  }

}