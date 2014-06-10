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
    $this->mail->Username = 'customerservice@winbot7.com';
    $this->mail->Password = 'w1nP@ss!';
    $this->mail->From = 'customerservice@winbot7.com';

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

    $this->mail->Subject = 'SYSTEM ERROR ' .  base_url();
    $message .= '<br /><br /><hr /><br />SERVER:<br /><pre>' . print_r($_SERVER,true);
    $message .= '<br /><br /><hr /><br />POST:<br /><pre>' . print_r($_POST,true);
    if(session_id() != '') $message .= '<br /><br /><hr /><br />SESSION:<br /><pre>' . print_r($_SESSION,true);
    $this->mail->Body = '<br />' . $message . '<br /><br /><br />';
    if(!$this->mail->send()) { echo $this->mail->ErrorInfo; }
  }

  public function customer($params) {
    $this->mail->clearAddresses();
    $this->mail->addAddress($params['to']);
    $this->mail->Subject = $params['subject'];
    $this->mail->Body = $this->ci->load->view('front/main/confirmation_email', $params['data'], TRUE);
    $this->mail->send();
  }

  public function admin($params) {
    $this->mail->clearAddresses();
    $this->mail->addAddress('opsnotification@acquirgy.com');
    $this->mail->Subject = $params['subject'];
    $params['view'] = isset($params['view']) ? $params['view'] : 'notification_admin';
    $this->mail->Body = $this->ci->load->view('admin/email/' . $params['view'], $params['data'], TRUE);
    if($this->ci->settings['admin_email']) {
      $this->mail->send();
    }
  }

    public function fulfillment($message) {
    $this->mail->clearAddresses();
    $this->mail->addAddress('crubin@acquirgy.com');
    $this->mail->addBCC('crubin@acquirgy.com');
    $this->mail->Subject = 'Ecovacs File Submission for Web Orders';
    $this->mail->Body = $message;
    $this->mail->send();
  }

}
