<?php 
header('Content-Type: text/html; charset=utf-8');

define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");
//require_once (ROOT."Configuracio.php");

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true) header("Location:fora_de_servei.html");

define("LLISTA_DIES_NEGRA",INC_FILE_PATH."llista_dies_negra_online.txt");
define("LLISTA_DIES_BLANCA",INC_FILE_PATH."llista_dies_blanca.txt");
define("LLISTA_NITS_NEGRA",INC_FILE_PATH."llista_dies_negra_online.txt");


define('USR_FORM_WEB',3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE


$ruta_lang="../";
/**/
// ERROR HANDLER
//require_once("../taules/php/error_handler.php");

// CREA USUARI ANONIM AMB PERMISOS PER CREAR RESERVA
if (!isset($_SESSION)) session_start();
$usr=new Usuari(USR_FORM_WEB,"webForm",1);
if (!isset($_SESSION['uSer'])) {
	$_SESSION['uSer']=$usr;
}

$_SESSION['admin_id']=$_SESSION['uSer']->id;
$_SESSION['permisos']=$_SESSION['uSer']->permisos;

require_once("Gestor_form.php");
$gestor=new Gestor_form();

require_once(INC_FILE_PATH.'alex.inc');
require_once(INC_FILE_PATH."llista_dies_taules.php");


//RECUPERA IDIOMA
if (!isset($_REQUEST["lang"])) $_REQUEST["lang"]="";
$lang=$gestor->idioma($_REQUEST["lang"]);
$l=$gestor->lng;


//RECUPERA CONIG ANTIC
$PERSONES_GRUP=$gestor->configVars("persones_grup");
define("PERSONES_GRUP",$PERSONES_GRUP);
$max_nens=$gestor->configVars("max_nens");
$max_juniors=$gestor->configVars("max_juniors");
//die($max_juniors);
//echo CREA_TAULES;
//die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
<TITLE> Masia Can Borrell </TITLE>
<!-- <?php echo $gestor->configVars("url_base"); ?> -->
<!-- <?php echo $gestor->configVars("INC_FILE_PATH"); ?> -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
<link type="text/css" href="css/jquery.tooltip.css" rel="stylesheet" />	
<link type="text/css" href="../estils.css" rel="stylesheet" />	
<link type="text/css" href="css/form_reserves.css" rel="stylesheet" />		
	
	


<noscript><meta http-equiv="refresh" content="0; nojscript.html"/></noscript>

<!--		
<script type="text/javascript">
			document.write("\<script src='//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'>\<\/script>");
		</script>	
--> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
			
		<!--<script type="text/javascript" src="../taules/js/jquery-1.5.min.js"></script>-->
		<script type="text/javascript" src="../taules/js/ui/js/jquery-ui-1.8.9.custom.min.js"></script>
		<script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
		<script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-es.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.metadata.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.timers.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.form.js"></script>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/json2.js"></script>
		<script type="text/javascript" src="../js/dynmenu.js"></script>
		<script type="text/javascript" src="js/jquery.amaga.js"></script>
		<script type="text/javascript" src="js/jquery.tooltip.js"></script>
<!--[if lt IE 7]>
     <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]-->		
<!--
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
-->
<?php
require_once('translate_'.$gestor->lng.'.php');

/*********************************************************/
	//ELIMINA RESERVA 
if (isset($_POST['cancel_reserva']) && $_POST['cancel_reserva']=="Eliminar reserva" && $_POST['idr']>SEPARADOR_ID_RESERVES)
{
	if ($gestor->cancelReserva($_POST['mob'],$_POST['idr']))
	{
		l("RESERVA_CANCELADA");
		$_REQUEST['idr']=$_POST['idr']=null;
	}
	else
	{
		l("ERROR_CANCEL_RESERVA");
		$_REQUEST['idr']=$_POST['idr']=null;
	}
	
	//header("Location: ../on.html");
}

	
/*********************************************************/
	//RECUPERA RESERVA UPDATE
	if (isset($_POST['Submit']) && $_POST['Submit']=="Editar reserva")
	{
		if (isset($_POST['idr']) && $_POST['idr']>SEPARADOR_ID_RESERVES ) //si es reserva de grups
		{
			$row=$gestor->recuperaReserva($_POST['mob'],$_POST['idr']);
			if (!$row) 
			{
				l("ERROR_LOAD_RESERVA");
				$_REQUEST['idr']=$_POST['idr']=null;
			}
		}
	}
	else{
		$row['id_reserva']=null;
		$row['idr']=null;
		$row['adults']=null;
		$row['nens10_14']=null;
		$row['nens4_9']=null;
		$row['reserva_info']=null;
		$row['cotxets']=null;
		$row['comanda']=null;
		$row['client_telefon']=null;
		$row['client_mobil']=null;
		$row['client_email']=null;
		$row['client_nom']=null;
		$row['client_cognoms']=null;
		$row['client_id']=null;
		$row['data']=null;
		$row['hora']=null;
		$row['observacions']=null;
		//$row['']=null;
		
		$comanda=null;
	}
	
if (!isset($_POST['idr'])) $_POST['idr']=null;
$EDITA_RESERVA=$_POST['idr'];
	
echo $gestor->dumpJSVars(true);	
?>

<script type="text/javascript">
	var PERSONES_GRUP=<?php echo $PERSONES_GRUP;?>;
	var lang="<?php echo $lang;?>";
	<?php 
	//TRANSLATES

	$llista_negra=llegir_dies(LLISTA_DIES_NEGRA);
	print crea_llista_js($llista_negra,"LLISTA_NEGRA"); 
	print "\n\n";	
	
	$llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
	print crea_llista_js($llista_blanca,"LLISTA_BLANCA");  	
	
	$llista_dies_no_carta=llegir_dies(INC_FILE_PATH."llista_dies_no_carta.txt");
	print crea_llista_js($llista_dies_no_carta,"LLISTA_DIES_NO_CARTA");  	
	
	print "\nvar IDR='".$row['id_reserva']."';";
	print "var RDATA;";
	if (!empty($row['data'])) print "\nRDATA='".$gestor->cambiaf_a_normal($row['data'])."';";
	print "\nvar HORA='".$row['hora']."';";
	?>	
</script>

		<script type="text/javascript" src="js/control_carta.js";></script>
		<script type="text/javascript" src="js/form_reserves.js?<?php echo time();?>";></script>

</HEAD>
<BODY class="amagat <?php echo DEV?" dev ":""; echo LOCAL?" local ":"" ?>" onload="loadMenu()" >
<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775"  BORDER="0" align="center">
	<TR height="114">
		<TD BACKGROUND="../img/fons_9a.jpg" COLSPAN="2" ALIGN="RIGHT"><A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICI"></A></TD>
	</TR>
	<TR height="18">
		<TD BGCOLOR="#570600" COLSPAN="2" ALIGN="">
			<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="19" BORDER="0">
				<?php //require_once($ruta_lang."menu.php");?>
			</TABLE>
		</TD>
	</TR>
	<TR height="18">
		<TD id="td_contingut" BGCOLOR="#F8F8F0" COLSPAN="2" ALIGN="">
<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<!-- ********     EDITA RESERVA       ***********************************************************   -->
<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<?php 
if (!$EDITA_RESERVA) include("login.php"); 
if ($EDITA_RESERVA && $EDITA_RESERVA<SEPARADOR_ID_RESERVES && !isset($_POST['incidencia_grups']))	
{
	include("form_contactar_grups.php");
}
?>
<!-- *****************<div style="clear:both"></div>**********************************************************************   -->
<!-- ***************************************************************************************   -->

		
		
<!-- ***************************************************************************************   -->
<!-- ********     CONTACTE       ***********************************************************   -->
<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<?php 				
if (isset($_POST['incidencia_grups']))
{
	if (!$gestor->contactar_grups($_POST)) l("ERROR_CONTACTAR");
	else l("CONTACTAR_OK");	
	
	//die();
}elseif (isset($_POST['incidencia']))
	{
		if (!$gestor->contactar($_POST)) l("ERROR_CONTACTAR");
		else l("CONTACTAR_OK");	
	}
else include("form_contactar.php");?>

  					
<div style="clear:both"></div>
<h2 CLASS="titol titol1">
<?php  
if ($EDITA_RESERVA)
{
	l('Editant reserva ID');echo $EDITA_RESERVA;
	
	
	echo '<a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="'. l("Informació de reserves",false).'" style="width:16px;height:auto;margin-left:8px"/></a>';
	echo '<form id="fdelete" name="form1" method="POST" action="'.$_SERVER['PHP_SELF'].'">
	<input type="hidden" name="mob" value="'.$_REQUEST['mob'].'"/>
	<input type="hidden" name="idr" value="'.$_REQUEST['idr'].'"/>
	<input type="submit" id="cancel_reserva" name="cancel_reserva" value="Eliminar reserva" />
	</form>';
} 
else 
{
	l('Sol·licitud de reserva');
	echo '<a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="'. l("Informació de reserves",false).'" style="width:16px;height:auto;margin-left:8px"/></a>';
}
?>
</h2>

<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<form id="form-reserves" action="Gestor_form.php?a=submit" method="post" name="fr-reserves" accept-charset="utf-8"><!---->
	<input type="hidden" name="id_reserva" value="<?php echo isset($_REQUEST['idr'])?$_REQUEST['idr']:"";?>"/>
	<input type="hidden" name="reserva_info" value="<?php echo $row['reserva_info'];?>"/>
	<div id="fr-reserves" class="fr-reserves">
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		

		<div class="fr-seccio ui-corner-all fr-seccio-quants" style="max-width:950px;"> 
			<h1 class="titol"><span class="number">1</span><?php l('Quants sou?');?></h1>
			<h4><?php l('Adults (més de 14 anys)');?>:</h4>
			
			<!-- ******  ADULTS  ********   -->
			<div id="selectorComensals" class="fr-col-dere selector">
				<input type="hidden" id="com" name="adults" value="<?php echo $row['adults']?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>	
				<?php 
					for ($i=2;$i<$PERSONES_GRUP;$i++)
					{
						$chek=($i==$row['adults']?'checked="checked"':'');
						print '<input type="radio" id="com'.$i.'" name="selectorComensals" value="'.$i.'" '.$chek.'/><label for="com'.$i.'">'.$i.'</label>';
					}
				?>
				<input type="radio" id="comGrups" name="selectorComensals" value="grups"  /><label id="labelGrups" for="comGrups" style="font-size:1.2em"><?php l('Grups');?></label>
			</div>
				
			<div style="float:left">
				<!-- ******  JUNIOR  ********   -->
				<h4><?php l('Juniors (de 10 a 14 anys):');?></h4>
				 <input type="hidden" id="junior" name="nens10_14" value="<?php echo $row['nens10_14']?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>
				<div id="selectorJuniors" class="col_dere">
				<?php 
					for ($i=0;$i<=$max_juniors;$i++)
					{
						$chek=($i==$row['nens10_14']?'checked="checked"':'');
						$k=$i;if (!$i) $k=l("Cap",false);
						print '<input type="radio" id="junior'.$i.'" name="selectorJuniors" value="'.$i.'" '.$chek.'/><label for="junior'.$i.'">'.$k.'</label>';
						
					}
				?>
				</div>
				<!-- ******  NENS  ********   -->
				<h4><?php l('Nens (de 4 a 9 anys)');?>:</h4>
				<div id="selectorNens" class="col_dere">
				 <input type="hidden" id="nens" name="nens4_9" value="<?php echo $row['nens4_9']?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>
				<?php 
					for ($i=0;$i<=$max_nens;$i++)
					{
						$chek=($i==$row['nens4_9']?'checked="checked"':'');
						$k=$i;if (!$i) $k=l("Cap",false);
						print '<input type="radio" id="nens'.$i.'" name="selectorNens" value="'.$i.'" '.$chek.'/><label for="nens'.$i.'">'.$k.'</label>';
					}
				?>
				</div>
				<!-- ******  COTXETS  ********   -->
				<h4><?php l('Cotxets de nadó');?>:</h4>
				<div id="selectorCotxets" class="col_dere">
					<?php											
						$estat=$gestor->decodeInfo($row['reserva_info']);		

						$chek0=($row['cotxets']==0?'checked="checked"':'');
						$chek1=($estat['ampla']==0 && $row['cotxets']==1?'checked="checked"':'');
						$chek11=($estat['ampla']==2?'checked="checked"':'');
						$chek12=($estat['ampla']==3?'checked="checked"':'');
					?>
					<input type="radio" id="cotxets0" name="selectorCotxets" value="0"  <?php echo $chek0?> /><label for="cotxets0"><br/><?php l("Cap");?></label>
					<input type="radio" id="cotxets1" name="selectorCotxets" value="1"  <?php echo $chek1?>/><label for="cotxets1">1<br/> Simple</label>
					<?php
						for ($i=2;$i<=MAX_COTXETS;$i++)
							echo '<input type="radio" id="cotxets'.$i.'" name="selectorCotxets" value="'.$i.'"  '.($i==$row['cotxets']?'checked="checked"':'').' /><label for="cotxets'.$i.'">'.$i.'<br/> Simples</label>';

					?>
					<input type="radio" id="cotxets2A" name="selectorCotxets" value="1"  <?php echo $chek11?>/><label for="cotxets2A">1<br/><?php l("Doble ample");?></label>
					<input type="radio" id="cotxets2L" name="selectorCotxets" value="1"  <?php echo $chek12?>/><label for="cotxets2L">1<br/><?php l("Doble llarg");?></label>
					
				</div>
				<input type="hidden" name="amplaCotxets" value="<?php echo $estat['ampla']?>" /> 
				
				<!--  -->
				<h4><?php l('Cadira de rodes');?>:</h4>
				<div id="selectorCadiraRodes" class="col_dere">
					<?php	
						$estat=$gestor->decodeInfo($row['reserva_info']);
						$chek0=($estat['cadiraRodes']==0?'':'checked="checked"');
						$chek1=($estat['accesible']==0?'':'checked="checked"');
					?>
					<input type="checkbox" id="accesible" name="selectorAccesible" value="on"  <?php echo $chek1?> /><label for="accesible"><?php l("Algú amb movilitat reduïda");?></label>
					<input type="checkbox" id="cadira0" name="selectorCadiraRodes" value="on"  <?php echo $chek0?> /><label for="cadira0"><?php l("Portem una cadira de rodes");?></label>
				</div>
				
			</div>		
				<!-- ******  INFO  ********   -->
				<div class="caixa dere ui-corner-all"><?php l('INFO_QUANTS_SOU');?>
					 <input type="text" name="totalComensals" value="<?php echo $row['adults']+$row['nens10_14']+$row['nens4_9']?>" readonly="readonly"/></b>
					 <input type="text" name="totalCotxets" value="<?php echo $row['cotxets']?"/ ".$row['cotxets']:""?>" readonly="readonly"/></b>
					<!--Tingue's present que si vols modificar aquest nombre més endavant no podem garantir la disponibilitat de taula.<br/><br/>-->
				</div>
					<div style="clear:both"></div>

		</div>		
				
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<a id="scroll-seccio-dia"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-dia"> 
				<div class="putoIE"><h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?")?></h1></div>
				<!-- ******  INFO  ********   -->
				<div class="caixa dere ui-corner-all">
					<?php l('INFO_DATA');?>	
					<input type="hidden" id="valida_calendari" name="selectorData" value="<?php echo $row['data'];?>"/>
					
				</div>
				<!-- ******  CALENDARI  ********   -->
				<div id="data" style="float:left">
					
					<div id="calendari"></div>
				</div>
					<div style="clear:both"></div>
					
		</div>		

		<!-- *******************************  QUINA HORA ********************************************************   -->
		<!-- *******************************  QUINA HORA ********************************************************   -->
		<!-- *******************************  QUINA HORA ********************************************************   -->
				<a id="scroll-seccio-hora"></a>
				<div class="fr-seccio ui-corner-all fr-seccio-hora" > 
				<h1 class="titol"><span class="number">3</span><?php l('A quina hora?');?></h1>
				<!-- ******  INFO  ********   -->
				<div class="ui-corner-all caixa dere hores">
					<?php l('INFO_HORES');?>	
				</div>
				<!-- ******  DINAR  ********   -->
				<h4><?php l('Dinar');?></h4>
				<div id="selectorHora" class="col_dere">
					<img src="css/loading.gif"/>
				</div>
				<!-- ******  SOPAR  ********   -->
				<h4><?php l('Sopar');?></h4>
				<div id="selectorHoraSopar" class="col_dere" >
					<img src="css/loading.gif"/>
				</div>
				
				<input type="hidden" name="taulaT1" value="">
				<input type="hidden" name="taulaT2" value="">
				<input type="hidden" name="taulaT3" value="">
			</div>	
			
		
		<!-- *******************************  CARTA  *********************************   -->
		<!-- *******************************  CARTA  *********************************   -->
		<!-- *******************************  CARTA  *********************************   -->
		<a id="scroll-seccio-carta"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-carta"> 
				<h1 class="titol"><span class="number">4</span><?php l('Vols triar els plats?');?></h1>
				<div id="carta" class="col_derexx">
              <input id="te-comanda" name="te_comanda" type="text" value="" style="display:none"> 
					<!-- ******  COMANDA  ********   -->
					<div class="caixa dere ui-corner-all" >
						<table id="caixa-carta" class="col_dere">
							<tr>
								<td class="mesX"></td>
								<td class="menysX"></td>
								<td class="Xborra"></td>
								<td class="carta-plat">
									<h3><?php //l("SELECCIÓ")?></h3>
								</td>
								<td></td>
							</tr>
							<tr>
							<td class="mesX">							
							<?php echo $comanda?></td>
							<td class="menysX"></td><td class="Xborra"></td>
							<td class="carta-plat"><h3>	</h3></td>
							<td></td>
							</tr>
						</table>
											<!-- ******  BUTO CARTA  ********   -->
						<div class="ui-corner-all info info-comanda" style="float:left;">
							<?php l('INFO_COMANDA');?>
						</div>
					

					</div>
				
					<!-- ******  INFO  ********   -->
					<div class="ui-corner-all info">
						<?php l('INFO_CARTA');?>
					</div>
					<!-- ******  BUTO CARTA  ********   -->
					<a href="#" id="bt-no-carta" name="bt-no-carta" class="bt" ><?php l('Continuar');?></a>
						<a href="#"  id="bt-carta" name="bt-carta" class="bt" ><?php l('Veure la carta');?></a>
						<a href="#"  id="bt-menu" name="bt-menu" class="bt"><?php l('Veure els menús');?></a>
					<div style="clear:both"></div>

				</div>
		</div>	


		<!-- *******************************  CLIENT ********************************************************   -->
		<!-- *******************************  CLIENT ********************************************************   -->
		<!-- *******************************  CLIENT ********************************************************   -->
		<a id="scroll-seccio-client"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-client"> 
				<h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte');?></h1>
				<table id="dades-client" class="col_dere">
					<tr><td class="label">* <em style="font-size:0.9em;"><?php l('Camps obligatoris');?></em></td><td></td></tr>
					<tr><td class="label"><?php l('Telèfon mòbil');?>*</td><td><input type="text" name="client_mobil" value="<?php echo $row['client_mobil']?>"/></td></tr>
					<tr><td class="label"><?php l('Ens vols deixar una altre telèfon?');?></td><td><input type="text" name="client_telefon" value="<?php echo $row['client_telefon']?>"/></td></tr>
					<tr><td class="label">Email*</td><td><input type="text" name="client_email" value="<?php echo $row['client_email']?>"/></td></tr>
					<tr><td class="label"><?php l('Nom');?>*</td><td><input type="text" name="client_nom" value="<?php echo $row['client_nom']?>"/></td></tr>
					<tr><td class="label"><?php l('Cognoms');?>*</td><td><input type="text" name="client_cognoms" value="<?php echo $row['client_cognoms']?>"/></td></tr>
					<tr><td class="label"><?php //l('Client_id');?></td><td><input type="hidden" name="client_id" value="<?php echo $row['client_id']?>"/></textarea></td></tr>
					
					<tr><td ></td><td>
					  <div class="ui-corner-all info-legal caixa" style="width:496px;">
            <?php l('NO_COBERTS_OBSERVACIONS');?>
          </div>
					  

					  
					</td></tr>
					<tr><td class="label" style="vertical-align:top;"><?php l('Observacions');?></td>
					<td style="padding-left:10px;vertical-align:top;">				
					
					<textarea type="text" name="observacions"> <?php echo $row['observacions']?></textarea>

					
					</td></tr>
				</table>
				<div style="clear:both"></div>
				<div class="ui-corner-all info-legal caixa">
					<?php l('LLEI');
					$chek= ($gestor->flagBit($row['reserva_info'],7)?'checked="checked"':'');

					?>
					<br/>
					
					<input type="checkbox" id="esborra_dades" name="esborra_dades" value="on" <?php print $chek ?>/><label for="esborra_dades"><?php l("ESBORRA_DADES")?></label>
					
				</div>
				
				<div style="clear:both"></div>
		</div>	
		
		<!-- *******************************  SUBMIT ********************************************************   -->
		<!-- *******************************  SUBMIT ********************************************************   -->
		<!-- *******************************  SUBMIT ********************************************************   -->
		<a id="scroll-seccio-submit"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-submit"> 
				<h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud');?></h1>
								
				<div class="ui-corner-all caixa resum">
					<b><?php l('Resum reserva');?>:</b><br/><br/>
					<?php l('Data');?>: <b id="resum-data">-</b> | <?php l('Hora');?>: <b id="resum-hora">-</b><br/>
					<?php l('Adults');?>: <b id="resum-adults">-</b> | <?php l('Juniors');?>: <b id="resum-juniors">-</b> | <?php l('Nens');?>: <b id="resum-nens">-</b> | <?php l('Cotxets');?>: <b id="resum-cotxets">-</b><br/>
					<?php l('Comanda');?>: <b id="resum-comanda"><?php l('Sense');?> </b> <?php l('plats');?> (<b id="resum-preu"></b> €)
				</div>
				<div class="ui-corner-all info-submit caixa dere">
					<?php l('INFO_NO_CONFIRMADA');?>:
				
				</div>
				<?php $t=(isset($_POST['idr']) && $_POST['idr']>5000)?'Modificar reserva':'Sol·licitar reserva'; ?>
				<button id="submit"><?php l($t);?></button>
				
				<div style="clear:both"></div>
				<div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
		</div>
			
	</div>

</form>	<!--
	
	-->
<div id="peu" style="margin-top:50px;	text-align:center;padding:15px;background:#FFFFFF"><b>Restaurant CAN BORRELL:</b> <span class="dins" style="text-align:right">93 692 97 23 / 93 691 06 05 </span>  /  <a href="mailto:<?php echo MAIL_RESTAURANT;?>" class="dins"><?php echo MAIL_RESTAURANT;?></a>
</div>
	
		</TD>
	</TR>
</TABLE>
	
	

<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** -->
<div id="fr-cartaw-popup" title="<?php l("La nostra carta")?>" class="carta-menu" style="height:300px">
<div id="fr-carta-tabs" >
	<?php echo $gestor->recuperaCarta($row['id_reserva'])?>
</div>	
</div>	
<!-- ******************* CARTA-MENU *********************** -->
<!-- ******************* CARTA-MENU *********************** -->
<!-- ******************* CARTA-MENU *********************** -->
<div id="fr-menu-popup" title="<?php l("Els nostres menús")?>" class="carta-menu">
<div id="fr-menu-tabs" >
	<?php echo $gestor->recuperaCarta($row['id_reserva'],true)?>
</div>	
</div>	

<!-- ******************* POPUPS GRUPS *********************** -->
<!-- ******************* POPUPS GRUPS *********************** -->
<!-- ******************* POPUPS GRUPS *********************** -->
<div id="popupGrups" title="<?php l("Reserva per grups")?>">
<?php l('ALERTA_GRUPS');?>
	
</div>


<!-- ******************* POPUPS INFO *********************** -->
<!-- ******************* POPUPS INFO *********************** -->
<!-- ******************* POPUPS INFO *********************** -->
<div id="popup" title="<?php l("Connexió amb el sistema de reserves")?>"><img src="css/loading.gif"/></div>
<div id="help" title="<?php l("Necessites ajuda?")?>"><?php l('ALERTA_INFO_INICIAL');?></div>

<div id="popupInfo" CLASS="ui-helper-hidden">
	<?php l('ALERTA_INFO');?>
</div>

<div id="popupInfoUpdate" CLASS="ui-helper-hidden">
	<?php l('ALERTA_INFO_UPDATE');?>
</div>

<div id="reserves_info" class="ui-helper-hidden">
	<?php include("reservesInfo_".substr($lang,0,2).".html");?>
</div>


</BODY>
</HTML>