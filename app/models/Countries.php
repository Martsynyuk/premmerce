<?php

class Countries extends Model
{
	public $tableName = 'countries';
	protected $validationRules = [
				'default' => [
				],
	];

    public function getCounties()
    {
        return$this->getAll($this->tableName);
    }
}