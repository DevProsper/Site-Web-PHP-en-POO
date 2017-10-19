<?php 

class PostsController extends Controller{

	function index(){
		$perPage = 2;
		$this->loadModel('Post');
		$conditions = array('online'=> 1,'type'=>'post');
		$d['posts'] = $this->Post->find(array(
			'conditions' => $conditions,
			'limit'		 => ($perPage*($this->request->page-1)).','.$perPage
		));
		$d['total'] = $this->Post->findCount($conditions);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	function view($id,$slug){
		$this->loadModel('Post');
		$conditions = array('online'=> 1, 'id'=>$id,'type'=>'post');
		$fields = 'id,content,name,slug';
		$d['post'] = $this->Post->findFirst(array(
			'fields'	 => $fields,
			'conditions' => $conditions
		));
		if (empty($d['post'])) {
			$this->e404("Page Introuvable");
		}
		if ($slug != $d['post']->slug) {
			$this->redirect("posts/view/id:$id/slug:". $d['post']->slug, 301);
		}
		$this->set($d);
	}

	function admin_index(){
		$perPage = 10;
		$this->loadModel('Post');
		$conditions = array('type'=>'post');
		$d['posts'] = $this->Post->find(array(
			'fields' => 'id,name,online',
			'conditions' => $conditions,
			'limit'		 => ($perPage*($this->request->page-1)).','.$perPage
		));
		$d['total'] = $this->Post->findCount($conditions);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	function admin_delete($id){
		$this->loadModel('Post');
		$this->Post->delete($id);
		$this->Session->setFlash("Le post a bien été supprimé - ".$id);
		$this->redirect('admin/posts/index');
	}

	public function admin_edit($id = null){
		$this->loadModel('Post');
		$d['id'] = '';
		if ($this->request->data) {
			if ($this->Post->validates($this->request->data)) {
				$this->request->data->type = 'post';
				$this->request->data->created = date('Y-m-d h:m:s');
				$this->Post->save($this->request->data);
				$this->Session->setFlash("Le post a bien été modifié - ".$id);
				$id = $this->Post->id;
				$this->redirect("admin/posts/index");
			}else{
				$this->Session->setFlash("Erreur lors de la modification - ".$id, 'danger');
			}
		}else{
			if ($id) {
				$this->request->data = $this->Post->findFirst(array(
				'conditions' => array('id' => $id)));
				$d['id'] = $id;
			}
		}
		$this->set($d);
	}
}