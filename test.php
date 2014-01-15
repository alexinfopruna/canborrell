<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
define('HEADERS',"header");

define('ROOT',"taules/");
require_once (ROOT."gestor_reserves.php");
/**/
$gestor=new gestor_reserves();




$a= $gestor->refresh();
//while (true){}
if (substr($a,0,9)!="no_change")
{
  $time = date('r');
  echo "data: The server time iiiiis: {$time}$a\n\n";
  
}  
else  echo $_SESSION['data']."\n\n";


flush();

?>