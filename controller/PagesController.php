<?php 

class PagesController extends Controller{

	function view($id){
		$this->loadModel('Post');
		$d['page'] = $this->Post->findFirst(array(
			'conditions' => array('online'=> 1, 'id'=>$id,'type'=>'page')	
		));
		if (empty($d['page'])) {
			$this->e404("Page Introuvable");
		}
		$this->set($d);
		$this->render('view');
	}

	/**
	* Permet de récupérer les pages pour le menu
	**/
	function getMenu(){
		$this->loadModel('Post');
		return $this->Post->find(array(
			'conditions' => array('online'=> 1,'type'=>'page')	
		));
	}
}