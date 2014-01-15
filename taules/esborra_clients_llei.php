<?php
require_once 'Gestor.php';

//die(ROOT.INC_FILE_PATH.LOG_FILE);
//$t=$_GET['t'];

Gestor::greg_log("CRON: esborra_clients_llei.php > reservestaules");
print esborra_clients_llei('reservestaules');
Gestor::greg_log("CRON: esborra_clients_llei.php > reserves");
print esborra_clients_llei('reserves');
/***************************************************************************/
// ENVIA UN SMS AVISANT QUE HEM ESBORRAT LES DADES
/***************************************************************************/
function esborra_clients_llei($t)
{
  require('../Connections/DBConnection.php');
  /******************************************************************************/

  $query_reserves = "
  SELECT *, $t.client_id as clid
  FROM $t
  LEFT JOIN client ON $t.client_id = client.client_id
  WHERE DATA < NOW()
  AND (
  reserva_info & 64
  )
  AND $t.client_id <> 3509  /* NO ESBORRO EL CLIENT DE PROVA */
  /* NO ESBORREM SI TE RESERVA FUTURA */
  AND $t.client_id NOT
  IN (
  SELECT client_id
  FROM $t
  WHERE client_id IS NOT NULL AND data >= CURDATE( )
  )
  ";
  $reserves = mysql_query($query_reserves, $DBConn) or die(mysql_error());
  $nr=mysql_num_rows($reserves);
  $mensa = "<br/>TROBAT $nr registres:<br/>".$query_reserves ."....................................<br/><br/>";
  Gestor::greg_log( "<br/>TROBATS $nr registres:<br/>".$query_reserves ."....................................<br/><br/>");
  if (!$nr) return("No hi ha clients pendents d'esborrar a $t<br/>");

  $mensa.=$nr." Clients per eliminar"."<br/>";
  while ($row=mysql_fetch_array($reserves))  
  {
    //ESBORRO DADES CLIENT
    $query_reserves="
        UPDATE client
        SET client_nom='ESBORRAT',client_cognoms='ESBORRAT', client_telefon='ESBORRAT', client_mobil='ESBORRAT', client_email='ESBORRAT', client_dni='ESBORRAT'
        WHERE client_id=".$row['clid'];
    	
    $mensa.=$query_reserves."<br/>";
    mysql_query($query_reserves, $DBConn) or die(mysql_error());
    	
    $query_reserves="
    UPDATE $t
    SET nom='ESBORRAT', tel='ESBORRAT', fax='ESBORRAT', email='ESBORRAT', factura_cif='ESBORRAT'
    WHERE client_id=".$row['clid'];
    	
    $mensa.=$query_reserves."<br/>";
    mysql_query($query_reserves, $DBConn) or die(mysql_error());
    	
    //RESETEJO EL FLAG DESBORRAR DADES (per que no estigui actiu despres d'esborrar. Pel futur)
    $query_reserves="
    UPDATE $t
    SET reserva_info=0 WHERE id_reserva=".$row['id_reserva'];
    $mensa.=$query_reserves."<br/>";
    mysql_query($query_reserves, $DBConn) or die(mysql_error());
    	
     
    $sms_mensa="RESTAURANT CAN BORRELL: A SOLICITUD SUYA, HEMOS ELIMINADO SUS DATOS DE NUESTRA BASE DE DATOS";
    if (SMS_ACTIVAT)
    {
      enviaSMS_esborrat($row['client_mobil'],$sms_mensa);
      $mensa.="ESBORRA_CLIENT ".$row["client_id"]." - SMS ENVIAT tel: ".$row['client_mobil']." \\n";
    }
    else
    {
      Gestor::greg_log("ESBORRA_CLIENT ".$row["client_id"]."- ENVIO SMS DESACTIVAT tel: ".$row['client_mobil']." ********** $sms_mensa ");
      $mensa.="ESBORRA_CLIENT ".$row["client_id"]."- ENVIO SMS DESACTIVAT tel: ".$row['client_mobil']."\n";
    }
  }


  return $mensa;
}


function enviaSMS_esborrat($numMobil,$mensa)
{
  //return;
  /********************/
  /********************/
  /********************/
  if (LOCAL===TRUE) return;
  include_once( "../editar/SMSphp/EsendexSendService.php" );

  // Test Variables - assign values accordingly:
  $username = "restaurant@can-borrell.com";			// Your Username (normally an email address).
  $password = "1909";			// Your Password.
  $accountReference = "EX0062561";		// Your Account Reference (either your virtual mobile number, or EX account number).
  $originator = "Rest.Can Borrell";		// An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).
  $recipients = $numMobil;		// The mobile number(s) to send the message to (comma-separated).
  $body = $mensa;			// The body of the message to send (must be less than 160 characters).
  $type = "Text";			// The type of the message in the body (e.g. Text, SmartMessage, Binary or Unicode).
  $validityPeriod = 0;		// The amount of time in hours until the message expires if it cannot be delivered.
  $result;			// The result of a service request.
  $messageIDs = array($idReserva);		// A single or comma-separated list of sent message IDs.
  $messageStatus;			// The status of a sent message.

  $sendService = new EsendexSendService( $username, $password, $accountReference );
  $result = $sendService->SendMessage( $recipients, $body, $type );



  print_log("ENVIAT SMS ESBORRA_CLIENT: $numMobil RESERVA $idReserva");
  print_log("RESULTAT ENVIO: ".$result['Result']." / ".$result['MessageIDs']);
}
?>
