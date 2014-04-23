<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_line_model extends MY_Model {

  public $before_create = array('created_at', 'updated_at');
  public $before_update = array('updated_at');
  protected $return_type = 'array';

}