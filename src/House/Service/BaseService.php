<?php
require_once("House/Service/Response/ServiceResponse.php");

class BaseService
{
	/**
	*
	*/
	protected $response;

    public function __construct()
    {
    	$this->response = new ServiceResponse();
    }

    public function prepareResponse(ServiceResponse $response = null){
    	return is_null($response) ? json_encode($this->response) : json_encode($response);
    }
}
