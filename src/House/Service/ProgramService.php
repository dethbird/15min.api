<?php
require_once("models/Program.php");
require_once("House/Service/BaseService.php");

class ProgramService extends BaseService
{
	
    public function find($criteria)
    {
    	$programs = Program::find('all');

    	if(count($programs)<1){
    		$this->response->addError("programs.find.no_results");
    	} else {
    		$this->response->setData($this->resultsToArray($programs));
    	}
    	return $this->response;
    }
}
