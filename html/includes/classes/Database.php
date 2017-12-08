<?php

//______ This class is used to recieve the data from the database depending on the users input____

class Database {
	public $pdo;
	/**
	 * constructer
	 * @param PDO $pdo 
	 */
	 
	function __construct(PDO $pdo) {
		
		$this->pdo = $pdo;
	}
	
	/**
	 * function to query the database for
	 * the chchartdataartdata of the selected 
	 * sensornode depending on timestep
	 *    @param: $nodeId = Node[i] 
	 *    @param: $datetimestart = select start time of User
	 *    @param: $datetimeend = select end time of User
	 */
	 
	public function getChartData($nodeId, $datetimestart, $datetimeend) {
					
		$values = array(
			':nodeId'        => $nodeId,
			':datetimestart' => $datetimestart, 
			':datetimeend'   => $datetimeend
		);
		
		$sql = "SELECT * FROM measurement 
			WHERE nodeId = :nodeId 
			AND datetime BETWEEN :datetimestart 
			AND :datetimeend";		
			
		$data = $this->queryDatabase($sql, $values);
		return $data;
	}
	
	/**
	 * function to query the database for
	 * max and min-values of the selected 
	 * sensornode depending on timestep
	 *   @param: $nodeId = Node[i]
	 *   @param: $datetimestart = select start time of User
	 *   @param: $datetimeend = select end time of User 
	 */ 
	public function getMaxMin($nodeId, $datetimestart, $datetimeend) {
		
		$paramarray = array(
			'temperature', 
			'humidity', 
			'pressure'
		);
		
		$datearray  = array(
			'tdate', 
			'hdate', 
			'pdate'
		);
		
		for($i = 0; $i < 3; $i++) { 
			$values = array(
				':nodeId'        => $nodeId,
				':datetimestart' => $datetimestart, 
				':datetimeend'   => $datetimeend
			);
			
			$sqlmax = "SELECT 
				MAX($paramarray[$i]) as '$paramarray[$i]', 
				datetime as '$datearray[$i]'
				FROM measurement
				WHERE nodeId =:nodeId
				AND datetime BETWEEN :datetimestart 
				AND :datetimeend"; 
			
			$sqlmin = "SELECT 
				MIN($paramarray[$i]) as '$paramarray[$i]', 
				datetime as '$datearray[$i]'
				FROM measurement
				WHERE nodeId =:nodeId
				AND datetime BETWEEN :datetimestart 
				AND :datetimeend";
					
			$max = $this->queryDatabase($sqlmax, $values);
			$min = $this->queryDatabase($sqlmin, $values);
			$maxarray[$paramarray[$i]] = $max[0];
			$minarray[$paramarray[$i]] = $min[0];
			$data = array(
				'max' => $maxarray,
				'min' => $minarray
			);
		}
		return $data;
	}
		
	/**
	 * function to query the database for
	 * the currentdata of the selected 
	 * sensornode depending on timestep.
	 *   @param: $nodeId = Node[i]
	 */
	 
	public function getCurrentData($nodeId) {
		
		$dateObject = new Datehandler(new DateTime(date('Y-m-d H:i:s')));
		$subDate 	= $dateObject->substractDate('PT1M');
		
		$values = array(
			':nodeId' 	=> $nodeId,
			':date' 	=> $subDate
			);
		
		$sql = "SELECT MAX(ID) as ID, 
			temperature, humidity, pressure, voltage, datetime
			FROM measurement
			WHERE nodeId = :nodeId
			AND datetime >= :date";
					
		$data = $this->queryDatabase($sql, $values);
		$data = array('current' => $data[0]);
		return $data;
	}
	
	/**
	 * function to query the database for
	 * the average Data of the selected 
	 * sensornode
	 *    @param: $nodeId = Node[i]
	 */
	 
	public function getAvgDay($nodeId) {
		
		$dateObject = new Datehandler(new DateTime(date('Y-m-d')));
		$date1 		= $dateObject -> onlyFormat('Y-m-d 23:59:59');
		$date2 		= $dateObject -> substractDate('P1D', 'Y-m-d 23:59:59');
		
		$i = 1;
		while($i < 5 ){
			// echo("start: ");
			// print_r($date1);
			// echo("\n");
			// echo("end: ");
			// print_r($date2);
			// echo("\n");
			$values = array(
				':nodeId'       => $nodeId,
				':date1'		=> $date1,
				':date2'		=> $date2,
			);

			$sql = "SELECT 
				ROUND(AVG(temperature), 2) AS temperature,
				ROUND(AVG(humidity), 2) AS humidity,
				ROUND(AVG(pressure), 1) AS pressure
				FROM measurement 
				WHERE nodeId = :nodeId 
				AND datetime > :date2
				AND datetime < :date1";

			$data[] = $this->queryDatabase($sql, $values);
			$date1 = $date2;
			$date2 = $dateObject->substractDate('P1D', 'Y-m-d 23:59:59');
			$i++;
		}
		
		$data = array(
			'today' => $data[0][0],
			'yday'	=> $data[1][0], 
			'yyday'	=> $data[2][0],
			'yyyday'=> $data[3][0]
		);
		return $data;
	}
	/**
	 * function to query the database for
	 * the currentdata of the selected 
	 * sensornode depending on timestep.
	 *   returns the number of different nodes in database
	 */
	 
	public function getNumberOfNodes(){
		
		$sql = "SELECT COUNT(DISTINCT nodeId) 
				AS numbernode
				FROM measurement";
				
		$numberArray = $this->queryDatabase($sql);
		$numberNodes = $numberArray[0];
		$number = $numberNodes['numbernode'];
		return $number;
	}
	
	/**
	 * *private* function in class, which prepares
	 * SQL-statments and execute them depending on values
	 *	 @param: $sqlstmt different querys for DB
	 *   @param: $values needed for the execution of the SQL-statement
	 */
	
	private function queryDatabase($sqlstmt, $values = array()) {
		
		$rows 	= array();
		$sth 	= $this->pdo->prepare($sqlstmt);
		$sth	-> execute($values);
		while($result = $sth->fetchAll(PDO::FETCH_ASSOC)) {
			$rows = $result;
		}
		return $rows;
	}
	
}
