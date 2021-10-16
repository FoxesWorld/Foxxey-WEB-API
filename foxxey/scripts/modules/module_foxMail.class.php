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
 Version: 0.1.1.0 Final
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
	
	function __construct($is_html = false) {
		global $config;
		foxMail::IncludestartUpSoundModules();
		$this->mail = new PHPMailer;
		$this->mail->CharSet = $config['encoding'];
		$this->mail->Encoding = "base64";

		$config['mail_title'] = str_replace( '&amp;', '&', $config['mail_title'] );

		if( $config['mail_title'] ) {
			$this->mail->setFrom($config['admin_mail'], $config['mail_title']);
		} else {
			$this->mail->setFrom($config['admin_mail'] );			
		}
		
		if($config['mail_metod'] == "smtp") {
			$this->mail->isSMTP();
			$this->mail->Timeout = 10;
			$this->mail->Host = $config['smtp_host'];
			$this->mail->Port = intval( $config['smtp_port'] );
			$this->mail->SMTPSecure = $config['smtp_secure'];
			
			if( $config['smtp_user'] ) {
				$this->mail->SMTPAuth = true;
				$this->mail->Username = $config['smtp_user'];
				$this->mail->Password = $config['smtp_pass'];
			}
			
			if( $config['smtp_mail'] ) {
				$this->mail->From = $config['smtp_mail'];
				$this->mail->Sender = $config['smtp_mail'];
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
		include (FOXXEYDATA.'mail/'.$name.".tpl");
		$text = ob_get_clean();
		return $text;
    }
	
	function addAttachment($path, $name = '', $encoding = 'base64', $type = '', $disposition = 'attachment') {
		$this->mail->addAttachment( $path, $name, $encoding, $type, $disposition );
	}
	
	private static function IncludestartUpSoundModules(){
		global $config;
		$modulesDir = SCRIPTS_DIR.'/modules/mailModules';
			if(!is_dir($modulesDir)){
				mkdir($modulesDir);
			}
		functions::includeModules($modulesDir, $config['modulesDebug']);
		}
}
?>