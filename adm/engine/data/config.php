<?php
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}
	$admConfig = array(
	
			/* Authorisation */
			'additionalParseData' => array('fullname', 'foto', 'reg_date', 'info', 'land', 'lastdate'),
		
			/* Base Data*/
			'monthArray'		  => array(
					  ".01." => "января",
					  ".02." => "февраля",
					  ".03." => "марта",
					  ".04." => "апреля",
					  ".05." => "мая",
					  ".06." => "июня",
					  ".07." => "июля",
					  ".08." => "августа",
					  ".09." => "сентября",
					  ".10." => "октября",
					  ".11." => "ноября",
					  ".12." => "декабря"
			)
		);