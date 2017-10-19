<?php 
/**
* Controller de base de l'application
**/
class Controller{

	/**
	* Recuperer les requetes
	**/
	public $request;

	/**
	* Permet de passer les variables à la vue
	**/
	public $vars = array();

	/**
	* Layout par defaut de l'application
	**/
	public $layout = 'default';

	/**
	* affiche une vue si elle n'est pas encore definie
	**/
	private $rendered = false;

	/**
	* Permet à récupéré la requette
	* @param $request est la requette
	**/
	function __construct($request = null){
		if ($request) {
			$this->request = $request;
			require ROOT.DS. 'config'.DS.'hook.php';
		}
	}

	/**
	* Permet à rendre la vue
	*@param $view nom de la vue
	**/
	public function render($view){
		if ($this->rendered) {return false;}
		extract($this->vars);
		if (strpos($view, '/')===0) {
			$view = ROOT.DS. 'view'. $view .'.php';
		}else{
			$view = ROOT.DS. 'view' .DS. $this->request->controller .DS. $view .'.php';
		}
		ob_start();
		require $view;
		$content_for_laout = ob_get_clean();
		require ROOT.DS. 'view' .DS. 'layout' .DS.$this->layout .'.php';
		$this->rendered = true;
	}

	/**
	* Permet à envoyé les parametre
	*@param $key la clé à passé
	*@param $value la valeur de la clé
	**/
	public function set($key, $value = null){
		if (is_array($key)) {
			$this->vars += $key;
		}else{
			$this->vars[$key] = $value;
		}
	}
	
	/**
	* Permet à chargé un model
	*@param $name le nom du model à passé
	**/
	public function loadModel($name){
		$file = ROOT.DS. 'model' .DS. $name. '.php';
		require_once($file);
		if (!isset($this->$name)) {
			$this->$name = new $name();
			if (isset($this->Form)) {
				$this->$name->Form = $this->Form;
			}
		}
	}

	/**
	* Affiche les erreurs 404
	*@param $message le message à passé
	**/
	public function e404($message){
		header("HTTP/1.0 404 Not Found");
		$this->set('message',$message);
		$this->render('/errors/404');
		die();
	}

	/**
	* Permet d'appeler un controller depuis une vue
	**/
	function request($controller, $action){
		$controller .= 'Controller';
		require_once ROOT.DS.'controller'.DS.$controller.'.php';
		$c = new $controller(); 
		return $c->$action();
	}

	function redirect($url,$code = null){
		if ($code == 301) {
			header("HTTP/1.1 301 Moved Permently");
		}
		header("Location: ".Rooter::url($url));
	}
}