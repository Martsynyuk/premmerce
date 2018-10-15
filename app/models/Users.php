<?php

class Users extends Model
{
	public $tableName = 'users';
	protected $validationRules = [
		'validate' => [
			'name' => [
				'min' => 2,
				'max' => 16,
				'required' => true,
			],
			'email' => [
                'max' => 200,
				'email' => true,
				'required' => true,
			],
            'country_id' => [
                'required' => true,
            ]
		],
	];
	
	public function saveUser($id = false)
	{
        $where = [];
        if($id) {
            $where = ['id' => ['=', $id]];
        };
        return $this->save([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'country_id' => $_POST['country_id'],
        ], $where);
	}

	public function getAllUsers($join = [])
    {
        return $this->getAll($this->tableName, $join);
    }

	public function getUser($id, $join = [])
    {
        return $this->find(['id' => ['=', $id]], $join);
    }

    public function deleteUser($id)
    {
        $this->deleteRecord(['id' => ['=', $id]]);
    }

    public function isUserExists($id)
    {
        $user = $this->getUser($id);

        if (!empty($user)) {
            return true;
        }

        return false;
    }
}