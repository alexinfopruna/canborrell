<?php
define("ROOT", "../taules/");
define("READER_SCRIPT", "read.php?f=");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();   

if (!$gestor->valida_sessio(64))  
{
  header("Location: login.php");
  die();
}

$file=$_GET['f'];
if (isset($_GET['reset'])) $gestor->rename_big_file($file, 0);

$path_parts = pathinfo($file);
if  (strtolower($path_parts['extension']=='pdf')) header('Content-type: application/pdf'); 
else header('Content-Type: text/html; charset=utf-8');
?>
<html>
	<head>
		<style>
			.fila{padding:4px;}
			.even{}
			.odd{background:#EEF}
			.margin{border-top:#444 dotted 2px;font-weight:bold;color:red;}
		</style>
	</head>
	<body>
<?php
echo "Llegim fitxer: <b>$file</b><br/><br/><div>";
//readfile($file);
//$my_file = file_get_contents($file);

//echo $my_file;
//echo ln2br($my_file);
$parodd=false;
$cnt=0;
$file_handle = fopen($file, "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   $cnt++;
	
	//if (strlen($line)<5) {$margin="margin";$parodd=!$parodd;continue;}
if (strstr($line,'/* >>>')!==FALSE) {$margin="margin";$parodd=!$parodd;}
	//echo '<br/>--------'.$line;
	$margin="";
	/*	*/
	$line=str_replace('/* >>>', '</div><div class="fila margin'.($parodd?' even':' odd').'">/* >>>', $line);
	$line=str_replace('<<< */', '<<< */</div><div class="fila '.($parodd?' even':' odd').'">', $line);
   echo $line;
	if ($cnt>500) 
	{
		$cnt=0;
		flush();
	}
}
fclose($file_handle);
?>
	</body>
</html>