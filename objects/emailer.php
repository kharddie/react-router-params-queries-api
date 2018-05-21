<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Emailer{

	public $to;
	public $subject;
	public $from;
	public $link;
	public $message;

	public function __construct(){

	}

	function sendEmail(){

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Create email headers
		$headers .= 'From: '.$this->from ."\r\n".
		'Reply-To: '.$this->from ."\r\n" .
		'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
// Sending email
		if(mail($this->to, $this->subject, $this->message, $headers)){
			return true;
		} else{
			return false;

			//exit();
		}
	}
}
?>