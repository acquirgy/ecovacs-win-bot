<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model {

  public $before_create = array('created_at', 'updated_at');
  public $before_update = array('updated_at');
  public $before_get = array('default_order');
  protected $return_type = 'array';

  function __construct() {
    parent::__construct();
  }

  public function default_order() {
    $this->db->order_by('order','ASC');
  }


}