<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model {

  public $before_create = array('created_at', 'updated_at');
  public $before_update = array('updated_at');
  public $before_get = array('default_order');
  protected $return_type = 'array';

  function __construct() {
    parent::__construct();

    $this->load->library('cart');
  }

  public function default_order() {
    $this->db->order_by('order','ASC');
  }

// Add an item to the cart
  function validate_add_cart_item($id, $qty){

    $this->db->where('id', $id); // Select where id matches the posted id
    $query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1

    // Check if a row has matched our product id
    if($query->num_rows > 0){
    // We have a match!
      $row = $query->row();
            // Create an array with product information
      $data = array(
        'id'      => $id,
        'qty'     => $qty,
        'price'   => $row->price,
        'name'    => $row->title
        );

            // Add the data to the cart using the insert function that is available because we loaded the cart library
      $this->cart->insert($data);

            return TRUE; // Finally return TRUE

          } else {
        // Nothing found! Return FALSE!
            return FALSE;
          }
        }

  // Add Multipay Winbot to the cart
  function add_MultipayWinbot(){
    $this->db->where('id', 2); // Select product
    $query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1

    // Check if a row has matched our product id
    if($query->num_rows > 0){
    // We have a match!
      $row = $query->row();
      // Create an array with product information
      $data = array(
        'id'      => $row->id,
        'qty'     => 1,
        'price'   => $row->price,
        'name'    => $row->title
        );

      // Add the data to the cart using the insert function that is available because we loaded the cart library
      $this->cart->insert($data);
    }

  }

    // Add Singlepay Winbot to the cart
  function add_SinglepayWinbot(){
    $this->db->where('id', 1); // Select product
    $query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1

    // Check if a row has matched our product id
    if($query->num_rows > 0){
    // We have a match!
      $row = $query->row();
      // Create an array with product information
      $data = array(
        'id'      => $row->id,
        'qty'     => 1,
        'price'   => $row->price,
        'name'    => $row->title
        );

      // Add the data to the cart using the insert function that is available because we loaded the cart library
      $this->cart->insert($data);
    }

  }


}