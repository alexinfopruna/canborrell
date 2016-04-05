<?php
$ls=array(
  'ca'=> 'cat',
  'cat'=> 'cat',
  'es'=> 'cat',
  'esp'=> 'cat',
  'en'=> 'en',
  'eng'=> 'en',
);

$ruta = '';
if (!isset($_REQUEST['page'])) $_REQUEST['page'] =  'index.php';

if (!strstr($_REQUEST['page'],'.')) $_REQUEST['page'] .='.html';

$ruta .= $_REQUEST['page'];

if (!file_exists($ruta)){
  header ("Location: /404.php" );
  exit();
}
echo "*************** DEBUG ********************";
include($ruta);

echo __FILE__;

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
/**/
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

?>
