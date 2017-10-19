<?php 
/**
* Permet de traiter les requettes parsé par la requette (Objet Request)
**/
class Dispatcher{

	/**
	* $request variable d'instanciation de l'objet Request
	**/
	var $request;

	function __construct(){
		$this->request = new Request();
		Rooter::parse($this->request->url, $this->request);
		$controller = $this->loadController();
		//Prefix Admin
		$action = $this->request->action;
		if ($this->request->prefix) {
			$action = $this->request->prefix.'_'.$action;
		}
		/**
		* Vérification de l'existance d'une action spécifié
		* Si l'action n'existe pas on renvoie la réponse 404
		**/
		if (!in_array($action, array_diff(get_class_methods($controller), 
			get_class_methods("Controller")))) {
			$this->error("Le controller ". $this->request->controller. " n'a pas de méthode ". $action);
		}
		call_user_func_array(array($controller, $action), $this->request->params);
		$controller->render($action);
	}

	/**
	* Affiche les erreurs 404
	*@param $message le message à passé
	**/
	public function error($message){
		$controller = new Controller($this->request);
		$controller->Session = new Session();
		$controller->e404($message);
	}

	/**
	* Permet à chargé le controller dynamiquement
	**/
	function loadController(){
		$name = ucfirst($this->request->controller) . 'Controller';
		$file = ROOT.DS. 'controller' .DS. $name. '.php';
		require $file;
		$controller = new $name($this->request);
		$controller->Session = new Session();
		$controller->Form = new Form($controller);
		return $controller;
	}
}