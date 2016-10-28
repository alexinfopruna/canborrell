<?php
if (!defined('MAIL_RESTAURANT')) define('MAIL_RESTAURANT','restaurant@can-borrell.com');

$mmenu[0]["cat"]="Menú nº1";
$mmenu[1]["cat"]="Menú nº1 Celebració";
$mmenu[2]["cat"]="Menú nº2";
$mmenu[3]["cat"]="Menú nº2 Celebració";
$mmenu[4]["cat"]="Menú nº3";
$mmenu[5]["cat"]="Menú Calçotada";
$mmenu[6]["cat"]="Menú Comunió";
$mmenu[7]["cat"]="Menú Casament";
$mmenu[8]["cat"]="Carta";
$mmenu[9]["cat"]="Menú nº4";
$mmenu['jr_comu']["cat"]="Menú comunió jr.";
$mmenu['juinior']["cat"]="Menú júnior";
$mmenu['jr_casa']["cat"]="Menú casament jr.";


$mmenu[0]["esp"]="Menú nº1";
$mmenu[1]["esp"]="Menú nº1 Celebración";
$mmenu[2]["esp"]="Menú nº2";
$mmenu[3]["esp"]="Menú nº2 Celebración";
$mmenu[4]["esp"]="Menú nº3";
$mmenu[5]["esp"]="Menú Calçotada";
$mmenu[6]["esp"]="Menú Comunión";
$mmenu[7]["esp"]="Menú Bodas";
$mmenu[8]["esp"]="Carta";
$mmenu[9]["esp"]="Menú nº4";
$mmenu['jr_comu']["esp"]="Menú comunión jr.";
$mmenu['juinior']["esp"]="Menú júnior";
$mmenu['jr_casa']["esp"]="Menú boda jr.";
 

 
/*
// OBSOLETO: PREUS CHEFF 
$tmenu[0]="menu1_1";
$tmenu[1]="menu1c_1";
$tmenu[2]="menu2_1";
$tmenu[3]="menu2c_1";
$tmenu[4]="menu3_1";
$tmenu[9]="menu4_1";
$tmenu[5]="menuc_1";
$tmenu[6]="menucomu_1";
$tmenu[7]="menucasam_1";
$tmenu["infantil"]="menu1_3";
$tmenu["inf_comu"]="menucomu_2";
$tmenu["inf_casa"]="menucasam_2";
$tmenu["junior"]="menu1_4";
$tmenu["jr_comu"]="menucomu_3";
$tmenu["jr_casa"]="menucasam_3";
*/
$menuId[0]=2001;
$menuId[1]=2024;
$menuId[2]=2003;
$menuId[3]=2023;
$menuId[4]=2012;
$menuId[9]=2007;
$menuId[5]=2010;
$menuId[6]=2013;
$menuId[7]=2016;
$menuId["infantil"]=2037;
$menuId["inf_comu"]=2017;
$menuId["inf_casa"]=2021;
$menuId["junior"]=2036;
$menuId["jr_comu"]=2018;
$menuId["jr_casa"]=2022;
$menuId["NO"]=0;

$estat[1]="Pendent";
$estat[2]="Confirmada";
$estat[3]="Pagada<br>TRANFERÈNCIA";
$estat[4]="Denegada";
$estat[5]="Eliminada";
$estat[6]="Caducada";
$estat[7]="Pagada<br>TARJA";
$estat[0]="ERROR";

$color[1]="#FF3300";
$color[2]="#FFCC00";
$color[3]="#33CC33";
$color[4]="#886666";
$color[5]="#555555";
$color[6]="#777777";
$color[7]="#33CC33";
$color[0]="#FF33FF";


$camps[1]['cat']="nom";
$camps[1]['esp']="nombre";
$camps[2]['cat']="adults";
$camps[2]['esp']="adultos";
$camps[3]['cat']="nens de 10 a 14";
$camps[3]['esp']="niños de 10 a 14";
$camps[4]['cat']="nens de 4 a 9";
$camps[4]['esp']="niños de 4 a 9";
$camps[5]['cat']="cotxets nadó";
$camps[5]['esp']="cochecito bebé";
$camps[6]['cat']="observacions";
$camps[6]['esp']="observaciones";
$camps[7]['cat']="preu reserva";
$camps[7]['esp']="precio reserva";
$camps[8]['cat']="data reserva";
$camps[8]['esp']="fecha reserva";


$txt[0]['cat']="Moltes gràcies. La reserva ha estat enviada a Can Borrell. Rebrà un correu electrònic a ";
$txt[1]['cat']=" amb la confirmació de la reserva i les instruccions per fer el pagament.";
$txt[2]['cat']="LA RESERVA NO SERÀ EFECTIVA FINS QUE REBI EL CORREU I REALITZI EL PAGAMENT";

$txt[0]['esp']="Muchas gracias. La reserva ha sido enviada a Can Borrell. Recibirá un correo electrónico en ";
$txt[1]['esp']=" con la confirmación de la reserva y las instrucciones para realizar el pago.";
$txt[2]['esp']="LA RESERVA NO SERÁ EFECTIVA HASTA QUE RECIVA EL CORREO Y REALICE EL PAGO";

$txt[10]['cat']="CONFIRMACIÓ RESERVA";
$txt[11]['cat']="Ens complau informar-lo que la seva reserva ha estat confirmada. Per finalitzar el procès accedeixi al sistema de pagament fent click ";
$txt[12]['cat']="El pagament es pot realitzar fins el ";
$txt[13]['cat']=". <b>Després d'aquesta data la reserva deixa de ser vàlida</b>.";

$txt[10]['esp']="CONFIRMACIÓN RESERVA";
$txt[11]['esp']="Nos complace informarle que su reserva ha sido confirmada, Para finalizar el proceso acceda al sistema de pago haciendo click ";
$txt[12]['esp']="El pago se podré realizar hasta el ";
$txt[13]['esp']=". <b>Pasada esta fecha la reserva dejará de ser válida</b>.";

$txt[20]['cat']="CONFIRMACIÓ DE PAGAMENT DE RESERVA";
$txt[21]['cat']="Ens complau informar-lo que hem rebut correctament el pagament de ";
$txt[22]['cat']="€ La seva reserva queda registrada.<br><br>L'esperem el proper ";

$txt[20]['esp']="CONFIRMACIÓN DE PAGO DE RESERVA";
$txt[21]['esp']="Nos complace informarle que hemos recibido correctamente el pago de ";
$txt[22]['esp']="€. Su reserva queda registrada<br>Le esperamos el próximo ";

$txt[30]['cat']="DENEGACIÓ DE RESERVA";
$txt[31]['cat']="Ho sentim, la seva sol·licitud ha estat denegada perquè no hi ha prou espai pels coberts que ha sol·licitat per aquest dia. Si ho desitja pot fer la reserva per una altra data fent click <a href='http://www.can-borrell.com/cat/contactar.php' class='dins'><aquí></a>";
$txt[32]['cat']="";

$txt[30]['esp']="DENEGACIÓN RESERVA";
$txt[31]['esp']="Lo sentimos, su solicitud ha sido denegada porque no hay espacio suficiente para los cubiertos que ha solicitado para este dia. Si lo desea puede hacer la reserva para otra fecha haciendo click <a href='http://www.can-borrell.com/esp/contactar.php' class='dins'><aquí></a>";
$txt[32]['esp']="";

$txt[9]['cat']="Si té qualsevol dubte posi's en contacte amb nosaltres a <a href='mailto: ".MAIL_RESTAURANT."' class='dins'>".MAIL_RESTAURANT."</a> ";
$txt[9]['esp']="Si tiene cualquier duda póngase en contacto con nosotros en <a href='mailto: ".MAIL_RESTAURANT."' class='dins'>".MAIL_RESTAURANT."</a> ";

$txt[40]['cat']="Per finalitzar el procès de reserva, cal que realitzi el pagament de l'import de la reserva. Per reserves online, el restaurant només admet pagaments amb tarja de crèdit.
<br/>Faci click al botó i el transferirem directament al terminal de comerç electrònic de 'La Caixa'.";
$txt[40]['esp']="Para finalizar el proceso de reserva, es necesario que realice el pago del importe de la reserva. Para reservas online, el restaurant sólo adminte pagos con tarjeta de crédito. Haga click sobre el botón y le transferiremos directamente al terminal de comercio electrónico de 'La Caixa'";
$txt[41]['cat']="";
$txt[41]['esp']="";


$txt[50]['cat']="RECORDATORI DE PAGAMENT DE RESERVA";
$txt[51]['cat']="Li recordem que per confirmar la seva reserva al Restaurant Can Borrell ha d'efectuar el pagament abans del<br>";
$txt[52]['cat']="Si desitja realitzar el pagament amb tarja de crèdit faci click ";

$txt[50]['esp']="RECORDATORIO DE PAGO DE RESERVA";
$txt[51]['esp']="Le recordamos que para confirmar su reserva en el Restaurante Can Borrell ha de realizar el pago antes del<br>";
$txt[52]['esp']="Si desea realizar el pago con targeta de crédito, haga click ";



$txt[75]['cat']="";
$txt[75]['esp']="";
$txt[76]['cat']="";
$txt[76]['esp']="";
$txt[75]['ANULAT_cat']="</br>Si prefereix fer el pagamanent per transferència o ingrès en efectiu, si us plau, <b>FACI-HO ABANS DE LA DATA INDICADA</b>, i indiqui com a concepte aquest identificador de reserva: ";
$txt[75]['ANULAT_esp']="</br>Si prefiere pagar por transferencia o ingreso en efectivo, por favor, <b>HAGALO ANTES DE LA FECHA INDICADA</b>, e indique como concepto el siguiente identificador de reserva: ";
$txt[76]['ANULAT_cat']="</br>Un cop fet l'ingrès comuniquin's el pagament fent click aquí.<br>NO OBLIDI PORTAR EL JUSTIFICANT DE L'INGRÈS PER TAL QUE LI DESCOMPTEM L'IMPORT ABONAT PER LA RESERVA QUAN PASSI PER CAIXA AL RESTAURANT";
$txt[76]['ANULAT_esp']="</br>Una vez realizado el ingreso, comnuníquenos el pago haciendo click aqui.<br>NO OLVIDE LLEVAR EL JUSTIFICANTW DEL INGRESO PARA QUE LE DESCONTEMOS EL IMPORTE ABONADO POR LA RESERVA CUANDO PASE POR CAJA EN EL RESTAURANT";
$txt[77]['cat']="</br>Si decideix cancel·lar la reserva, faci click aquí";
$txt[77]['esp']="</br>Si decide cancelar la reserva, haga click aquí";

$txt[79]['cat']="RESPOSTA";
$txt[79]['esp']="RESPUESTA";

$txt[80]['cat']="Si us plau, NO FACI EL PAGAMENT PASSADA AQUESTA DATA, donat que un cop caduca la reserva no podem garantir que la taula segueixi disponible";
$txt[80]['esp']="Por favor, NO REALICE EL PAGO PASADA ESTA FECHA, ya que una vez caducada la reserva no podemos garantizar que la mesa siga disponible";

$txt[81]['cat']="La reserva pel %diaReserva caduca avui. Per confirmar faci ingres de %importReserva E a NC.2059-0280-45-8000215539 (indiqui ref:%idReserva). INGRES NO VALID DESPRES D'AVUI. +info:can-borrell.com/reserva.php?%idReserva";
$txt[81]['esp']="La reserva del %diaReserva caduca hoy. Para confirmar haga ingreso de %importReserva E al NC.2059-0280-45-8000215539 (indique ref:%idReserva). INGRESO NO VALIDO DESPUES HOY. +info:can-borrell.com/reserva.php?%idReserva";
/////////////////////////////////////////////////////
//FACTURA PROFORMA
/////////////////////////////////////////////////////
$txt[81]['cat']="FACTURA PROFORMA";
$txt[81]['esp']="FACTURA PROFORMA";
$txt[82]['cat']="La present factura proforma només té validesa fins a l'emisió de la factura definitiva en fer el pagament dels menús al restaurant";
$txt[82]['esp']="La presente factura proforma sólo tiene validez hasta la emisión de la factura definitiva tras realizar el pago de los menús en el restaurant";
$txt[83]['cat']="En el moment d'emetre's aquesta factura proforma, l'import abonat és el de la reserva";

$txt[83]['esp']="En el momento de emitirse esta factura proforma, el importe abonado es el de la reserva";
$txt[90]['cat']="i no l'import total indicat, que serà abonat directament al restaurant el dia reservat (descomptant l'import de la reserva) 
<br/>El preu total que s'indica és una estimació basada en les dades introduïdes al formulari de reserva, i pot variar segons les consumicions que es realitzin el dia de l'event.";
$txt[90]['esp']=" i no el importe total indicado, que será abonado directamente en el restaurante el dia reservado (descontando el importe de la reserva) 
<br/>El precio total que se indica es una estimación basada en los datos introducidos en el formulario de reserva, y podrá variar según las consumiciones que se realicen el día del evento.";
$txt[84]['cat']="Adreça";
$txt[84]['esp']="Dirección";
$txt[85]['cat']="Import abonat (reserva)";
$txt[85]['esp']="Importe abonado (reserva)";
$txt[86]['cat']="Subtotal";
$txt[86]['esp']="Subtotal";
$txt[87]['cat']="IVA";
$txt[87]['esp']="IVA";
$txt[88]['cat']="Import total";
$txt[88]['esp']="Importe total";
$txt[89]['cat']="Data";
$txt[89]['esp']="Fecha";
$txt[91]['cat']="Client";
$txt[91]['esp']="Cliente";
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

$txt[92]['cat']="";
$txt[92]['esp']="";
$txt[93]['cat']="";
$txt[9393]['esp']="";
$txt[94]['cat']="";
$txt[94]['esp']="";
$txt[95]['cat']="";
$txt[95]['esp']="";
$txt[96]['cat']="";
$txt[96]['esp']="";
$txt[97]['cat']="";
$txt[97]['esp']="";
$txt[98]['cat']="";
$txt[98]['esp']="";
$txt[99]['cat']="";
$txt[99]['esp']="";
$txt[100]['cat']="";
$txt[100]['esp']="";
$txt[101]['cat']="";
$txt[101]['esp']="";
$txt[102]['cat']="";
$txt[102]['esp']="";
$txt[103]['cat']="";
$txt[103]['esp']="";
$txt[104]['cat']="";
$txt[104]['esp']="";
$txt[105]['cat']="";
$txt[105]['esp']="";
$txt[106]['cat']="";
$txt[106]['esp']="";
$txt[107]['cat']="";
$txt[107]['esp']="";
$txt[108]['cat']="";
$txt[108]['esp']="";
$txt[109]['cat']="";
$txt[109]['esp']="";
$txt[110]['cat']="";
$txt[110]['esp']="";
$txt[111]['cat']="";
$txt[111]['esp']="";
$txt[112]['cat']="";
$txt[112]['esp']="";
$txt[113]['cat']="";
$txt[113]['esp']="";
$txt[114]['cat']="";
$txt[114]['esp']="";
$txt[115]['cat']="";
$txt[115]['esp']="";
$txt[116]['cat']="";
$txt[116]['esp']="";
$txt[117]['cat']="";
$txt[117]['esp']="";
$txt[118]['cat']="";
$txt[118]['esp']="";
$txt[119]['cat']="";
$txt[119]['esp']="";

/******************************************************************************************************/


/******************************************************************************************************/
/******************************************************************************************************/
// FUNCIONS GLOBALS
/******************************************************************************************************/
/******************************************************************************************************/
function calcula_preu($persones=null)
{
  $preu=6;
  //  24/11/2009 REBAIXES: les reserves eren 6euros (<25pers) i 10euros (>25)
  //  ara queda per 4 i 7
  
  if ($persones==null) $persones=$_POST['adults']+$_POST['nens10_14']+$_POST['nens4_9'];
  
  if ($persones<=25)
  {
    $preu=4*$persones;
  }
  else
  {
    $preu=7*$persones;
  }
  $preu=sprintf("%01.2f",$preu);
 return($preu);
}

function calcula_preu_real($fila,$doc_root)
{
	require_once(ROOT."Carta.php");
	$carta=new Carta();
	
	global $menuId;
	//global $tmenu;
	//$ini_array = parse_ini_file($doc_root."canborrellxxx.ini");// OBSOLETO -> Preus CHEF
	
	
	$menuAdults=$menuId[(int)$fila['menu']];
	$menuJR=isset($menuId[$fila['txt_1']])?$menuId[$fila['txt_1']]:'';
	$menuINF=isset($menuId[$fila['txt_2']])?$menuId[$fila['txt_2']]:'';
	$preu= $carta->preuPlat($menuAdults)*$fila['adults'] + 	$carta->preuPlat($menuJR)*$fila['nens10_14'] +  	$carta->preuPlat($menuINF)*$fila['nens4_9'];
	$reserva=$fila['preu_reserva'];
	$preu=($preu >= $reserva)? $preu:$reserva;
	$preu=sprintf("%01.2f",$preu);
	return $preu;

}

function factura($fila,$doc_root,$out=false)
{
	require_once(ROOT."Carta.php");
	$carta=new Carta();
	
	global $txt,$lang, $camps,$mmenu;
	// CALCULA PREU

	$avui=date("d/m/Y");
	$file=$doc_root."editar/templates/factura_cli.lbi";
	$t=new Template('.','comment');
	$t->set_file("page", $file);
	$t->set_var("titol","FACTURA PROFORMA");
	$t->set_var("id_reserva",date("Y")."-".$fila['id_reserva']);
	$t->set_var("cdata_reserva",$txt[89][$lang]);    $t->set_var("data",$avui);
	$t->set_var("cif",$fila['factura_cif']);
	$t->set_var("cnom",$txt[91][$lang]);    $t->set_var("nom",$fila['factura_nom']);
	$t->set_var("cadresa",$txt[84][$lang]);    $t->set_var("adresa",$fila['factura_adresa']);

	global $menuId;
	//global $tmenu;
	//$ini_array = parse_ini_file($doc_root."canborrellxxx.ini");	 //OBSOLETO -> PREUS CHEF
	$menuAdults=$menuId[(int)$fila['menu']];
	$menuJR=$menuId[$fila['txt_1']];
	$menuINF=$menuId[$fila['txt_2']];
	 //+ 	$ini_array[$menuJR]*$fila['nens10_14'] +  	$ini_array[$menuINF]*$fila['nens4_9'];


	$m=(int)$fila['menu'];
	$n=$mmenu[$m]['cat'];
	$t->set_var('menu',$n." (".$carta->preuPlat($menuAdults)."&euro;)");	$t->set_var('totadults',sprintf("%01.2f",$carta->preuPlat($menuAdults)*$fila['adults']));
	$t->set_var('cadults',$camps[2][$lang]);   $t->set_var('adults',(int)$fila['adults']);
	if ($fila['nens10_14']>0)
	{
		$t->set_var('cnens10_14',$camps[3][$lang]);  
		$t->set_var('nens10_14',(int)$fila['nens10_14']." x ".$fila['txt_1']." (".$carta->preuPlat($menuJR)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuJR)*$fila['nens10_14']));  
	}	
	
	if ($fila['nens4_9']>0) 
	{
		$t->set_var('cnens4_9',$camps[4][$lang]);
		$t->set_var('nens4_9',(int)$fila['nens4_9']." x ".$fila['txt_2']." (".$carta->preuPlat($menuINF)."&euro;) = ".sprintf("%01.2f &euro;",$carta->preuPlat($menuINF)*$fila['nens4_9']));  
	}
			
	$t->set_var("cpreu_reserva",$txt[85][$lang]);$t->set_var("preu_reserva",calcula_preu($fila['adults']+$fila['nens10_14']+$fila['nens4_9']));
	$t->set_var("cpreu_subtotal",$txt[86][$lang]); $t->set_var("preu_subtotal",$preu=calcula_preu_real($fila,$doc_root));
	$t->set_var("cpreu_iva",$txt[87][$lang]);   $t->set_var("preu_iva",sprintf("%01.2f",$preu*IVA/100));
	$t->set_var("cpreu_total",$txt[88][$lang]); $t->set_var("preu_total",sprintf("%01.2f",$preu*(1+IVA/100)));
	
	
	
	$t->set_var("nota1",$txt[82][$lang]);
	$t->set_var("nota2",$txt[83][$lang]);
	$t->set_var("nota3",$txt[90][$lang]);
	$t->parse("OUT", "page");
	$html=$t->get("OUT");
	if ($out)$t->p("OUT");
	
	//$html=iconv("UTF-8", "ISO-8859-1", $html);
	/*
	$html=utf8_decode($html);
	echo "<br/>";
	echo "<br/>";
	echo $html;
	echo "<br/>";
	echo "<br/>";
	*/
	define('RELATIVE_PATH',$doc_root.'editar/fpdf/');
	include_once (RELATIVE_PATH.'html2fpdf.php');
	

	$pdf = new HTML2FPDF(); // Creamos una instancia de la clase HTML2FPDF
	$pdf -> AddPage(); // Creamos una página
	
	$html=fpdf_text($html); //CHARSET
	
	$pdf -> WriteHTML($html);//Volcamos el HTML contenido en la variable $html para crear el contenido del PDF
	//$carpeta_factures=$doc_root."editar/factures/";
	$carpeta_factures=$doc_root."editar/".INC_FILE_PATH."factures/";
	$nompdf=$carpeta_factures.NOM_FACTURA.date("Y")."-".$fila['id_reserva'].".pdf";
	$pdf -> Output($nompdf,"F");//Volcamos el pdf generado con nombre 'doc.pdf'. En este caso con el parametro 'D' forzamos la descarga del mismo.

	
	//$fila['id_reserva']=325;
	
	return $nompdf;
}

function fpdf_text($str){
	return iconv('UTF-8', 'windows-1252', $str);
}

?>
