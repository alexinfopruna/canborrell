<?php
/*******************************************************************/
// IDENTIFICA SERVIDOR I CONFIGURA DADES DE CONNEXIO SEGONS EL CAS
/*******************************************************************/
defined('AMF') or define('AMF', 'false');

//ini_set("zlib.output_compression", "On");
//ini_set("zlib.output_compression_level", 9);

switch ($_SERVER['HTTP_HOST'])
{
	case "127.0.0.1":
	case "cb.localhost":
	case "cbdev.localhost":
	case "localhost":
	case "frikie":
	case "localhost/www.can-borrell.com":
		$nou=$prod=$dev=false;
		$local=true;
	break;
	
	case "dev.can-borrell.com":
		$nou=$prod=$local=false;
		$dev=true;
	break;

	case "dev2.can-borrell.com":
	case "nou.can-borrell.com":
		$nou=$prod=$dev=$local=false;
		$nou=true;
	break;	
	
	default:
		$nou=$dev=$local=false;
		$prod=true;
	break;
}
defined('DEV') or define('DEV', $dev);
defined('LOCAL') or define('LOCAL',$local);
defined('PROD') or define('PROD',$prod);
defined('NOU') or define('NOU',$nou);

//echo "----------------111111111111111111111111111111111---------------";
/********************************************************/
// Configura dades de connexi� depenent del servidor
/********************************************************/
if (LOCAL)
{
	defined('URL') or define("URL","http://cb.localhost/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "root";
	$password_canborrell = "madelaine";
	$database=$database_canborrell = "canborrell_del";
}
elseif (DEV)
{
	defined('URL') or define("URL","http://dev.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_dev_del";
}
elseif (PROD)
{
	defined('URL') or define("URL","http://www.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_del";
}
elseif (NOU)
{
	defined('URL') or define("URL","http://dev2.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_del";
	
}
/********************************************************/
// define DB_CONNECTION_FILE_DEL
defined('DB_CONNECTION_FILE_DEL') or define('DB_CONNECTION_FILE_DEL',"../Connections/DBConnection_del.php");
/********************************************************/

/********************************************************/
/********************************************************/
/********************************************************/
/********************************************************/
// Connecta!! ATENCIO CONNECT / PCONNECT
/********************************************************/
$DBConn=$canborrell = mysql_connect($hostname_canborrell, $username_canborrell, $password_canborrell) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_canborrell);
/********************************************************/

/********************************************************/
// PREPARA CHARSET (LA COMPROVACIO AMF POTSER NO CAL...)
/********************************************************/
if (CHARSET=="UTF-8" && AMF!==true)
{
		@mysql_query('SET NAMES UTF8');
		@mysql_query('SET CHARACTER SET UTF8');
		@mysql_query('SET COLLATION_CONNECTION=utf8_unicode_ci'); 
		mysql_set_charset('utf8',$canborrell); 
}

$query="SET GLOBAL time_zone=SYSTEM";
//$query="SET GLOBAL time_zone=Europe/Madrid";
$r=mysql_query($query,$DBConn);

/*
$query="SELECT FROM_UNIXTIME(UNIX_TIMESTAMP( now( ) )) ";
$r=mysql_query($query,$DBConn);
$t=mysql_result($r,0);
echo "unix: $t -  Data php:".date("Y-m-d H:i:s")." / time php:".time();

$query="SELECT  now( )  ";
$r=mysql_query($query,$DBConn);
$t=mysql_result($r,0);
echo "MY NOW: $t - ".date("Y-m-d H:i:s");

die();
*/
?>