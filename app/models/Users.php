<?php

class Users extends Model
{
	public $tableName = 'users';
	protected $validationRules = [
		'validate' => [
			'username' => [
				'min' => 2,
				'max' => 16,
				'required' => true,
			],
			'email' => [
				'email' => true,
				'required' => true,
			],
            'country_id' => [
            ]
		],
	];
	
	public function saveUser($data)
	{	
		return $this->save([
			'username' => $data['username'],
			'email' => $data['email'],
			'country_id' => $data['country_id']
		]);
	}

	public function getAllUsers($join = []) {
        return $this->getAll($this->tableName, $join);
    }

	public function getUser($id, $join = []) {
        return $this->find(['id' => ['=', $id]], $join);
    }

	public function updateUser($data) {

    }

    public function deleteUser($data) {

    }
}