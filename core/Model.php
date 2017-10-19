<?php
/**
* Model de base de l'application
**/
class Model{

	/**
	* $connection sauverger les configurations
	**/
	static $connection = array();

	/**
	* $table table par défaut de l'application
	**/
	public $table = false;

	/**
	* $db sauvegarder les connections
	**/
	public $db;

	/**
	* $conf récupère les configuration par défaut
	**/
	public $conf = 'default';

	/**
	* $conf récupère les configuration par défaut
	**/
	public $primaryKey = 'id';

	/**
	* Clé primaire de la table
	**/
	public $id;

	/**
	* Erreur de validation du formulaire
	**/
	public $errors = array();

	/**
	* Formulaire qui correspond a un model
	**/
	public $form;

	public function __construct(){
		$conf = Config::$databases[$this->conf];
		//Initialisation des variables
		if ($this->table === false) {
			$this->table = strtolower(get_class($this)) . 's';
		}

		//Je me connecte à la base
		if (isset(Model::$connection[$this->conf])) {
			$this->db = Model::$connection[$this->conf];
			return true;
		}
		try {
			$pdo = new PDO('mysql:host='.$conf['host']. 
				';dbname=' .$conf['database']. ';', 
				$conf['login'], 
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			Model::$connection[$this->conf] = $pdo;
			$this->db = $pdo;
		} catch (PDOException $e) {
			if (Config::$debug >= 1) {
				die($e->getMessage());
			}else{
				die("Impossible de se connecter à la base de donneé");
			}
		}

	}

	public function find($req){
		$sql = 'SELECT ';

		if (isset($req['fields'])) {
			if (is_array($req['fields'])) {
				$sql .= implode(', ', $req['fields']);
			}else{
				$sql .= $req['fields'];
			}
		}else{
			$sql .= '*';
		}

		$sql .= ' FROM ' . $this->table. ' as ' .get_class($this). ' '; 

		//Construction de la condition
		if (isset($req['conditions'])) {
			$sql .= 'WHERE ';
			if (!is_array($req['conditions'])) {
				$sql .= $req['conditions'];
			}else{
				$cond = array();
				foreach ($req['conditions'] as $k => $v) {
					if (!is_numeric($v)) {
						$v = '"'.mysql_real_escape_string($v).'"';
					}
					$cond[] = "$k=$v";
				}
				$sql .= implode(' AND ', $cond);
			}
		}

		if (isset($req['limit'])) {
			$sql .= 'LIMIT ' .$req['limit'];
		}

		$pre = $this->db->prepare($sql);
		$pre->execute();
		return $pre->fetchAll(PDO::FETCH_OBJ);
	}

	public function findFirst($req){
		return current($this->find($req));
	}

	public function findCount($conditions){
		$res = $this->findFirst(array(
			'fields' => 'COUNT('.$this->primaryKey.') as count',
			'conditions' => $conditions
		));
		return $res->count;
	}

	public function delete($id){
		$sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = $id";
		$this->db->query($sql);
	}

	public function save($data){
		$key = $this->primaryKey;
		$fields = array();
		$d = array();
		foreach ($data as $k => $v) {
			if ($k!= $this->primaryKey) {
				$fields[] = "$k=:$k";
				$d[":$k"] = $v;
			}elseif(!empty($v)){
				$d[":$k"] = $v;
			}
		}
		if (isset($data->$key) && !empty($data->$key)) {
			$sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE ' .$key.'=:'.$key;
			$this->id = $data->$key;
			$action = 'update';
		}else{
			$sql = 'INSERT INTO ' .$this->table.' SET '.implode(',',$fields);
			$action = 'insert';
		}
		$pre = $this->db->prepare($sql);
		$pre->execute($d);
		if ($action = 'insert') {
			$this->id = $this->db->lastInsertId();
		}
		return true;
	}

	
}