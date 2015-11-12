<?php
/**
 * tespTPV:
 * 
 * order=31710
 * 
 */


//$message = "1234000000002085078125713978000qwertyasdf0123456789";
define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");
if ($_SESSION['permisos']<200) die("error:sin permisos") ;

$amount="1500";

//print_r($_SESSION);
$id = $lang = "not set";
    include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    include INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';
     
        $miObj = new RedsysAPI;
        
                            $conecta = "Gestor_form.php?a=respostaTPV_SHA256"; 
	//$fuc="999008881";
	//$terminal="871";
	//$moneda="978";
	//$trans="0";
	$url="http://sis-d.redsys.es/sis/realizarPago";
	//$urlOKKO="";
	$id=time();
	$id=99999;
	$amount="145";
                            $extra_data="PK";

	$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
	$miObj->setParameter("DS_MERCHANT_ORDER",strval($id));
	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
	$miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
	$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
	$miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
	$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
	$miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);		
	$miObj->setParameter("DS_MERCHANT_URLKO",$urlKO);                            
                            /*
 	$miObj->setParameter("Ds_Date",date("d-m-Y"));
 	$miObj->setParameter("Ds_Hour",date("H:i"));
 	$miObj->setParameter("Ds_Amount",$amount);
 	$miObj->setParameter("Ds_Currency",$moneda);
 	$miObj->setParameter("Ds_Order",$id);
 	$miObj->setParameter("Ds_MerchantCode",$fuc);
 	$miObj->setParameter("Ds_Terminal",$terminal);
 	$miObj->setParameter("Ds_Response",$response);
 	$miObj->setParameter("Ds_MerchantData",$extra_data);
 	$miObj->setParameter("Ds_ConsumerLanguage","003");
                            */
	
	// Se generan los parámetros de la petición
	$request = "";
	$params = $miObj->createMerchantParameters();
	$signature = $miObj->createMerchantSignature($clave256);

                            //$signature = $miObj->createMerchantSignatureNotif($clave256, $params);
                            

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es">
<head>
</head>
<body>
<form name="frm" action="<?php echo $conecta ?>" method="POST" target2="_blank">
Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/></br>
Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/></br>
Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
<input type="submit" value="Enviar" >
</form>

</body>
</html>

<?php
die();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
     <br/><br/>
    Exemple: <br/>
    
    <b> http://cbdev.localhost/reservar/testTPV.php?order=21431710</b>
    <br/><br/>
<form id="form1" name="form1" method="post" action="Gestor_form.php?a=respostaTPV">
  <p>Ds_Date   
    <input type="text" name="Ds_Date" value="<?php echo date("d-m-Y")?>" />
  </p>
  <p>Ds_Hour   
    <input type="text" name="Ds_Hour" value="15:00" />
  </p>
  <p>
    Ds_Amount   
    <input type="text" name="Ds_Amount" value="<?php echo $amount?>" />
  </p>
  <p>
    Ds_Currency   
    <input type="text" name="Ds_Currency" value="978" />
  </p>
  <p>Ds_Order   
    <input type="text" name="Ds_Order" value="<?php echo $_REQUEST['order'] ?>" />
  </p>
  <p>Ds_MerchantCode   
    <input type="text" name="Ds_MerchantCode" value="<?php echo $code?>" />
  </p>
  <p>Ds_Terminal   
    <input type="text" name="Ds_Terminal" value="001" />
  </p>
  <p>Ds_Signature   
    <input type="text" name="Ds_Signature" value="<?php echo $signature?>" />
  </p>
  <p>Ds_Response   
    <input type="text" name="Ds_Response" value="000" />
                  </p>
  <p>
    <input type="submit" name="Submit" value="Enviar" />
  </p>
</form>
</body>
</html>
