<?php
	/**
	* 
	*    _____                                 __                
  	*   /  _  \ ______ ______     ______ _____/  |_ __ ________  
 	*  /  /_\  \\____ \\____ \   /  ___// __ \   __\  |  \____ \ 
	* /    |    \  |_> >  |_> >  \___ \\  ___/|  | |  |  /  |_> >
	* \____|__  /   __/|   __/  /____  >\___  >__| |____/|   __/ 
	*         \/|__|   |__|          \/     \/           |__|    
	*/
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	define("APPLICATION_PATH", __DIR__);
	date_default_timezone_set('America/Los_Angeles');

	// Ensure src/ is on include_path
	set_include_path(implode(PATH_SEPARATOR, array(
		__DIR__ ,
	    __DIR__ . '/src',
	    get_include_path(),
	)));

	/**
	* __________               __                                
	* \______   \ ____   _____/  |_  __________________  ______  
 	* |    |  _//  _ \ /  _ \   __\/  ___/\_  __ \__  \ \____ \ 
 	* |    |   (  <_> |  <_> )  |  \___ \  |  | \// __ \|  |_> >
 	* |______  /\____/ \____/|__| /____  > |__|  (____  /   __/ 
	*         \/                        \/             \/|__|    
	*/
	require 'vendor/autoload.php';
	require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';

	ActiveRecord\Config::initialize(function($cfg)
 	{
 		$cfg->set_model_directory('models');
 		$cfg->set_connections(array('development' =>
 		'mysql://root:P1zzaP4rty@localhost/15min?charset=utf8'));
 	});
 	global $user;
	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json'); //default response type

	/**
	* __________                   .__                       
	* \______   \ ____  ________ __|__|______   ____   ______
 	* |       _// __ \/ ____/  |  \  \_  __ \_/ __ \ /  ___/
 	* |    |   \  ___< <_|  |  |  /  ||  | \/\  ___/ \___ \ 
 	* |____|_  /\___  >__   |____/|__||__|    \___  >____  >
	*         \/     \/   |__|                     \/     \/ 	
	*/
	require_once('models/User.php');
	require_once('House/Service/UserService.php');


	/**
	* __________               __  .__                
	* \______   \ ____  __ ___/  |_|__| ____    ____  
 	* |       _//  _ \|  |  \   __\  |/    \  / ___\ 
 	* |    |   (  <_> )  |  /|  | |  |   |  \/ /_/  >
 	* |____|_  /\____/|____/ |__| |__|___|  /\___  / 
	*         \/                           \//_____/  	
	*/

	/**
	* Authentication should be run as middleware before each route
	*/
	$authenticate = function($app) 
	{
		return function () use ( $app ) 
		{
			global $user;
			
			$request = $app->request;
			$service = new UserService();
			$response = $service->findByApiKey($request->get('api_key'));

			if(!$response->isOk()){
				$app->response->setStatus(403);
				$app->stop();
			} else {
				$user = $response->getData();
			}
		};
	};

	$app->get('/hello/:name',  $authenticate($app), function ($name) {
		global $user;
    	echo "Hello, $name";
	});

	/**
	* Get all programs from now or timestamp
	* 
	* @param $unixtimestamp (optional) (default = now)
	* @return array //collection of programs
	*/
	$app->get('/programs/',  $authenticate($app), function ($unixtimestamp = null) {
		global $user;
		
    	//echo "Hello, $name";
	});

	/**
	* __________            ._._._.
	* \______   \__ __  ____| | | |
 	* |       _/  |  \/    \ | | |
 	* |    |   \  |  /   |  \|\|\|	
 	* |____|_  /____/|___|  /_____
	*        \/           \/\/\/\/	
	*/
	$app->run();
?>
