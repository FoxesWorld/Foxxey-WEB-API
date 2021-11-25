<?php
/*
=====================================================
 FoxMail Class
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021 FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: foxMail.class.php
-----------------------------------------------------
 Version: 0.1.2.1 Final
-----------------------------------------------------
 Usage: Sending an Email
=====================================================
*/

	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	} else {
		define('FoxMail',true);
	}

class foxMail {

	public $mail = false;
	public $send_error = false;
	public $smtp_msg = "Succesful send mail to ";
	public $from = false;
	public $html_mail = false;
	public $bcc = array ();
	public $keepalive = false;
	/* CONFIG */
	private $mdlName = null;
	private $defaultConfig = array('mail' => 
		array(
			'encoding' 			=> 'UTF-8',
			'admin_mail' 		=> 'lisssicin@yandex.ru',
			'mail_title' 		=> 'Foxesworld',
			'mail_metod' 		=> 'smtp',
			'smtp_host' 		=> 'smtp.yandex.ru',
			'smtp_port' 		=> '465',
			'smtp_user' 		=> 'no-reply@foxesworld.ru',
			'smtp_pass' 		=> 'YourPass',
			'smtp_secure' 		=> 'ssl',
			'smtp_mail' 		=> 'no-reply@foxesworld.ru',
		));
	private $config;
	
	function __construct($is_html = false) {
		$this->mdlName = basename(__FILE__);
		$conf = conff::confGen($this->mdlName, $this->defaultConfig);
		$this->config = $conf->readInIarray();
		filesInDir::getIncludes($this->mdlName);
		$this->mail = new PHPMailer;
		$this->mail->CharSet = $this->config['encoding'];
		$this->mail->Encoding = "base64";

		$this->config['mail_title'] = str_replace( '&amp;', '&', $this->config['mail_title'] );

		if($this->config['mail_title']) {
			$this->mail->setFrom($this->config['admin_mail'], $this->config['mail_title']);
		} else {
			$this->mail->setFrom($this->config['admin_mail'] );			
		}
		
		if($this->config['mail_metod'] == "smtp") {
			$this->mail->isSMTP();
			$this->mail->Timeout = 10;
			$this->mail->Host = $this->config['smtp_host'];
			$this->mail->Port = intval($this->config['smtp_port'] );
			$this->mail->SMTPSecure = $this->config['smtp_secure'];
			
			if($this->config['smtp_user'] ) {
				$this->mail->SMTPAuth = true;
				$this->mail->Username = $this->config['smtp_user'];
				$this->mail->Password = $this->config['smtp_pass'];
			}
			
			if($this->config['smtp_mail'] ) {
				$this->mail->From = $this->config['smtp_mail'];
				$this->mail->Sender = $this->config['smtp_mail'];
			}
		}
		
		$this->mail->XMailer = "FoxesWorld CMS";
		
		if ( $is_html ) {
			$this->mail->isHTML();
			$this->html_mail = true;
		}
	}
	
	function send($to, $subject, $message) {
	
		if(!strpos($to, '.fr')) {
			if( $this->from ) {
				$this->mail->addReplyTo($this->from, $this->from);
			}
			
			$this->mail->addAddress($to);
			$this->mail->Subject = $subject;
			
			if($this->mail->Mailer == 'smtp' AND $this->keepalive ) {
				$this->mail->SMTPKeepAlive = true;
			}
			
			if( $this->html_mail ) {
				$this->mail->msgHTML($message);
			} else {
				$this->mail->Body = $message;
			}

			if( count( $this->bcc ) ) {
				
				foreach($this->bcc as $bcc) {
					$this->mail->addBCC($bcc);
				}
				
			}
			
			if (!$this->mail->send()) {
				$this->smtp_msg = $this->mail->ErrorInfo;
				$this->send_error = true;
				echo '{"message": "'.$this->smtp_msg.'", "type": "error"}';
			} else {
				//echo '{"message": "'.$this->smtp_msg.$to.'", "type": "success"}';
			}
			
			$this->mail->clearAllRecipients();
			$this->mail->clearAttachments();
		}
	
	}
	
	function getTemplate($name) {
		ob_start();
		include (ETC.'mail/'.$name.".tpl");
		$text = ob_get_clean();
		return $text;
    }
	
	function addAttachment($path, $name = '', $encoding = 'base64', $type = '', $disposition = 'attachment') {
		$this->mail->addAttachment( $path, $name, $encoding, $type, $disposition );
	}
}
?>