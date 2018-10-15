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

	public function actionCreate() {
        $this->set('action', 'create');

        if(!empty($_POST)) {
            if($this->Users->validate('validate', $_POST) && $this->Users->savePost()) {
                Redirect::to('/users/index');
            } else {
                $this->set('error', $this->Users->getErrors());
            }
        }
    }

	public function actionUpdate($id)
	{
		if(!isset($id[0])) {
			Redirect::to('/users/index');
		}
		
		$this->set('action', 'update');
		$this->set('id', $id[0]);
		
		if(!empty($_POST)) {
			if($this->Users->validate('validate', $_POST) && !empty($this->Users->isUserPost($id[0]))) {
				$this->Users->saveUser($id[0]);
				Redirect::to('/post/index');
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

	protected function getJoin($joinModel, $getField, $model, $condition, $joinCondition) {
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

	///////
	
	public function actionDelete($id)
	{
		if($this->Post->isUserPost($id[0])) {
			$this->Post->deletePost($id[0]);
			Redirect::to('/post/my');
		} else {
			Redirect::to('/user/logout');
		}
	}

	public function actionError($error = '404')
	{

	}
}