<?php
$message = "1234000000002085078125713978000qwertyasdf0123456789";
//$message = "123484936910036111241387978000restaueu8r398darbone";

$signature = strtoupper(sha1($message));

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="respostaTPV.php">
  <p>Ds_Date   
    <input type="text" name="Ds_Date" value="07/12/2008" />
  </p>
  <p>Ds_Hour   
    <input type="text" name="Ds_Hour" value="15:00" />
  </p>
  <p>
    Ds_Amount   
    <input type="text" name="Ds_Amount" value="1234" />
  </p>
  <p>
    Ds_Currency   
    <input type="text" name="Ds_Currency" value="978" />
  </p>
  <p>Ds_Order   
    <input type="text" name="Ds_Order" value="000000002085" />
  </p>
  <p>Ds_MerchantCode   
    <input type="text" name="Ds_MerchantCode" value="078125713" />
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
