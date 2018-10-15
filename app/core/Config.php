<?php

abstract class Config
{
	public static $config;
	public static function set($settings = [])
	{
		if(is_array($settings)) {
			self::$config = $settings;
		}
	}
	public static function get($path = null)
	{	
		if($path) {
			$config = self::$config;
			$path = explode('/', $path);
			
			foreach($path as $value) {
				if(isset($config[$value])) {
					$config = $config[$value];
				}
			}
			return $config;
		}
		return false;
	}	
}