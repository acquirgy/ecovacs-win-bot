<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . '/third_party/phpmailer/class.phpmailer.php' );

class AppEmail extends MY_Controller {

  private $ci;
  private $config;
  private $mail;

  public function __construct() {

    $this->mail = new PHPMailer;
    $this->mail->CharSet = "UTF-8";
    $this->mail->isSMTP();
    $this->mail->isHTML(true);
    $this->mail->Host = 'smtp.office365.com';
    $this->mail->Port = 587;
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->SMTPKeepAlive = true;
    $this->mail->Timeout = 5;
    $this->mail->SMTPDebug  = 0;

    $this->config = array(
      'mailtype' => 'html',
      'protocol' => 'smtp',
      'smtp_host' => '',
      'smtp_user' => '',
      'smtp_pass' => '',
      'smtp_port' => '587',
      'smtp_timeout' => 5,
      'smtp_crypto' => 'tls'
    );
    $this->ci =& get_instance();

  }

  public function system($message) {
    $this->mail->clearAddresses();
    $this->mail->addAddress('crubin@acquirgy.com');
    $this->mail->Username = 'customerservice@winbot7.com';
    $this->mail->Password = 'th4$M14kk!';
    $this->mail->From = 'customerservice@winbot7.com';
    $this->mail->FromName = 'WINBOT TV Offer';
    $this->mail->Subject = 'SYSTEM ERROR ' .  base_url();
    $message .= '<br /><br /><hr /><br />SERVER:<br /><pre>' . print_r($_SERVER,true);
    $message .= '<br /><br /><hr /><br />POST:<br /><pre>' . print_r($_POST,true);
    if(session_id() != '') $message .= '<br /><br /><hr /><br />SESSION:<br /><pre>' . print_r($_SESSION,true);
    $this->mail->Body = '<br />' . $message . '<br /><br /><br />';
    if(!$this->mail->send()) { echo $this->mail->ErrorInfo; }
  }

  public function customer($params) {
    $this->mail->clearAddresses();
    $this->mail->Username = 'customerservice@winbot7.com';
    $this->mail->Password = 'th4$M14kk!';
    $this->mail->addAddress($params['to']);
    $this->mail->From = 'customerservice@winbot7.com';
    $this->mail->FromName = 'WINBOT TV Offer';
    $this->mail->Subject = $params['subject'];
    $this->mail->Body = $this->ci->load->view('front/main/confirmation_email', $params['data'], TRUE);
    $this->mail->send();
  }

  public function admin($params) {
    $this->mail->clearAddresses();
    $this->mail->addAddress('opsnotification@acquirgy.com');
    $this->mail->addAddress('roeland@bythepixel.com');
    $this->mail->Username = 'KitchenAidReporting@acquirgy.com';
    $this->mail->Password = 'KA_Pass1!';
    $this->mail->From = 'KitchenAidReporting@acquirgy.com';
    $this->mail->FromName = 'KitchenAid Reporting';
    $this->mail->Subject = $params['subject'];
    $params['view'] = isset($params['view']) ? $params['view'] : 'notification_admin';
    $this->mail->Body = $this->ci->load->view('admin/email/' . $params['view'], $params['data'], TRUE);
    if($this->ci->settings['admin_email']) {
      $this->mail->send();
    }
  }

    public function fulfillment($params) {
    $this->mail->clearAddresses();
    $this->mail->Username = 'customerservice@winbot7.com';
    $this->mail->Password = 'th4$M14kk!';
    $this->mail->addAddress('cassandra@mfals.com');
    $this->mail->addAddress('hilda@mfals.com');
    $this->mail->addAddress('lindab@mfals.com');
    $this->mail->From = 'EcovacsOffer@acquirgy.com';
    $this->mail->FromName = 'WINBOT TV Offer';
    $this->mail->Subject = $params['subject'];
    $this->mail->Body = $params['message'];
    $this->mail->send();
  }

}
