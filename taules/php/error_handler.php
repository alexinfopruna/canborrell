<?php
	function error_handler($errno, $errstr, $errfile, $errline, $errctx) {
	   echo "($errfile > $errline): $errno = $errstr".PHP_EOL."<BR/>\n";
	}

	set_error_handler("error_handler");
	ini_set ('error_reporting', E_ALL);
	error_reporting(E_ALL);  
?>