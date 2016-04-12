<?php
            if (!defined('ROOT'))  define('ROOT', "taules/");
            require_once (ROOT."gestor_reserves.php");  
            
            $lang = gestor_reserves::getLanguage();
            require_once("translate_web_$lang.php");
            
$ls=array(
  'ca'=> 'cat',
  'cat'=> 'cat',
  'es'=> 'cat',
  'esp'=> 'cat',
  'en'=> 'en',
  'eng'=> 'en',
);

$ruta = '';
if (!isset($_REQUEST['page'])) $_REQUEST['page'] =  'index.html';

if (!strstr($_REQUEST['page'],'.')) $_REQUEST['page'] .='.html';

$ruta .= $_REQUEST['page'];
//echo "*************** DEBUG ********************$ruta";die();
if (!file_exists($ruta)){
  header("Location: /404.html");
 // exit();
}

include($ruta);
/*
echo __FILE__;

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
*/
?>
