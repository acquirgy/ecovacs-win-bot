<?php

class Pricer {

  private $ci;

  public function __construct() {
    $this->ci =& get_instance();
  }

  function calculate($order) {

    $pricing['subtotal'] = 0;
    $pricing['taxable_subtotal'] = 0;
    $pricing['discount_total'] = 0;
    $pricing['tax_rate'] = 0;
    $pricing['tax_total'] = 0;
    $pricing['shipping_total'] = 0;
    $pricing['total'] = 0;

    // Determine if outside shipping should be applied
    $outside_shipping = false;
    if($order['s_country'] != 'United States') $outside_shipping = true;
    if($order['s_state_province'] == 'HA' || $order['s_state_province'] == 'KI') $outside_shipping = true;

    // Add up the order lines and their shipping
    foreach($order['order_lines'] as $line) {
      if($line['qty'] > 0) {
        $product = $this->ci->product_model->get($line['product_id']);
        $pricing['shipping_total'] += $outside_shipping ? $product['outside_shipping'] : $product['shipping'];
        $pricing['subtotal'] += $product['price'] * $line['qty'];
        $pricing['taxable_subtotal'] += $product['taxable_price'] * $line['qty'];
      }
    }

    // Determine tax
    $pricing['tax_rate'] = ($order['b_state_province'] == 'CA') ? 0.08 : 0;
    $pricing['tax_total'] = $pricing['taxable_subtotal'] * $pricing['tax_rate'];

    // Get discount
    require_once(APPPATH . 'services/Discounter.php');
    $discounter = new Discounter();
    $coupon = $discounter->get_coupon($order['coupon_code']);

    // Confirm we have a coupon, and then lets make sure it valid before we apply it
    if($coupon && !$discounter->is_invalid($coupon, $order)) {
      $pricing['discount_total'] = ($coupon['type'] == 'flat') ?
        (float)$coupon['value'] : $coupon['value'] * $pricing['subtotal'];
    }

    // Add everything up!
    $pricing['total'] = $pricing['subtotal'] + $pricing['shipping_total'] +
      $pricing['tax_total'] - $pricing['discount_total'];

    return $pricing;

  }

}