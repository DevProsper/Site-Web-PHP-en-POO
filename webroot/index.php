<?php  
define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('CORE', ROOT. DS. 'core');
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));
require CORE.DS. 'includes.php';

new Dispatcher();

?>

<!-- <pre>
	<?php print_r($_SERVER) ?>
	<?php print_r(__FILE__) ?>
</pre> -->