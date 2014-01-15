<?php
//if ($_REQUEST['pass']!='joseprov') die("USUARI NO AUTORITZAT!");
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
if (!$gestor->valida_sessio())die("USUARI NO AUTORITZAT!");


/***************************************************************************/
// ENVIA UN SMS AVISANT QUE LA RESERVA JA S'HA CADUCAT
/***************************************************************************/
function sms_caducades()
{
	require(ROOT.'../Connections/DBConnection.php'); 
	/******************************************************************************/	
    $query_reserves = "SELECT * FROM reserves WHERE data_limit < CURDATE() AND data_limit>'2008-01-01' AND estat=2";
    $reserves = mysql_query($query_reserves, $canborrell) or die(mysql_error());
    $nr=mysql_num_rows($reserves);
	
	//$mensa="ENVIEM SMS RESERVES CADUCADES. TROBATS $nr REGISTRES";
    while ($row=mysql_fetch_array($reserves))
    {
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row['data'], $mifecha); 
			$lafecha=$mifecha[3]."/".$mifecha[2]; 
			$sms_mensa="SU SOLICITUD DE RESERVA EN CAN BORRELL PARA EL $lafecha (ID".$row["id_reserva"].") HA CADUCADO. Can Borrell NO GARANTIZA LA DISPONIBILIDAD DE MESA PARA EL GRUPO!!";
			if (SMS_ACTIVAT) 
			{
				
				enviaSMS_caducades($row['tel'],$sms_mensa);
       			$mensa.="CADUCADA ".$row["id_reserva"]." - SMS ENVIAT tel: ".$row['tel']." \\n";
			}
			else 
			{
				print_log("CADUCADA ".$row["id_reserva"]."- ENVIO SMS DESACTIVAT tel: ".$row['tel']." ********** $sms_mensa ");
       			$mensa.="CADUCADA ".$row["id_reserva"]."- ENVIO SMS DESACTIVAT tel: ".$row['tel']."\n";
			}
			
		//MARCA SMS ENVIAT
        $query_reserves = "UPDATE reserves SET num_1=1000 WHERE id_reserva=".$row["id_reserva"];
        $update = mysql_query($query_reserves, $canborrell) or die(mysql_error());
	}

		
		//MARCA RESERVES COM A CADUCADES
		$query_reserves = "UPDATE reserves SET estat=6 WHERE data_limit < CURDATE() AND data_limit>'2008-01-01' AND estat=2";
		$reserves = mysql_query($query_reserves, $canborrell) or die(mysql_error());
		
		return $mensa;
}   


function enviaSMS_caducades($numMobil,$mensa)
{
	include_once( "SMSphp/EsendexSendService.php" );
	
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
	
	
	
	print_log("ENVIAT SMS CADUCADA: $numMobil RESERVA $idReserva");
	print_log("RESULTAT ENVIO: ".$result['Result']." / ".$result['MessageIDs']);	
}	
/*

function print_log($t)
{
	echo "<br/>PRINT_LOG: ".$t;
}

define (SMS_ACTIVAT,true);
sms_caducades();
*/
?>