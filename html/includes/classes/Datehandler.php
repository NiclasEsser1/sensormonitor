<?php

//______ This class is used to parse, handle or calculate Dates____

class Datehandler {
	
	public $dateObject;
	
	public function __construct(DateTime $dateObject) {
		$this -> dateObject = $dateObject;
	}
		
	public function substractDate($substring, $format = 'Y-m-d H:i:s'){
		$subdate 	= new DateInterval($substring);
		$date 		= $this -> dateObject ->sub($subdate);
		$date 		= $this -> dateObject ->format($format);
		return $date;
	}
	public function onlyFormat($format) {
		$date 		= $this -> dateObject ->format($format);
		return $date;
	}
}