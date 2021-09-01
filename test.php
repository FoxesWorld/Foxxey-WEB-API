<?php
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);

	define('CURRENT_TIME',time());
	define('CURRENT_DATE',date("d.m.Y"));
	
	$test = new test();
	
class test {

	/* Date */
		private $dayToday;
		private $monthToday;
		private $yearToday;
	/* Date */
	
	/* File */
	private $filePath = 'files/startUpSound.txt';

	/*  Arrays */
	
	/* Array to cache in a file,
	if we find a cache file we would read it,
	otherwise - record it and read from that file*/
		private $eventsArray = array(
			'm01' => array(
				"1-12" =>  array(
					'eventName' => 'winterHolidays',
					'musRange'  => '1/2',
					'soundRange'=> '2/5'
				)
			),
			'm02' => array(
			
			),
			
			'm03' => array(
			
			),
			
			'm04' => array(
			
			),
			
			'm05' => array(
			
			),
			
			'm06' => array(
			
			),
			
			'm07' => array(
			
			),
			
			'm08' => array(
				'5-13' => array(
					'eventName' => 'Killing teddy!',
					'musRange'  => '1/2',
					'soundRange'=> '2/5'),

				'20-23' => array(
					'eventName' => 'Praising DarkFoxes',
					'musRange'  => '1/2',
					'soundRange'=> '2/5'
				)
			),
			'm09' => array(

				'1-5' => array(
					'eventName' => 'Schoolar bustards!',
					'musRange'  => '1/2',
					'soundRange'=> '2/5')
			),
			
			'm10' => array(
			
			),
			
			'm11' => array(
			
			),
			
			'm12' => array(
			
			)
		);
		
		private $monthNowArray;
		private $todaysEventArray;
	/* Arrays */
	
	/* Current Event */
		private $eventName = 'common';
		private $musRange = 'undefined';
		private $soundRange = 'undefined';
	/* Current Event */

	function __construct(){
		$dateExploded = explode ('.',CURRENT_DATE);
		$this->dayToday = $dateExploded[0];
		$this->monthToday = $dateExploded[1];
		$this->yearToday = $dateExploded[2];
		$this->selectCurrentEvent($this->dayToday, $this->monthToday);
		$this->answer();
		if(!file_exists($this->filePath)){
			$this->WriteFile();
		} else {
			if(is_array($this->readEventFile())){
				$this->eventsArray = $this->readEventFile();
			}
		}
	}

	function selectCurrentEvent($dayToday, $monthToday){

			function checkPeriod($key, $value, $dayToday){
				if(strpos($key,'-')){
					$datePeriod = explode('-',$key);
					$dayFrom = $datePeriod[0];
					$dayTill = $datePeriod[1];
					if($dayToday >= $dayFrom && $dayToday <= $dayTill){
						return $value;
					}
				} else {
					if($dayToday == $key){
						return $value;
					}
				}		
			}

		foreach ($this->eventsArray as $key => $value) {
			if('m'.$monthToday == $key){
			$this->monthNowArray = $value;
				foreach ($this->monthNowArray as $key => $value){
					$this->todaysEventArray = checkPeriod($key, $value, $dayToday);
					if(is_array($this->todaysEventArray)) {
						$this->eventName = $this->todaysEventArray['eventName'];
						$this->soundRange = $this->todaysEventArray['soundRange'];
						$this->musRange = $this->todaysEventArray['musRange'];
					} else {
						$this->eventName = 'common';
					}
				}
			}
		}
	}
	
	private function answer(){
		echo '<h3>Today is - '.$this->dayToday.'/'.$this->monthToday.'</h3>';
		echo '<b>Event Today: </b>'.$this->eventName.'<br>
			  <b>MusRange: </b>'.$this->musRange.'<br>
			  <b>SoundRange: </b>'.$this->soundRange;
	}
	
	private function readEventFile(){
		$data = file_get_contents($this->filePath);
		$out = unserialize($data);
		return $out;
	}
	
	private function WriteFile(){
		$data = serialize($this->eventsArray);
		file_put_contents($this->filePath, $data);
	}
}
