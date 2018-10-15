<?php
session_start();

$settings = [
	'database' => [
		'driver' => 'MySQL',
		'host' => '127.0.0.1',
		'dbname' => 'premmerce',
		'user' => 'root',
		'password' => ''
	],
	'router' => [
		'defaultController' => 'Users',
		'defaultAction' => 'index',
		'defaultErrorAction' => 'error'
	],
	'md5' => [
		'salt' => 'test',
	],
];

spl_autoload_register(function($file) {
	$paths = [
			'app/core/',
			'app/interfaces/',
			'app/models/',
			'app/controllers/'
	];

	foreach ($paths as $path)
	{
		if(file_exists($path . $file . '.php')) {
			require_once($path . $file . '.php');
		}
	}
});

Config::set($settings);

