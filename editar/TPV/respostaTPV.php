<?php
/***************************************************/
//
// CODIFICACIO ESTAT
//
// 1 PENDENT
// 2 CONFIRMADA
// 3 PAGAT TRANSF 
// 4 DENEGADA
// 5 ELIMINADA
// 6 CADUCADA
// 7 PAGAT TPV
// 100 RES.PETITA
/***************************************************/

if (!defined('ROOT')) define('ROOT', "../../taules/");
require(ROOT."Gestor.php");
require(ROOT."gestor_reserves.php");
echo "RAwwA";die();
if (isset($_REQUEST['testTPV'])) $testTPV=$_REQUEST['testTPV'];
else $testTPV=false; //Simula enviament mails, però no envia realment
$ini_file = ROOT.INC_FILE_PATH."log/logTPV.txt";	
$fp = fopen($ini_file, "a");
fwrite($fp, "----------------------------------------------------------------------------------\n");
fwrite($fp, "----------------------------------------------------------------------------------\n");
fwrite($fp, ">> Conexió TPV Caixa Sabadell: ".date("d/m/y  h:i")."\n");
$req='<pre>'.print_r($_REQUEST,true).'</pre>';
fwrite($fp, "$req\n");
fwrite($fp, "----------------------------------------------------------------------------------\n");

require_once ("../".INC_FILE_PATH."TPV.php");
require(ROOT.DB_CONNECTION_FILE); 
require_once(ROOT.INC_FILE_PATH.'valors.php'); 
require_once(ROOT.INC_FILE_PATH.'alex.inc');
require_once(ROOT.'../editar/mailer.php'); 


$attach='';

if (!isset($_POST["Ds_Amount"])) $_POST["Ds_Amount"]='';
if (!isset($_POST["Ds_Order"])) $_POST["Ds_Order"]='';
if (!isset($_POST["Ds_MerchantCode"])) $_POST["Ds_MerchantCode"]='';
if (!isset($_POST["Ds_Currency"])) $_POST["Ds_Currency"]='';
if (!isset($_POST["Ds_Response"])) $_POST["Ds_Response"]='';
if (!isset($_POST["Ds_Hour"])) $_POST["Ds_Hour"]='';
if (!isset($_POST["Ds_Date"])) $_POST["Ds_Date"]='';
if (!isset($_POST["Ds_Signature"])) $_POST["Ds_Signature"]='';

if (!isset($_GET["sig"])) $_GET["sig"]='';



$message = $_POST["Ds_Amount"].$_POST["Ds_Order"].$_POST["Ds_MerchantCode"].$_POST["Ds_Currency"].$_POST["Ds_Response"].$clave;
$signature = strtoupper(sha1($message));



//////////////// 
/////////////////
// TRAMPAAAAA!!!!!
/////////////////
if ($testTPV)
{
	$test_mail=isset($_REQUEST['testMAIL'])?$_REQUEST['testMAIL']:FALSE;
	if ($_GET["sig"]=="OK") $signature=$_POST["Ds_Signature"];

	$_POST["Ds_Response"]="000";
	if (isset($_GET["resp"])) $_POST["Ds_Response"]=$_GET["resp"];

	$id="62";
	if (isset($_REQUEST['id'])) $id=$_REQUEST['id'];
	
	$_POST["Ds_Order"]="xxxxxx10".$id;
	$_POST["Ds_ConsumerLanguage"]=3;
	$_POST["Ds_Amount"]="100";
	$_POST["Ds_MerchantCode"]="xxxxxxxxxxx";
	//$_POST["Ds_Signature"]=$signature;


	$k=substr($_POST["Ds_Order"],6,6);
	$id=(int)($k)-100000;
echo "RAA";die();
/////////////////
/////////////////
/////////////////
}


$k=substr($_POST["Ds_Order"],6,6);
$id=(int)($k)-100000;

$referer=$_SERVER['REMOTE_ADDR'];
$txxt=">> !!!!! INTENT D'ACCES FRAUDULENT: $referer !!!!!!!!\n"; 
if ($_POST["Ds_Signature"]==$signature)
{
    $txxt=">> RESPOSTA-".date("d M Y H:i")."\n";    
}

$lang=((int)$_POST["Ds_ConsumerLanguage"])==3?$lang="cat":$lang="esp";



$query="UPDATE reserves SET estat=7 WHERE id_reserva=$id";
echo "AKIII1";
fwrite($fp, $txxt);
fwrite($fp, ">> Hora TPV: ".$_POST["Ds_Date"]." ".$_POST["Ds_Hour"]."\n");
fwrite($fp, ">> Import: ".$_POST["Ds_Amount"]."\n");
fwrite($fp, ">> Moneda: ".$_POST["Ds_Currency"]."\n");
fwrite($fp, ">> Núm reserva: ".$_POST["Ds_Order"]."\n");
fwrite($fp, ">> Comerç: ".$_POST["Ds_MerchantCode"]."\n");
fwrite($fp, ">> Idioma: ".$_POST["Ds_ConsumerLanguage"]." ->Lang: ".$lang."\n");
fwrite($fp, ">> REBUT    >>>".$_POST["Ds_Signature"]."\n");
fwrite($fp, ">> S'ESPERA >>>".$signature."\n\n");
fwrite($fp, "**************************************************************\n");
fwrite($fp, ">> ID: ".$id."\n");

$resposta=(int)$_POST["Ds_Response"];
if (($_POST["Ds_Signature"]==$signature) && ($resposta>=0) && ($resposta<=99))
{
	fwrite($fp, "PAGAMENT AMB TARJA: RESERVA=$id, IMPORT=".$_POST["Ds_Amount"]."\n");
    $txxt="RESPOSTA-".date("d M Y H:i")."\n";  
    /******************************************************************************/	
   $query="UPDATE reserves SET estat=7 WHERE id_reserva=$id";
   $result=mysql_query($query,$canborrell);  
   if ($result) 
   {
	fwrite($fp, "PAGAMENT TARJA id: $id >> QUERY: ".$query."\n"); }
   else
   {
    fwrite($fp, ">> PAGAMENT TARJA id: $id >> QUERY: ERROR EXECUTANT QUERY\n"); }

   fwrite($fp,"PAGAMENT RESERVA INI ENVIO MAILCLI: $id\n");
    $r=mail_cli($id, $lang); 
    fwrite($fp,"RESULTAT: $r\n");
    fwrite($fp,"PAGAMENT RESERVA INI ENVIO MAIL_REST: $id\n");
    $r=mail_restaurant($id);
    fwrite($fp,"RESULTAT: $r\n");
} 	
else
{
	if ($_POST["Ds_Signature"]!=$signature)     fwrite($fp, ">> ERROR SIGNATURE "); 

    fwrite($fp, ">> RESPOSTA NO VÀLIDA\n"); 
}

fwrite($fp, "**************************************************************\n");
fwrite($fp, ">> Resposta: ".$_POST["Ds_Response"]." \n");
fwrite($fp, "**************************************************************\n\n\n");
fclose($fp);

	
function mail_cli($id=false,$lang="esp")
{          
    global $camps,$txt,$mmenu,$database_canborrell, $canborrell,$test_mail;

    if ($id)
    {
        $query="SELECT * FROM reserves WHERE id_reserva=$id";
    }else{
        $query="SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";
    }

    /******************************************************************************/	
    $Result = mysql_query($query, $canborrell) or die(mysql_error());
    $fila=mysql_fetch_assoc($Result);
		$attach='';
	
	/*** ENVIA SMS ***/
	$SMS="HEMOS RECIBIDO CONFIRMACION DE PAGO DE LA RESERVA ".$id." PARA EL DIA ".$fila['data']." TE ESPERAMOS EN CAN-BORRELL!";
	$g=new gestor_reserves();
	$g->enviaSMS($id, $SMS);

    switch ((int)$fila['estat'])
    {
      case 2:
        $v=10;      
        $aki="<a href='http://www.can-borrell.com/editar/pagament.php?id=".$fila["id_reserva"]."' class='dins'>AQUI</a>";
        exit();
      break;

      case 3:
      case 7:
        $v=20;
        $preu=$fila['preu_reserva'];
        $datat=data_llarga($fila['data'],$lang).", ".$fila['hora']."h";
		if ($fila['factura']) $attach=factura($fila,"../../");
      break;

      case 4:
        $v=30;
        $aki="<a href='http://www.can-borrell.com/cat/contactar.php?id=".$fila["id_reserva"]."' class='dins'>AQUI</a>";
        exit();
      break;
      
      default:
         return 0;
      break;
    }


    $avui=date("d/m/Y");
    $ara=date("H:i");

    $file="../templates/mail_cli.lbi";


            $t=new Template('.','comment');
            $t->set_file("page", $file);

    ///////////// TEXTES
            $t->set_var('avui',$avui);
            $t->set_var('titol',$txt[$v][$lang]);
            $t->set_var('text1',$txt[$v+1][$lang]);
            $t->set_var('text2',$txt[$v+2][$lang]);
            $t->set_var('contacti',$txt[9][$lang]);
            $t->set_var('import',$preu);
            $t->set_var('aki','');
            $t->set_var('datat',$datat);

            $t->set_var('cdata_reserva',$camps[8][$lang]);
            $t->set_var('cnom',$camps[1][$lang]);
            $t->set_var('cadults',$camps[2][$lang]);
            $t->set_var('cnens10_14',$camps[3][$lang]);
            $t->set_var('cnens4_9',$camps[4][$lang]);
            $t->set_var('ccotxets',$camps[5][$lang]);
            $t->set_var('cobservacions',$camps[6][$lang]);
            $t->set_var('cpreu_reserva',$camps[7][$lang]);
            

            
    //////////// DADES RESERVA
            $t->set_var('id_reserva',$fila['id_reserva']);
            $t->set_var('data',data_llarga($fila['data'],$lang));
            $t->set_var('hora',substr($fila['hora'],0,5));
            $t->set_var('nom',$fila['nom']);
            $t->set_var('tel',$fila['tel']);
            $t->set_var('fax',$fila['fax']);
            $t->set_var('email',$fila['email']);
            $m=(int)$fila['menu'];
            $n=$mmenu[$m]['cat'];

                                    ///// COMANDA
            $comanda=$g->plats_comanda($fila['id_reserva']);
           if ($comanda) $n=$comanda;
            else   $n=$mmenu[$m]['cat'];
            
            
            $t->set_var('menu',$n);
            $t->set_var('adults',(int)$fila['adults']);
            $t->set_var('nens10_14',(int)$fila['nens10_14']);
            $t->set_var('nens4_9',(int)$fila['nens4_9']);
             //$t->set_var('txt_1'," menú: ".$fila['txt_1']);
            //$t->set_var('txt_2'," menú: ".$fila['txt_2']);
            $t->set_var('txt_1',"");
            $t->set_var('txt_2',"");
            $t->set_var('cresposta',$txt[79][$lang]);
            $t->set_var('resposta',$fila['resposta']);
            $t->set_var('cotxets',(int)$fila['cotxets']);
            $t->set_var('observacions',$fila['observacions']);
            $t->set_var('preu_reserva',$fila['preu_reserva']);
				            
            $t->parse("OUT", "page");
            $html=$t->get("OUT");
            $ini_file = "TPV.txt";	

	$recipient=$fila['email'];
    $subject="Can-Borrell: CONFIRMACIÓ DE PAGAMENT DE RESERVA PER GRUP";
    $altbdy="El pago de la reserva se ha realizado correctamente.";
		$r=mailer($recipient, $subject , $html, $altbdy,$attach,$test_mail)?"...OK":"KO!!!!";
		if ($test_mail) $r="OK_TEST";
    $nreserva=$fila['id_reserva'];
 	$att=$attach?" -- FACTURA: $attach":"";
	print_log("TPV: Enviament  mail CLIENT($r) id_reserva: $nreserva -- $recipient, $subject: PAGAMENT OK **** $v");

    mysql_free_result($Result);
    return ($fila['id_reserva']);                                          
}

function mail_restaurant($id=false)                                                                                                                                
{     
    $lang="cat";
    global $camps, $mmenu,$txt,$database_canborrell, $canborrell,$test_mail;
    if ($id)
    {
        $query="SELECT * FROM reserves WHERE id_reserva=$id";
    }else{
        $query="SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";

    }

    /******************************************************************************/	

    /******************************************************************************/	
    $Result = mysql_query($query, $canborrell) or die(mysql_error());
    $fila=mysql_fetch_assoc($Result);

    $avui=date("d/m/Y");
    $ara=date("H:i");
    $file="../templates/pagat_rest.lbi";


            $t=new Template('.','comment');
            $t->set_file("page", $file);

    ///////////// TEXTES
            $t->set_var('avui',$avui);
            $t->set_var('titol',$txt[10][$lang]);
            $t->set_var('text1',$txt[11][$lang]);
            $t->set_var('text2',$txt[12][$lang]);
            $t->set_var('contacti',$txt[22][$lang]);

            $t->set_var('cdata_reserva',$camps[8][$lang]);
            $t->set_var('cnom',$camps[1][$lang]);
            $t->set_var('cadulst',$camps[2][$lang]);
            $t->set_var('cnens10_14',$camps[3][$lang]);
            $t->set_var('cnens4_9',$camps[4][$lang]);
            $t->set_var('ccotxets',$camps[5][$lang]);
            $t->set_var('cobservacions',$camps[6][$lang]);
            $t->set_var('cpreu_reserva',$camps[7][$lang]);
            

            
    //////////// DADES RESERVA
            $t->set_var('id_reserva',$fila['id_reserva']);
            $t->set_var('data',data_llarga($fila['data']));
            $t->set_var('hora',substr($fila['hora'],0,5));
            $t->set_var('nom',$fila['nom']);
            $t->set_var('tel',$fila['tel']);
            $t->set_var('fax',$fila['fax']);
            $t->set_var('email',$fila['email']);
            $m=(int)$fila['menu'];
            $n=$mmenu[$m]['cat'];
            
            
                                    ///// COMANDA
            $gestor=new gestor_reserves();
            $comanda=$gestor->plats_comanda($fila['id_reserva']);
           if ($comanda) $n=$comanda;
            else   $n=$mmenu[$m]['cat'];

            $t->set_var('menu',$n);
            $t->set_var('adults',(int)$fila['adults']);
            $t->set_var('nens10_14',(int)$fila['nens10_14']);
            $t->set_var('nens4_9',(int)$fila['nens4_9']);
            //$t->set_var('txt_1'," menú: ".$fila['txt_1']);
            //$t->set_var('txt_2'," menú: ".$fila['txt_2']);
            $t->set_var('txt_1',"");
            $t->set_var('txt_2',"");
            $t->set_var('cresposta',$txt[79]['cat']);
            $t->set_var('resposta',$fila['resposta']);
            $t->set_var('cotxets',(int)$fila['cotxets']);
            $t->set_var('observacions',$fila['observacions']);
            $t->set_var('preu_reserva',$fila['preu_reserva']);
				            
            $t->parse("OUT", "page");
            $html=$t->get("OUT");
    //        $t->p("OUT"); 
//////////////////
//////////////////
    
    $subject="Can-Borrell: CONFIRMACIÓ DE PAGAMENT DE RESERVA PER GRUP";
    $altbdy="S'ha registrat el pagament de la reserva ".$fila['id_reserva'];
	
    $recipient = MAIL_RESTAURANT;  

    //$recipient = "tpv@can-borrell.com";  
    $r=mailer($recipient, $subject, $html, $altbdy,false,$test_mail)?"...OK":"KO!!!!";
	if ($test_mail) $r="OK_TEST";
	$nreserva=$fila['id_reserva'];
    print_log("TPV: MAIL ($recipient ($r)) Confirmació pagament tarja. id_reserva: $nreserva -- $recipient, $subject: RESERVA PAGADA");    


    mysql_free_result($Result);
    return ($fila['id_reserva']);
}
?>
