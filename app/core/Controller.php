<?php

class Controller 
{
	private $view;
	public $layout = 'main';
	public $uses = [];
	public $params = [];
	protected $autorization = [];
	
	public function __construct($controller, $action, $params = [])
	{	
		$this->autorization = $this->autorizationRules();
		//$this->beforeAction($action);
		$this->params = $params;
		$this->view = new View($controller);		
		$this->setModels($controller);
	}
	
	public function beforeAction($action)
	{
		if(!empty($this->autorization)) {
			foreach($this->autorization as $key => $value) {
				if($key == 'deny') {
					if(Users::isLoggetIn()) {
						if(in_array('Users', $value['users']) && in_array($action, $value['actions'])) {
							Redirect::to($value['redirect']);
						}
					} else {
						if(in_array('guest', $value['users']) && in_array($action, $value['actions'])) {
							Redirect::to($value['redirect']);
						}
					}
				}
			}
		}
	}
	
	public function setModels($controller)
	{
		if(empty($this->uses)) {
			$controllers = $controller;
			$this->$controllers = new $controllers();
		} else {
			foreach($this->uses as $className)
			{
				if(class_exists($className)) {
					$this->$className = new $className();
				}
			}	
		}
	}
	
	public function set($name, $value)
	{
		$this->view->set($name, $value);
	}
	
	public function display($template, $layout)
	{
		$this->view->render($template, $layout);
	}

}