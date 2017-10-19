<?php

class Request{

	public $url; //URL tapé par l'utilisateur
	public $page = 1; //affiche le nombre de page de la paginnation
	public $prefix = false;
	public $data = false;

	function __construct(){
		//récupère l'url tapé par l'utilisateur
		$this->url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

		//Gestion de paginnation
		if (isset($_GET['page'])) {
			if (is_numeric($_GET['page'])) {
				if ($_GET['page'] > 0) {
					$this->page = round($_GET['page']);
				}
			}
		}
		if (!empty($_POST)) {
			$this->data = new stdClass();
			foreach ($_POST as $k => $v) {
				$this->data->$k=$v;
			}
		}
	}
}