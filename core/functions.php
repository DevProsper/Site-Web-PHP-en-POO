<?php 

function debug($var){
	$debug = debug_backtrace();
	echo '<a href="#"><strong>' .$debug[0]['file']. ' </strong> 1.' .$debug[0]['line'] . '</a>';

	echo "<ol>";
	foreach ($debug as $k => $v)if($k>0) {{
		//echo '<li><strong>' .$v['file']. ' </strong> 1.' .$v['line'] . '</li>';
	}}
	echo "</ol>";
	echo "<prev>";
	print_r($var);
	echo "</prev>";
}