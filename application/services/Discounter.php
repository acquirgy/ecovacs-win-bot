<?php

class Discounter {

  private $ci;
  private $coupons;

  public function __construct() {
    $this->ci =& get_instance();

    $this->coupons = array(
      array(
        'code' => 'SpyPoint30',
        'type' => 'flat',
        'value' => 30,
        'expiration' => '08/17/2015'
      ),
      array(
        'code' => 'SkyPoint30',
        'type' => 'flat',
        'value' => 30,
        'expiration' => '08/17/2015'
      ),
      array(
        'code' => 'Percent30',
        'type' => 'percent',
        'value' => 0.3,
        'expiration' => '08/17/2015'
      )
    );
  }

  function get_coupon($coupon_code) {
    // Find matching coupon
    if($coupon = find_in_array($coupon_code, 'code', $this->coupons)) {
      return $coupon;
    } else {
      return false;
    }
  }

  function is_invalid($coupon, $order) {

    $invalid_message = false;

    // Lets check if the coupon is expired
    if(time() > strtotime($coupon['expiration'])) $invalid_message = 'Coupon has expired.';

    // Lets see if the address on this order has other orders which used this coupon
    $orders = $this->ci->order_model->get_many_by(array(
      'coupon_code' => $coupon['code'],
      'b_address' => $order['b_address'],
      'b_city' => $order['b_city']
    ));
    if($orders) $invalid_message = 'Coupon already used for an order.';

    return $invalid_message;

  }

}