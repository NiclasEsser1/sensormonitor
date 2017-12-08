<?php

/* This class parses the Data depending on the users input,
 * in order to overhand the data to js
 *
 */

class ParseArray {

	/**
	 * function to limit the array for
	 * the chartdata of the selected
	 * sensornode depending on timestep.
         *
	 * @param array[] $array which should minimize
	 * @param integer $newsize length of returned array
	 * @param string  $parameter which the user selected
	 * @return array[] returns a new array with the length of $newsize
	 */

	public function minimizeArray($array, $newsize, $parameter) {

		$avg 			= array();
		$datetime 		= array();
		$oldsize 		= count($array);
		$avgdistance 	= intval(($oldsize / $newsize) + 0.5);
		if($oldsize > $newsize) {
			$cnt = 0;
			for($i = 0; $i < $newsize; $i++){
				$total = 0;
				for($k = $cnt; $k < $cnt+$avgdistance; $k++) {
					$total 	+= $array[$k][$parameter];
				}
        if( $array[$cnt]['datetime'] == true ){
  				$datetime[$i] 	= $array[$cnt]['datetime'];
  				$cnt 			+= $avgdistance;
  				$avg[$i] 		= $total/$avgdistance;
        } else {
          $i = $newsize;
        }
			}

		} else {
			for($k = 0; $k < $oldsize; $k++) {
				$avg[$k] 		= $array[$k][$parameter];
				$datetime[$k] 	= $array[$k]['datetime'];
			}
		}
		return array (
			$parameter	=> $avg,
			'datetime' 	=> $datetime
		);

	}

  // public function parseDate($array) {
  //   $arraysize = count($array['datetime']);
  //   $firstdate = new DateTime($array['datetime'][0]);
  //   $lastdate = new DateTime($array['datetime'][$arraysize-1]);
	//
  //   $datediff = $lastdate->diff($firstdate);
	// 	print_r($array);
	// 	print_r($firstdate);
	// 	print_r($lastdate);
  //  	print_r($datediff);
  //   if($datediff->d >=7 && $datediff->m < 1){
	//
  //     foreach($array['datetime'] as $formatdate){
  //       echo date_format($formatdate, 'm-d');
	//
  //     }
  //   }
  //   // print_r($array);
  //   return $array;
  // }
}
