<?php

class Validation
{	
	public $validationPassed = true;
	public $data = [];
	public $errorInfo = [];
	public $spesialConditions = [
		'unique',
	];

	public function min($fieldName, $rules, $value)
	{
		if($rules > strlen($value)) {
			$this->validationPassed = false;
			$this->errorInfo[$fieldName][] = 'mast be at list ' . $rules . ' sumbols';
		}
	}
	
	public function max($fieldName, $rules, $value)
	{	
		if($rules < strlen($value)) {
			$this->validationPassed = false;
			$this->errorInfo[$fieldName][] = 'mast maximum ' . $rules . ' sumbols';
		}
	}
	
	public function matches($fieldName, $rules, $value)
	{
		if(array_key_exists($rules, $this->data)) {
			if($this->data[$rules] != $this->data[$fieldName]) {
				$this->validationPassed = false;
				$this->errorInfo[$fieldName][] = 'fields are not equal';
			}
		}
	}
	
	public function email($fieldName, $rules, $value)
	{
		if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->validationPassed = false;
			$this->errorInfo[$fieldName][] = 'wrong email';
		}
	}
	
	public function required($fieldName, $rules, $value)
	{
		if($rules) {
			if($value == '') {
				$this->validationPassed = false;
				$this->errorInfo[$fieldName][] = 'can\'t be empty';
			}
		}
	}
	
	public function intiger($fieldName, $rules, $value)
	{
		if($rules) {
			if(!is_numeric($value)) {
				$this->validationPassed = false;
				$this->errorInfo[$fieldName][] = 'mast be number';
			}
		}
	}
	
	public function unique($model, $fieldName, $rules, $value)
	{
		$condition[$fieldName] = ['=', $value];
		
		if($rules) {
			if($model->find($condition)) {
				$this->validationPassed = false;
				$this->errorInfo[$fieldName][] = 'this text already exists';
			}
		}
	}
}
