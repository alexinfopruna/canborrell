<?
if (!defined('ROOT')) define('ROOT', "../taules/");
require(ROOT."Gestor.php");

require_once(INC_FILE_PATH.'alex.inc'); 
valida_admin('login.php') ;
$id=$_GET["id"];

require_once("../taules/php/Configuracio.php");
$config=new Configuracio();


function valor($camp) 
{
	$ini_array = parse_ini_file("../canborrell.ini");
		print  str_replace("[*]","\r", $ini_array[$camp]); 
}

function valorlx($camp) 
{
	global $config;
	return $config->configVars[$camp];
}


function psw($camp) 
{
	$ini_array = parse_ini_file("../canborrellpsw.ini");
	//if (in_array ($camp, $ini_array))
		print  str_replace("[*]","\r", $ini_array[$camp]); 
}

function valida_psw($psw_form)
{	
    session_start();
	if ($_SESSION['pass']=="ok") return true;	
	
    
	$ini_array = parse_ini_file("../canborrellpsw.ini");
	$psw_ini = $ini_array["password"];
	if ($psw_form == $psw_ini ) {
        $_SESSION['pass']="ok";
		return 1;
	} else {
		return 0;
	}
}
/*
	$password = '';
	if (sizeof($_POST) > 0 ){
		$password = $_POST['password'];
	} 
  
   if  ( valida_psw($password) == 1) {
   if ($id>0) {
        header("location: detall.php?id=$id");
        exit();
    }
    if ($id!=-1) 
    {
        header("location: llistat.php?");
        exit();
    }
 	session_start();
	//session_register('admin');	
 	$_SESSION['pass']='ok';
   }
  */
valida_admin('login.php') ;  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE> Masia Can Borrell </TITLE>
	<LINK rel="stylesheet" type="text/css" href="estils.css">
</HEAD>
<BODY>
<? if  ( true || valida_psw($password) == 1) {
 
?>
<CENTER>
<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="730" BORDER="0">
<TR>
	<TD BGCOLOR="#570600" ALIGN="CENTER">
	<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="716" HEIGHT="19" BORDER="0">
		<TR>
			<TD><A HREF="llistat.php">GESTIÓ RESERVES </A>  <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"><A HREF="gestio_dies.php"> GESTIÓ DIES PLENS </A>  <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <FONT COLOR="#FFFFFF"><B>EDITAR PREUS I SUGGERIMENTS</B></FONT></TD>
			<TD ALIGN="RIGHT"><A HREF="../cat/index.html">CAN BORRELL</A></TD>
		</TR>
	</TABLE>
	</TD>
</TR>
<TR>
	<TD VALIGN="TOP" ALIGN="CENTER">
	<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="670">
	<FORM  METHOD="POST" ACTION="guardar.php">
		<INPUT TYPE="HIDDEN" NAME="password" VALUE="<? psw("password") ?>">
		<TR>
			<TD VALIGN="TOP">&nbsp;<BR>



	<FONT CLASS="titol"><B>MODIFICAR SUGGERIMENTS</B></FONT>
	<P>
	<B>Suggeriments</B> (catal&agrave;):<BR>
	<TEXTAREA NAME="Suggeriments" ROWS="24"><? valor("Suggeriments"); ?></TEXTAREA>
	<P>
	<B>Sugerencias</B> (castell&agrave;):<BR>
	<TEXTAREA NAME="Sugerencias" ROWS="24"><? valor("Sugerencias"); ?></TEXTAREA><BR><B>No utilitzar "</B>    
	
	</TD>
			<TD VALIGN="TOP" ALIGN="CENTER">
			<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
				<TR>
					<TD COLSPAN="2">&nbsp;<BR>
&nbsp;<BR>
	<FONT CLASS="titol"><B>MODIFICAR PREUS</B></FONT>
	<P>
	<B>CARTA:</B></TD>
				</TR>
				<TR>
					<TD>Preu mig aproximat:</TD>
					<TD><INPUT TYPE="text" NAME="preu_general" SIZE="4" VALUE="<? valor("preu_general"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; Nº1:</B></TD>
				</TR>
				<TR>
					<TD>Adults (sense cava): </TD>
					<TD><INPUT TYPE="text" NAME="menu1_1" VALUE="<? valor("menu1_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Adults (amb cava):</TD>
					<TD><INPUT TYPE="text" NAME="menu1_2" VALUE="<? valor("menu1_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menu1_3" VALUE="<? valor("menu1_3"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menu1_4" VALUE="<? valor("menu1_4"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; Nº1 CELEBRACI&Oacute;:</B></TD>
				</TR>
				<TR>
					<TD>Adults (sense cava): </TD>
					<TD><INPUT TYPE="text" NAME="menu1c_1" VALUE="<? valor("menu1c_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Adults (amb cava):</TD>
					<TD><INPUT TYPE="text" NAME="menu1c_2" VALUE="<? valor("menu1c_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menu1c_3" VALUE="<? valor("menu1c_3"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menu1c_4" VALUE="<? valor("menu1c_4"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; Nº2:</B></TD>
				</TR>
				<TR>
					<TD>Adults (sense cava):</TD>
					<TD><INPUT TYPE="text" NAME="menu2_1" VALUE="<? valor("menu2_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Adults (amb cava):</TD>
					<TD><INPUT TYPE="text" NAME="menu2_4" VALUE="<? valor("menu2_4"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menu2_2" VALUE="<? valor("menu2_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menu2_3" VALUE="<? valor("menu2_3"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; Nº2 CELEBRACI&Oacute;:</B></TD>
				</TR>
				<TR>
					<TD>Adults (sense cava): </TD>
					<TD><INPUT TYPE="text" NAME="menu2c_1" VALUE="<? valor("menu2c_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Adults (amb cava):</TD>
					<TD><INPUT TYPE="text" NAME="menu2c_2" VALUE="<? valor("menu2c_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menu2c_3" VALUE="<? valor("menu2c_3"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menu2c_4" VALUE="<? valor("menu2c_4"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; Nº3:</B></TD>
				</TR>
				<TR>
					<TD>Preu: </TD>
					<TD><INPUT TYPE="text" NAME="menu3_1" VALUE="<? valor("menu3_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR>
					<B>MEN&Uacute; Nº4:</B></TD>
				</TR>
				<TR>
					<TD>Preu: </TD>
					<TD><INPUT TYPE="text" NAME="menu4_1" VALUE="<? valor("menu4_1"); ?>"> Euros</TD>
				</TR>
				 
				
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; CAL&Ccedil;OTADA: <br/><a href="../taules/DBTable/FormConfigAdmin.php" style="color:gray;font-size:0.8em;font-weight:normal">(activa/desactiva a: Eines avançades > Configuració avançada del sistema > calsoton) </a></B>
				<!--	<span style="color:red;font-weight:bold"> ACTIVAR <input name="calsoton" type="checkbox" style="width:15px;"  <? if (valorlx("calsoton")) echo "checked";?>></span> -->
					</TD>
				</TR>
				<TR>
					<TD>Adults: </TD>
					<TD><INPUT TYPE="text" NAME="menuc_1" VALUE="<? valor("menuc_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menuc_2" VALUE="<? valor("menuc_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menuc_3" VALUE="<? valor("menuc_3"); ?>"> Euros</TD>
				</TR>
				
				
				
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; COMUNI&Oacute;:</B></TD>
				</TR>
				<TR>
					<TD>Adults: </TD>
					<TD><INPUT TYPE="text" NAME="menucomu_1" VALUE="<? valor("menucomu_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menucomu_2" VALUE="<? valor("menucomu_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menucomu_3" VALUE="<? valor("menucomu_3"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;<BR><B>MEN&Uacute; CASAMENTS:</B></TD>
				</TR>
				<TR>
					<TD>Adults: </TD>
					<TD><INPUT TYPE="text" NAME="menucasam_1" VALUE="<? valor("menucasam_1"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 4 a 9 anys:</TD>
					<TD><INPUT TYPE="text" NAME="menucasam_2" VALUE="<? valor("menucasam_2"); ?>"> Euros</TD>
				</TR>
				<TR>
					<TD>Nens de 10 a 14 anys:&nbsp;</TD>
					<TD><INPUT TYPE="text" NAME="menucasam_3" VALUE="<? valor("menucasam_3"); ?>"> Euros</TD>
				</TR>
			</TABLE>
			</TD>
		</TR>
				<!-- 
		<TR>
			<TD COLSPAN="2" ALIGN="LEFT">
			
					<br/>	
					<br/>	
					<hr/>	
					<br/>	
					<br/>	
				<span class="titol">CONFIGURACIÓ FORMULARIS RESERVES ONLINE</span> 
				<p>  
				  <b>NUM. COBERT PER RESERVES GRUPS: </b> 
				  <input name="persones_grup" type="text" style="width:25px;"  value="<? echo valorlx("persones_grup");?>"><BR>
				 </p>
				<p>  
				  <b>MAX NENS RESERVA GRUP: </b> 
				  <input name="max_nens_grup" type="text" style="width:25px;"  value="<? echo valorlx("max_nens_grup");?>"><BR>
				 </p>
				<p>  
				  <b>MAX JUNIORS RESERVA GRUP: </b> 
				  <input name="max_juniors_grup" type="text" style="width:25px;"  value="<? echo valorlx("max_juniors_grup");?>"><BR>
				 </p>
				<p>  
				  <b>MAX NENS RESERVA PETITA: </b> 
				  <input name="max_nens" type="text" style="width:25px;"  value="<? echo valorlx("max_nens");?>"><BR>
				 </p>
				<p>  
				  <b>MAX JUNIORS RESERVA PETITA: </b> 
				  <input name="max_juniors" type="text" style="width:25px;"  value="<? echo valorlx("max_juniors");?>"><BR>
				 </p>
			
					<br/>	
					<br/>	
					<hr/>	
					<br/>	
					<br/>	
			</TD>
		</TR>
				-->
		<TR>
			<TD COLSPAN="2" ALIGN="CENTER">
			
			&nbsp;<BR>
	<INPUT TYPE="submit" NAME="Aprovar" VALUE="Aprovar canvis" CLASS="bt">
	<P>&nbsp;</P></TD>
		</TR>
	</FORM>
</FORM>
	</TABLE>
	</CENTER>
<? } else header("Location: login.php"); ?>
</BODY>
</HTML>