<?php



  $url = isset($_GET['url'])?$_GET['url']:'/';
  
  if (!isset($_SESSION))  session_start();
  if (isset($_SESSION['lang']))  $lang = $_SESSION['lang'];
if  (isset($_GET['lang'])) $lang = $_GET['lang'];
$_SESSION['lang'] = $lang;

if (!function_exists("l"))  require_once("translate_menu_$lang.php");

$ruta_lang = "../$lang/";
/*
echo "*************** DEBUG ********************";

echo __FILE__;

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
*/



function active($desti) {
  global $lang;
  global $ruta_lang;

  $url = isset($_GET['url'])?$_GET['url']:'/';
  $parts = pathinfo($url);
  $self = $parts['filename'];
  $parts = pathinfo($desti);
  $dest = $parts['filename'];

  $self = substr($self, 0, strlen($dest));

  $class = ($dest == $self) ? 'menu-active' : '';
  echo ' href="' . $ruta_lang . $desti . '" class="' . $class . '" ';
}
?>
<table id="table_menu" style="margin:auto auto;">
    <TR id="tr_menu">
        <TD ALIGN="CENTER">
            <A <?php active('index.php') ?>><?php l("CAN BORRELL"); ?></A>  
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 

            <A <?php active('fotos.html') ?> ><?php l("FOTOS-VIDEO"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 

            <A <?php active('plats.php') ?>><?php l("CARTA I MENU") ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  

            <A <?php active('on.html') ?>><?php l("ON SOM: MAPA"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 

            <A <?php active('excursions.html') ?>><?php l("EXCURSIONS"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 

            <A <?php active('historia.html') ?>><?php l("HISTORIA"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
            <!--  -->
            <A <?php active('premsa.html') ?>><?php l("PREMSA"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 

            <A <?php active('horaris.html') ?>><?php l("HORARI"); ?></A> 
            <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  

            <A <?php active('../reservar/form.php') ?>><?php l("RESERVES"); ?></A>
            <!--<A <?php active('contactar.php') ?>><?php l("RESERVES"); ?></A> -->
        </TD>
    </TR>
</table>