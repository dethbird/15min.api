<?php
require_once("models/Program.php");
require_once("House/Service/BaseService.php");

class ProgramService extends BaseService
{

    /**
    * Find the content that should be playing right now
    */
    public function nowPlaying()
    {

        $programs = Program::find_by_sql('SELECT * FROM `programs` WHERE timeslot < '. time() .' LIMIT 1');

        if(count($programs)<1){
            $this->response->addError("programs.find.no_results");
        } else {
            $this->response->setData($this->resultsToArray($programs));
        }
        return $this->response;
    }
	
    public function find($criteria = array())
    {

        $conditionString = "1 = 1";
        $conditionBindings = array();
        if(isset($criteria['id'])){
            $conditionString .= " AND id = ?";
            $conditionBindings[] = $criteria['id'];
        }

    	$programs = Program::find('all', array(
            'order' => 'timeslot asc',
            'conditions' => array_merge(array($conditionString), $conditionBindings)
        ));

    	if(count($programs)<1){
    		$this->response->addError("programs.find.no_results");
    	} else {
    		$this->response->setData($this->resultsToArray($programs));
    	}
    	return $this->response;
    }
}
