<?php
/*
=====================================================
 And the answer is?! | messages
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: messages.php
-----------------------------------------------------
 Version: 0.1.0.0 Experimental
-----------------------------------------------------
 Usage: Some text used in API
=====================================================
*/
	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}

	$message = array(
	/* AUTH */
	'wrongLoginPass' => 'Неправильный логин или пароль',
	'userNotFound'	 => 'Пользователь не найден',
	'dataNotIsset'	 => 'Данные не введены',
	'congrats'		 => 'Поздравляю, вы - Лис!',
	
	/* HWID */
	'HWIDerror'		 => 'Не с того ПК заходим!'
	);