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
 Verssion: 0.1.3.0 Alpha
-----------------------------------------------------
 Usage: Generate random text to entertain user
=====================================================
*/
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}
	class randTexts {
	
		/* INPUT */
		private $textToSend;
		private $debug;
		
		/* INTERNAL */
		private $textsDir;
		private $textArr;
		
		/**
		 * randTexts constructor.
		 * @param $textType
		 * @param bool $debug
		 */
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
			$filePath = $this->textsDir.$this->textToSend.'.txt';
			if(file_exists($filePath)) {
				$this->textArr = file($filePath);
				$randWord = rand(0, count($this->textArr)-1);
				$answer = $this->textArr[$randWord];
			} else {
				$answer = '{"message": "File '.$filePath.' not found!"}';
			}
			return $answer;
		}
		
		private function prepareWorkDir(){
			//WIP
		}
	
	}