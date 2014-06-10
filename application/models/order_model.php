<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends MY_Model {

  public $before_create = array('created_at', 'updated_at');
  public $after_create = array('generate_string_id');
  public $before_update = array('updated_at');
  public $before_get = array('default_order');
  public $has_many = array('order_lines');

  protected $return_type = 'array';
  protected $soft_delete = TRUE;

  function __construct() {
    parent::__construct();
  }

  public function generate_string_id($id) {
    $order = $this->get($id);
    if(strlen($id) < 2) {
      $id = '0' . $id;
    } else if(strlen($id) > 3) {
      $id = substr($id, -2);
    }
    $order['string_id'] = time() . 'WB' . $id . '13';
    $this->update($order['id'], $order);
    return $order;
  }

  public function default_order() {
    $this->db->order_by('orders.created_at','DESC');
  }
    /**
   * Insert a new row into the table. $data should be an associative array
   * of data to be inserted. Returns newly created ID.
   */
  public function insert($order, $skip_validation = FALSE)
  {
      $valid = TRUE;

      if ($skip_validation === FALSE)
      {
          $order = $this->validate($order);
      }

      if ($order !== FALSE)
      {
          $order = $this->trigger('before_create', $order);

          $this->db->insert('orders', $order);
          $insert_id = $this->db->insert_id();

          $this->trigger('after_create', $insert_id);

          return $insert_id;
      }
      else
      {
          return FALSE;
      }
  }


}