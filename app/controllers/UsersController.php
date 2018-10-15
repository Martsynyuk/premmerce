<?php

class UsersController extends Controller
{
	public $uses = [
		'Countries',
        'Users'
	];
	
	public function autorizationRules()
	{
		return [
			'deny' => [
				'users' => ['guest'],
				'actions' => [],
				'redirect' => '/user/login',
			],
		];	
	}

	public function actionCreate()
    {
        $this->set('action', 'create');
        $this->set('countries', $this->Countries->getCounties());

        if(!empty($_POST)) {
            if($this->Users->validate('validate', $_POST) && $this->Users->saveUser()) {
                Redirect::to('/users/index');
            } else {
                $this->set('error', $this->Users->getErrors());
            }
        }
    }

	public function actionUpdate($id)
	{
		if(!isset($id[0]) || !$this->Users->isUserExists($id[0])) {
			Redirect::to('/users/index');
		}
		
		$this->set('action', 'update');
		$this->set('user', $this->Users->getUser($id[0]), $this->getJoin($this->Countries, 'country', $this->Users,  'id', 'country_id'));
        $this->set('countries', $this->Countries->getCounties());
		
		if(!empty($_POST)) {
			if($this->Users->validate('validate', $_POST)) {
				$this->Users->saveUser($id[0]);
				Redirect::to('/users/index');
			} else {
				$this->set('user', $_POST);
				$this->set('error', $this->Users->getErrors());
			}
		} else {
			$this->Users->getUser($id[0], $this->getJoin($this->Countries, 'country', $this->Users,  'id', 'country_id'));
			$this->set('user', $this->Users->getFirstResult());
		}
	}

	public function actionIndex()
	{
		$this->set('users', $this->Users->getAllUsers(
		    $this->getJoin($this->Countries, 'country', $this->Users,  'id', 'country_id'))
        );
	}

	protected function getJoin($joinModel, $getField, $model, $condition, $joinCondition)
    {
	    $join = [
            'field' => $getField,
	        'table' => [
                'tableName' => $joinModel->tableName,
                'field' => $condition
            ],
            'condition' => [
                'tableName' => $model->tableName,
                'field' => $joinCondition
            ]
        ];
	    return $join;
    }

    public function actionDelete($id)
    {
        if(!isset($id[0]) || !$this->Users->isUserExists($id[0])) {
            Redirect::to('/users/index');
        }

        $this->Users->deleteUser($id[0]);
        Redirect::to('/users/index');
    }

	public function actionError($error = '404')
	{

	}
}