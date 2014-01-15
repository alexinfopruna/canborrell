<?php
require_once ("class.phpmailer.php");
require_once(ROOT.INC_FILE_PATH.'alex.inc');

if (!defined('CONFIG'))
{
	if (!defined('ROOT')) 	define('ROOT', "../taules/");
	require_once(ROOT."php/Configuracio.php");
	$conf = new Configuracio();
}

function mailer($addr,$subject,$body,$altbody,$attach=null, $test=false, $cco=null)
{  
  if (!isset($altbody)) $altbody="Su cliente de correo no puede interpretar correctamente este mensaje. Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. Disculpe las molestias";
    
  $mail = new phpmailer();
  if (defined('CHARSET')) $mail->CharSet =CHARSET;
  $mail->CharSet = 'UTF-8';  
  $mail->IsSMTP();
  $mail->Host = "mail.can-borrell.com";
  $mail->SMTPAuth = true;
  $mail->Username = "mail6224"; 
  $mail->Password = "joseprov";
  $mail->From = "info@can-borrell.com";
  $mail->FromName = "Reserves Can Borrell";
  $mail->Timeout=30;
  $mail->AddAddress($addr);
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->AltBody = $altbody;
  $mail->IsHTML(true);
  
  if ($cco)   $mail->AddBCC($cco);
  //if ($cco)   $mail->AddCC($cco);

  if ($addr=="info@can-borrell.com" && isset($_POST['client_email']))  $mail->From=$_POST['client_email'];
  if ($addr==MAIL_RESTAURANT && isset($_POST['client_email']))  $mail->From=$_POST['client_email'];
  
  if ($attach) $mail->AddAttachment($attach,basename($attach));
 
  $occo='';
  if ($test || ENVIA_MAILS===false)
  {
	  $exito=true;
	  $o='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" pageEncoding="UTF-8"/>';
	  $o.= "<br/>charset=".CHARSET." *** mailer: ".$mail->CharSet."<br/>";
	  $o.= "MAIL TO: $addr  FROM: info@can-borrell.com<br/>";
	  if ($cco) $occo= "CCO: $cco<br/>";
	  $o.=$occo;
	  $o.= "SUBJECT: $subject<br/>";  
	  $o.= $body.EOL.EOL;
	  
	$f = fopen(ROOT.INC_FILE_PATH."log/log_mail.html", 'w');
	fwrite($f,$o);
	  
 	if (DEV) $mail->Send();
  }
   else
   {
	  $exito = $mail->Send();
	}

  $intentos=1; 
  while ((!$exito) && ($intentos < 5)) {
		if (true) 
		{
			sleep(5);
			$exito = $mail->Send();	
		}
     	$intentos=$intentos+1;	
   }
   
   
   
   if(!$exito)
   {
      print_log("<span style='color:red'>MAILER ERROR:</span> Enviat mail TO:$addr $cco SUBJECT: $subject");
      return false;
   }
   else
   {
      print_log("<span style='color:green'>MAILER SUCCESS:</span>: Enviat mail TO:$addr $cco SUBJECT: $subject");
     return true;
   } 
}
?>