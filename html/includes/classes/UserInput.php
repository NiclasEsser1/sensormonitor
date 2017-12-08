<?php
//__________This class parse the usersinput UI__________

class UserInput{
	
	var $variables = array();
	
	/**
	 * constructer
	 *   @param: $posted_variables alias of the global $_POST
	 */
	 
	public function __construct($posted_variables) {
		
		try {
			if(is_array($posted_variables) && isset($posted_variables)) {
				$this->variables = $posted_variables;
			} else {
				throw new Exception('Post is empty'.var_dump($variables));
			}
		} 
		catch(Exception $ex){
			echo $ex->getTraceAsString();
		}
	}
	
	/**
	 * get Nodes from UsersInput
	 * $location = Node[i]
	 */
	 
	public function getNode() {
		
		$location = isset($this->variables['location'])?$this->variables['location']:"FIELD EMPTY";											//load the inputs of user to a variable as an array
		return $location;
	}
	
	/**
	 * get Nodes from UI
	 * $parameter = Temperature, Humidty, Pressure 
	 */
	 
	public function getParam() {
		
		$parameter = isset($this->variables['parameter'])?$this->variables['parameter']:"FIELD EMPTY";
		return $parameter;
	}
	
	/**
	 * get Nodes from UI
	 * $start = 'YYYY-mm-DD hh:ii:ss < $end
	 */
	 
	public function getStartdate() {
		
		$start = isset($this->variables['datetimestart'])?$this->variables['datetimestart']:"FIELD EMPTY";
		return $start;
	}
	
	/**
	 * get Nodes from UI
	 * $end = 'YYYY-mm-DD hh:ii:ss
	 */
	public function getEnddate() {
		
		$end = isset($this->variables['datetimeend'])?$this->variables['datetimeend']:"FIELD EMPTY";
		return $end;
	}
}
