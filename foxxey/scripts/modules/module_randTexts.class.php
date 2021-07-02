<?php 
/*
=====================================================
 Well, you are Tespi today!
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: randTexts.class.php
-----------------------------------------------------
 Verssion: 0.1.1.0 Alpha
-----------------------------------------------------
 Usage: Generate random text to entertain user
=====================================================
*/

	class randTexts {
	
		/* INPUT */
		private $textToSend;
		private $debug;
		
		/* INTERNAL */
		private $textsDir;
		
		function __construct($textType, $debug = false){
			$this->textsDir = SITE_ROOT.'/messages/randTexts/';
			$this->debug = $debug;
			$this->textToSend = $textType;

			if($this->debug === true){
				echo 'TextType - '.$this->textToSend;
			}
		}
		
		public function textOut(){
			return $this->getTexts();
			
		}

		private function getTexts(){
			$arr = file($this->textsDir.$this->textToSend.'.txt');
			$randWord = rand(0, count($arr)-1);
			return $arr[$randWord];
		}
		
		private function prepareWorkDir(){
			//WIP
		}
	
	}