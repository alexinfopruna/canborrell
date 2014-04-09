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
 /*
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
  */
  
//Definir que vamos a usar SMTP
$mail->IsSMTP();
//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
// 0 = off (producción)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug  = 0;
//Ahora definimos gmail como servidor que aloja nuestro SMTP
$mail->Host       = 'smtp.gmail.com';
//El puerto será el 587 ya que usamos encriptación TLS
$mail->Port       = 587;
//Definmos la seguridad como TLS
$mail->SMTPSecure = 'tls';
//Tenemos que usar gmail autenticados, así que esto a TRUE
$mail->SMTPAuth   = true;
//Definimos la cuenta que vamos a usar. Dirección completa de la misma
$mail->Username   = "alexinfopruna@gmail.com";
//Introducimos nuestra contraseña de gmail
$mail->Password   = "madelaine";
//Definimos el remitente (dirección y, opcionalmente, nombre)
$mail->SetFrom('info@can-borrell.com', 'Reserves Can Borrell');
//Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
$mail->AddReplyTo('replyto@correoquesea.com','El de la réplica');
//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
$mail->AddAddress($addr);
//Definimos el tema del email
$mail->Subject = $subject;
//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
$mail->Body = $body;
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
$mail->AltBody = $altbody;
// HTML
$mail->IsHTML(true);
//Enviamos el correo  
  
    if ($cco)   $mail->AddBCC($cco);
  

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