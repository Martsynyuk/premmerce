<?php

class Helper
{
	public static function showErrors($field, $error)
	{
		if(array_key_exists($field, $error)) {
			$errorBlock = '';
			foreach($error[$field] as $value) {
				$errorBlock .= $value . '</br>';
			}
			echo '<div class="error">' . $errorBlock . '</div>';
		}
	}
	
	public static function showText($field, $informations)
	{
		if(array_key_exists($field, $informations)) {
			echo $informations[$field];
		}
	}
}