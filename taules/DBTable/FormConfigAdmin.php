<?php
////////////////////////////////////////////////////////////////////////////////
if (!defined('UPPER_NO_TILDE')) define('UPPER_NO_TILDE',false);
$TABLE = "config";
$FILTRE = "";
////////////////////////////////////////////////////////////////////////////////
$query = "SELECT 
config_id AS idR , 
config_var AS config_var,
config_descripcio AS config_descripcio,
config_val AS config_val
FROM $TABLE
ORDER BY config_descripcio
";
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
$EDITABLE="true";

if (isset($_POST["edit_id"]))
{
	require_once("DBTable.php");
	$gestor=new DBTable($query);

//if ($_POST["edit_col"]!="Valor") return;
	$camp=$TABLE."__".$_POST["edit_col"]."__".$_POST["edit_id"];
	/*
	echo $_POST["val"];
	echo "<br/>";
	echo $_POST["be"];
	echo "<br/>";
	echo $_POST["edit_id"];
	echo "<br/>";
	echo $_POST["edit_col"];
	echo "<br/>";
	
	echo $camp;
	echo "<br/>";
	*/
	echo $gestor->updateValor($camp,$_POST["val"]);
	die();
}
include("Llistat.php");
?>