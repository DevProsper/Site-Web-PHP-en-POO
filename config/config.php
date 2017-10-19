<?php 
/**
* Configuration de base de l'âpplication
**/
 class Config{
 	/**
 	* $debug  affichage des erreurs
 	**/
 	static $debug = 1;

 	/**
 	* $databases configuration de la base de donnée
 	**/
 	static $databases = array(
	 	'default'	=>	array(
	 		'host'		=>	'localhost',
	 		'database'	=>	'test',
	 		'login'		=> 	'root',
	 		'password'	=> 	''
	 	)
	 );
}
Rooter::prefix('cockpit', 'admin');
Rooter::connect('/', 'posts/index');
Rooter::connect('posts/:slug-:id', 'posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Rooter::connect('blog/:action','posts/:action');
