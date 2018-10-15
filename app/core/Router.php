<?php

class Router
{
	private $defaultController;
	private $defaultAction;
	private $defaultErrorAction;
	private $controller = null;
	private $action = null;
	private $params = [];
	
	public function __construct()
	{	
		$this->defaultController = Config::get('router/defaultController');
		$this->defaultAction = Config::get('router/defaultAction');
		$this->defaultErrorAction = Config::get('router/defaultErrorAction');
		$this->urlParser();
	}
	
	public function run()
	{
		if(class_exists($this->controller . 'Controller')) {
			$controller = $this->controller . 'Controller';
			$controller = new $controller($this->controller, $this->action, $this->params);
			
			if(method_exists($controller, 'action' . ucfirst($this->action))) {
				$action = 'action' . ucfirst($this->action);
				$controller->$action($this->params);
				$controller->display($this->action, $controller->layout);
			} else {
				$this->error('404');
			}
		} else {
			$this->error('404');
		}
	}
	private function urlParser()
	{
		$url = explode('/', trim($_SERVER ['REQUEST_URI'], '/'));
		
		$this->controller = $this->defaultController;
		$this->action = $this->defaultAction;
		
		if(count($url) == 1 && $url[0] != '') {
			list($this->controller) = $url;
		} elseif(count($url) >= 2) {
			list($this->controller, $this->action) = $url;
			$this->params = array_slice($url, 2);
		}	
		$this->run();
	}
	
	private function error($error)
	{
		$controller = $this->defaultController . 'Controller';
		$action = 'action' . ucfirst($this->defaultErrorAction);
		$controller = new $controller($this->defaultController, $action);
		$controller->$action($error);
		$controller->display($this->defaultErrorAction, $controller->layout);
	}
}