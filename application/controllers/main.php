<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {}

  public function cart() {
    $this->data['products'] = $this->product_model->get_all();
    $this->data['upsells'] = $this->product_model->get_many_by(array('type' => 'upsell'));
    $this->data['$orders'] = $this->order_model->get_all();
    $this->data['$order_lines'] = $this->order_line_model->get_all();
  }

  public function submit() {

    $this->view = false;

    // Lets create our order
    $order = array(
      'status' => 'new',
      'ip' => $this->input->ip_address(),
      'email' => $this->input->post('email'),
      'opt_in' => $this->input->post('opt_in-in'),
      'phone' => $this->input->post('phone'),
      'phone_extension' => $this->input->post('phone_extension'),
      'b_first_name' => $this->input->post('b_first_name'),
      'b_last_name' => $this->input->post('b_last_name'),
      'b_address' => $this->input->post('b_address'),
      'b_apt' => $this->input->post('b_apt'),
      'b_city' => $this->input->post('b_city'),
      'b_state_province' => $this->input->post('b_state_province'),
      'b_zip' => $this->input->post('b_zip'),
      'b_country' => $this->input->post('b_country'),
      's_first_name' => $this->input->post('s_first_name'),
      's_last_name' => $this->input->post('s_last_name'),
      's_address' => $this->input->post('s_address'),
      's_apt' => $this->input->post('s_apt'),
      's_city' => $this->input->post('s_city') ,
      's_state_province' => $this->input->post('s_state_province'),
      's_zip' => $this->input->post('s_zip'),
      's_country' => $this->input->post('s_state_province'),
      'payment_option' => $this->input->post('payment_option'),
      'shipping_type' => $this->input->post('shipping_type'),
      'coupon_code' => $this->input->post('coupon_code'),
      'card_id' => $this->input->post('card_id')
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
    $post_order_lines = $this->input->post('order_lines');

    foreach($post_order_lines as $post_order_line) {
      if(is_numeric($post_order_line['qty']) && $post_order_line['qty'] > 0) {
        $product = $this->product_model->get($post_order_line['product_id']);
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

    $order = $this->order_model->with('order_lines')->get($order_id);

    $email = array(
      'to' => $order['email'],
      'subject' => special_characters('Your WINBOT Order Confirmation #' . $order['string_id']),
      'data' => array('order' => $order)
    );
    $this->appemail->customer($email);

    redirect('/main/confirmation/' . $order['string_id']);

  }

  public function confirmation($string_id = false) {
    $order = $this->order_model->with('order_lines')->get_by(array('string_id' => $string_id));
    if($order) {
      $this->data['order'] = $order;
     } else {
       redirect('/');
     }
  }

  public function send_email($string_id) {
    $this->view = false;
    $order = $this->order_model->with('order_lines')->get_by(array('string_id' => $string_id));
    $email = array(
      'to' => $order['email'],
      'subject' => special_characters('Your WINBOT Order Confirmation #' . $order['string_id']),
      'data' => array('order' => $order)
    );
    $this->appemail->customer($email);
  }

  // AJAX CALLS //

  public function get_pricing() {

    $this->view = false;
    require_once(APPPATH . 'services/Pricer.php');
    $pricer = new Pricer();
    $pricing = $pricer->calculate($this->input->post());
    echo json_encode($pricing);

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

  public function tokenize_card() {

    $this->view = false;

    $result = array('card_id' => false, 'error' => false);

    define("AUTHORIZENET_API_LOGIN_ID", "6Gn44kBR");
    define("AUTHORIZENET_TRANSACTION_KEY", "36acB32fv8CA2KD2");
    define("AUTHORIZENET_SANDBOX", true);

    $customerProfile = new AuthorizeNet\Common\Type\Customer;
    $customerProfile->merchantCustomerId = time() . mt_rand(1000000,9999999);
    $customerProfile->email = $this->input->post('email');

    $address = new AuthorizeNet\Common\Type\Address;
    $address->firstName = $this->input->post('b_first_name');
    $address->lastName = $this->input->post('b_last_name');
    $address->zip = $this->input->post('b_zip');
    $address->address = $this->input->post('b_address');

    $paymentProfile = new AuthorizeNet\Common\Type\PaymentProfile;
    $paymentProfile->customerType = "individual";
    $paymentProfile->payment->creditCard->cardNumber = $this->input->post('card_number');
    $paymentProfile->payment->creditCard->expirationDate =
      $this->input->post('card_exp_year') . '-' . $this->input->post('card_exp_month');
    $paymentProfile->payment->creditCard->cardCode = $this->input->post('card_code');
    $paymentProfile->billTo = $address;

    $customerProfile->paymentProfiles[] = $paymentProfile;

    $request = new AuthorizeNet\Service\Cim\Request;
    $response = $request->createCustomerProfile($customerProfile, 'liveMode');

    if($response->isOk()) {
      $card = array(
        'authnet_customer_id' => $response->getCustomerProfileId(),
        'authnet_payment_profile_id' => $response->getPaymentProfileId(),
        'number' => substr($this->input->post('card_number'), -4),
        'exp_year' => $this->input->post('card_exp_year'),
        'exp_month' => $this->input->post('card_exp_month')
      );
      $result['card_id'] = $this->card_model->insert($card);

    } else {
      $messages = @$response->getValidationResponses();
      $result['error'] = $messages ? $messages[0]->response_reason_text : 'Whoops, something broke.';
    }

    echo json_encode($result);

  }

}

