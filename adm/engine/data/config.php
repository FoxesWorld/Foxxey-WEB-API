<?php
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}
	$admConfig = array(
	
			/* Authorisation */
			
			/* Number of group that can logIn*/
			'groupsToShow' => array(1),
			
			/* Data To parse when authorising 
			 * `type` - the type of data, can be
			 * 'plainText', 'date' or `realname`
			 */
			'additionalParseData' => array(		
					array(
						'name' => 'fullname',
						'type' => 'realname'
					), 
					array(
						'name' => 'foto',
						'type' => 'plainText'
					),
					array(
						'name' => 'reg_date',
						'type' => 'date'
					),
					array(
						'name' => 'info',
						'type' => 'plainText'
					),
					array(
						'name' => 'land',
						'type' => 'plainText'
					), 
					array(
						'name' => 'lastdate',
						'type' => 'date')
			),
		
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