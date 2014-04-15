<?php   
$r=null;
$surt=false;

if (!defined('ROOT')) define('ROOT', "../taules/");
require(ROOT."Gestor.php");
require_once(ROOT."gestor_reserves.php");

require(ROOT.DB_CONNECTION_FILE); 
require_once(INC_FILE_PATH.'valors.php'); 
require_once(INC_FILE_PATH.'alex.inc'); //valida_admin('editar.php') ;
$titol['cat']="PAGAMENT DE RESERVA";
$titol['esp']="PAGO DE RESERVA";
$subtitol['cat']="Dades de la reserva";
$subtitol['esp']="Datos de la reserva";

if (!isset($_GET["id"]))
{
    $surt=true;
}
else
{
    $id=$_GET["id"];

}

/******************************************************************************/	

//CADUCADES
//$query_reserves = "UPDATE {T_RESERVES} SET estat=6 WHERE ADDDATE(data_limit,INTERVAL 1 DAY) < NOW() AND data_limit>'2008-01-01' AND estat=2";
//$reserves = mysql_query($query_reserves, $canborrell) or die(mysql_error());

if ($id) $query="SELECT * FROM ".T_RESERVES." "
        . "LEFT JOIN client ON client.client_id=".T_RESERVES.".client_id "
        . "WHERE id_reserva=$id";

$Result = mysql_query($query, $canborrell) or die(mysql_error());
$fila=mysql_fetch_assoc($Result);

$estat=$fila['estat'];
$import=$fila['preu_reserva'];
$nom=$fila['nom']; 
$lang=$lang_cli=$fila['lang'];
if (!isset($lang)) $lang=$lang_cli="esp"; 

// comprovacions estat reserva
// ARREGLAR MISSATGES

if (($estat==3)||($estat==7)) // JA S?HA PAGAT 
{  
    $titol['cat']="Aquesta reserva ja ha estat pagada<br><br><br><br><br><br>";
    $titol['esp']="Esta reserva ya ha sido pagada<br><br><br><br><br><br><br>";
    $surt=true;
}
else if ($estat!=2)    // NO ESTA CONFIRMADA
{
    $titol['cat']="Lamentablement aquesta reserva no ha estat confirmada o ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
    $titol['esp']="Lamentablemente esta reserva no ha sido confirmada o ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
    $surt=true;
}


// CADUCADA???
$d1=cambiaf_a_normal($fila['data']);
$d2=date("d/m/y");
$dif=compara_fechas($d1,$d2);
if ($dif<0) 
{
    $titol['cat']="Aquesta reserva ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
    $titol['esp']="Esta reserva ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
    $surt=true;

}

// EXISTEIX???
if (mysql_num_rows($Result)<=0)
{
    $titol['cat']="Ho sentim però aquesta reserva no apareix a la base de dades<br><br><br><br><br><br><br><br><br>";
    $titol['esp']="Lo sentimos pero esta reserva no aparece en la base de datos<br><br><br><br><br><br><br><br><br>";
    $surt=true;
}



mysql_free_result($Result);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detall de reserva</title>
               <?php echo Gestor::loadJQuery("2.0.3"); ?>
<link href="../editar/reserves.css" rel="stylesheet" type="text/css" />
<link href="../estils.css" rel="stylesheet" type="text/css" />
<?php
$translate['COMPRA_SEGURA']['esp']="Para realizar el pago a través de esta pasarela bancaria, es necesario que hayas activado la tarjeta para COMPRA SEGURA A INTERNET en tu banco.\\n\\nCon esta activación te facilitarán un código de cuatro cifras que se requiere al final del proceso.\\n\\nDisculpa las moléstias";
$translate['COMPRA_SEGURA']['cat']="Per poder realitzar el pagament a través d´aquesta passarel·la bancaria, cal que hagis activat la tarja per a COMPRA SEGURA A INTERNET al teu banc. \\n\\nAmb aquesta activació et facilitaran un codi de quatre xifres que és requerit al final del procès.\\n\\nDisculpa les molèsties";
?>

    <script language=JavaScript>
    function calc() { 
	
	alert("<?php echo $translate['COMPRA_SEGURA'][$lang]?>");	
    document.getElementById('boto').style.display = 'none';
    vent=window.open('','tpv','width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
   // vent.moveTo(eje_x,eje_y);
    document.forms[0].submit();}

    </script>

	
	
		<script type="text/javascript" src="../js/dynmenu.js"></script>
</head>

<body >
<table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
  <tr>
    <td width="775" colspan="2" align="right" background="../img/fons_9a.jpg"><a href="../index.html"><img src="../img/lg_sup.gif" alt="img" width="303" height="114" border="0" title="INICI" /></a></td>
  </tr>
  <tr>
    <td bgcolor="#570600" colspan="2" align="center">
<?php if ($lang=="cat"){?>	
	<table cellpadding="0" cellspacing="0" width="761" height="18" border="0">
      <tr>
        <td><a href="index.html">CAN BORRELL</a> <img src="../img/separa_mn.gif" alt="g" width="1" height="8" border="0" /> <a href="fotos.html">FOTOS</a> <img src="../img/separa_mn.gif" alt="f" width="1" height="8" border="0" /> <a href="plats.php">PLATS</a> <img src="../img/separa_mn.gif" alt="e" width="1" height="8" border="0" /> <a href="on.html">COM ARRIBAR-HI</a> <img src="../img/separa_mn.gif" alt="d" width="1" height="8" border="0" /> <a href="excursions.html">EXCURSIONS</a> <img src="../img/separa_mn.gif" alt="c" width="1" height="8" border="0" /> <a href="historia.html">HIST&Ograve;RIA</a></td>
        <td align="right"><a href="horaris.html">HORARIS</a> <img src="../img/separa_mn.gif" alt="b" width="1" height="8" border="0" /> <a href="reserves.html">RESERVES</a> <img src="../img/separa_mn.gif" alt="a" width="1" height="8" border="0" /> <font color="#FFFFFF"><b>CONTACTAR</b></font></td>
      </tr>
    </table>
<?php }else{?>	
	<table cellpadding="0" cellspacing="0" width="761" height="18" border="0">
      <tr>
        <td><a href="index.html">CAN BORRELL</a> <img src="../img/separa_mn.gif" alt="g" width="1" height="8" border="0" /> <a href="fotos.html">FOTOS</a> <img src="../img/separa_mn.gif" alt="f" width="1" height="8" border="0" /> <a href="plats.php">PLATOS</a> <img src="../img/separa_mn.gif" alt="e" width="1" height="8" border="0" /> <a href="on.html">COMO LLEGAR </a> <img src="../img/separa_mn.gif" alt="d" width="1" height="8" border="0" /> <a href="excursions.html">EXCURSIONES</a> <img src="../img/separa_mn.gif" alt="c" width="1" height="8" border="0" /> <a href="historia.html">HISTORIA</a></td>
        <td align="right"><a href="horaris.html">HORARIOS</a> <img src="../img/separa_mn.gif" alt="b" width="1" height="8" border="0" /> <a href="reserves.html">RESERVAS</a> <img src="../img/separa_mn.gif" alt="a" width="1" height="8" border="0" /> <font color="#FFFFFF"><b>CONTACTAR</b></font></td>
      </tr>
    </table>

<?php }?>	
	
	</td>
  </tr>
</table>
<table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><span class="titol"><?php echo $titol[$lang];if ($surt) exit(); ?></span></td>
  <td width="12">  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  <td>  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><?php echo $txt[40][$lang] ?>      </td>
  <td>  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" class="estat">  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><?php echo $txt[41][$lang] ?></div>    </td>
  <td align="center" class="estat">  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" class="gran">&nbsp;</td>
    <td align="center" class="estat">  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" class="gran"><?php echo $subtitol[$lang] ?></td>
  <td align="center" class="estat">  </tr>
  <tr>
    <td width="12">&nbsp;</td>
    <td><table border="0" align="center" cellpadding="3" cellspacing="3">
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">id_reserva</td>
        <td width="320" align="right" bgcolor="#333333" class="llista"><div align="left" class="titol2"><?php echo $fila['id_reserva'];echo $r; ?> </div></td>
      </tr>

      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[8][$lang]?></td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo data_llarga($fila['data'],$lang); ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">hora</td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo substr($fila['hora'],0,5); ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[1][$lang]?></td>
        <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['client_nom']." ".$fila['client_cognoms']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">mòbil</td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['client_mobil']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">tel</td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['client_telefon']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">email</td>
        <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['client_email']; ?></div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2">menú</td>
        <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php 
//echo $mmenu[(int)$fila['menu']]['cat']; 
            ///// COMANDA
            $gestor=new gestor_reserves();
            echo $comanda=$gestor->plats_comanda($fila['id_reserva']);
       
        
        ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[2][$lang]?></td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$fila['adults']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[3][$lang];?></td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$fila['nens10_14']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[4][$lang];?></td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$fila['nens4_9']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[5][$lang];?></td>
        <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int)$fila['cotxets']; ?> </div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[6][$lang];?></td>
        <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['observacions']; ?></div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#660000" class="Estilo2">Respuesta</td>
        <td width="320" bgcolor="#FFE6E1" class="llista"><div align="left">Pendent de paga i senyal</div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[7][$lang];?></td>
        <td width="320" align="right" bgcolor="#999999" class="llista"><div align="left" class="estat">
            <div align="right" class="Estilo5"><?php echo $fila['preu_reserva']; ?> </div>
        </div></td>
      </tr>
    </table></td>
    <td><p>&nbsp;</p>
      <p>&nbsp;</p>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
       <?php ShowForm($import,$nom); ?>  
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">
      <p>&nbsp;</p>
      <p><?php echo $txt[9][$lang] ?></p>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
function ShowForm ($import,$nom) {
// Posted data
global $HTTP_POST_VARS;
global $lang;
global $id;
global $surt;

require_once(INC_FILE_PATH.'TPV.php'); 

// Valores constantes del comercio
//$_GET["id"]="22";
if (isset($id)) 
    {
     // $id=$_GET["id"];
      $id_reserva=((int)$_GET["id"])+100000;
      $order=date("dmy").$id_reserva;
      $order=substr(time(),3,6).$id_reserva;
      $order=substr(time(),0,3).$id_reserva;
    } 

$name='Restaurant Can Borrell';
$amount=$import*100;
$currency='978';
$transactionType='0';
$urlMerchant='http://www.can-borrell.com/reservar/Gestor_form.php?a=respostaTPV';
//$urlMerchant='http://www.can-borrell.com';
$producte="Reserva restaurant Can Borrell";
$titular=$nom;
$urlOK="http://www.can-borrell.com/editar/TPV/pagamentOK.php?id=$id&lang=$lang";
$urlKO="http://www.can-borrell.com/editar/TPV/pagamentKO.php?id=$id&lang=$lang";
$idioma=($lang=="cat")?"003":"001";

if ($surt) exit();
// Now, print the HTML script
$boto['cat']="Realitzar Pagament";
$boto['esp']="Realizar Pago";
//$url_tpvv="pepe.php";
echo "<form name='compra' action=$url_tpvv method=post target=tpv>
        <div align='center'>
          <p>
           <input id='boto' type='submit' name='Submit' value='".$boto[$lang]."' onclick='javascript:calc();'/></p>
            </div>
<input type=hidden name=Ds_Merchant_Amount value='$amount'>
<input type=hidden name=Ds_Merchant_Currency value='$currency'>
<input type=hidden name=Ds_Merchant_Order  value='$order'>
<input type=hidden name=Ds_Merchant_MerchantCode value='$code'>
<input type=hidden name=Ds_Merchant_Terminal value='$terminal'>
<input type=hidden name=Ds_Merchant_TransactionType value='$transactionType'>
<input type=hidden name=Ds_Merchant_ProductDescription value='$producte'>
<input type=hidden name=Ds_Merchant_Titular value='$titular'>
<input type=hidden name=Ds_Merchant_UrlOK value='$urlOK'>
<input type=hidden name=Ds_Merchant_UrlKO value='$urlKO'>
<input type=hidden name=Ds_Merchant_ConsumerLanguage value='$idioma'>
<input type=hidden name=Ds_Merchant_MerchantURL value='$urlMerchant'>";
$message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
$signature = strtoupper(sha1($message));
echo "<input type=hidden name=Ds_Merchant_MerchantSignature value='$signature'>
</form>";										  
} # End of function ShowForm

?>
</body>
</html>