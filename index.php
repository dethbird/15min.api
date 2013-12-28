<?php

	/** Bootstrap the application */
	require 'vendor/autoload.php';
	require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';

	ActiveRecord\Config::initialize(function($cfg)
 	{
 		$cfg->set_model_directory('models');
 		$cfg->set_connections(array('production' =>
 		'mysql://root:P1zzaP4rty@localhost/15min?charset=utf8'));
 	});

	$app = new \Slim\Slim();

	/** ROUTES */
	$app->get('/hello/:name', function ($name) {
    		echo "Hello, $name";
	});

	/** RUN THE APP */
	$app->run();
?>
