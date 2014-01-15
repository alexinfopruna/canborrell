<?php 
if (!defined('ROOT')) define('ROOT', "../taules/");
require(ROOT."Gestor.php");


if (!isset($_SESSION)) session_start(); 
$_SESSION["idioma"]=$_GET["lang"]=$lang="cat";	

require_once(INC_FILE_PATH.'alex.inc');
$ini_array = parse_ini_file("../canborrell.ini");
 
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE> Masia Can Borrell </TITLE>
	<LINK rel="stylesheet" type="text/css" href="../estils.css">
	
<!-- this goes into the <head> tag ALEX ESTILS! -->
<style type="text/css">
.Estilo1 {color: #333333}
.special { background-color: #000; color: #fff; }
.disabled {
	background-color: #ffffff;
	color: #000000;
	border: solid;
	border-color: #aaaaaa;
	border-width:1px 1px 1px 1px;

}
selectx, optionx{	font-family:"Sans Serif","Courier New", monospace;}
option{	font-family: monospace;}

</style>	
	
	<script type="text/javascript" src="../pgrvalida.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../calendari.css">
  <script type="text/javascript" src="../js/calendar.js"></script>
  <script type="text/javascript" src="../js/lang/calendar-ca.js"></script>
  <script type="text/javascript" src="../js/calendar-setup.js"></script>
  <script language="javascript" src="../editar/js/jquery-1.2.3.pack.js"></script>
  <script type="text/javascript" src="../js/jquery.spin.js"></script>
	
	<!-- MENU -->
	<script type="text/javascript" src="../js/dynmenu.js"></script> 


  <script>

 // JQUERY CALSOTADA
 $(function(){
	// torn 0=migdia / 1=nit
 	$("#matinit").change(function(){ajax(0)});
 	$("#matinit2").change(function(){ajax(1)});
 	$("#factura").change(function(){if ($("#factura").attr("checked")) $("#factura_dades").slideDown(); else $("#factura_dades").slideUp()});
	$("#factura_dades").hide();

	function ajax(torn)
	{
		$.ajax({url:"calendari.php?torn="+torn,	success: function(datos)
		{
			$(".calendar").html("");
			$("#xx").show();
			$("#calendari_matinit").html(datos);
			if (torn==3)$("#calendari_matinit").html(datos);
			//////
			if (torn==0)
			{
			$("#tdhora").html('<INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="HR" MIN="12" MAX="16" ALT="Si us plau, indiqui l´hora (HH:MM)">')
			}
			else
			{
				$("#tdhora").html('<INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="HR" MIN="21" MAX="23" ALT="Si us plau, indiqui l´hora (HH:MM)">')
			}
			
			
		
		}});
	}
 
 	$("#menu").change(function(){
		//alert($(this).val());	
		if ($(this).val()==5)
		{
			$(".calsotada").slideDown();
		}else{
			$(".calsotada").slideUp();
		}
		
	});
	
 $("#nocalsot").spin({max:100,min:0});
 
 
 
 });



  function mnu_junior()
  {
//  alert("xxjrt!!!!");
  	if (document.getElementById("jrs").value>0) 
		{
		document.getElementById("mnjrs").style["display"]="";
	//	alert("neeeens!!!!");
	}else
	{
		document.getElementById("mnjrs").style["display"]="none";
	}


    return true;
  }
  
    function mnu_nens()
  {
  	if (document.getElementById("nens").value>0) 
	{
		document.getElementById("mnnens").style["display"]="";
		//alert("on");
	}else
	{
		document.getElementById("mnnens").style["display"]="none";
  		//alert("off");
	
	}
    return true;
  }


  </script>
</HEAD>
<BODY onLoad="loadMenu();mnu_nens();mnu_junior();">
<CENTER>
<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775" HEIGHT="100%" BORDER="0">
	<TR>
		<TD BACKGROUND="../img/fons_9a.jpg" COLSPAN="2" ALIGN="RIGHT"><A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICI"></A></TD>
	</TR>
	<TR>
		<TD BGCOLOR="#570600" COLSPAN="2" ALIGN="CENTER"><TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="18" BORDER="0">
			<TR>
				<TD ALIGN="CENTER"><A HREF="index.html">CAN BORRELL</A>  <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="fotos.html">FOTOS-V&Iacute;DEO</A> <A NAME="0"><IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"></A> <A HREF="plats.php">CARTA i MEN&Uacute;</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  <A HREF="on.html">ON SOM: MAPA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="excursions.html">EXCURSIONS</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="historia.html">HIST&Ograve;RIA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="horaris.html">HORARI</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="reserves.html">RESERVES</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <FONT COLOR="#FFFFFF"><B>CONTACTAR</B></FONT></TD>
			</TR>
		</TABLE></TD>
	</TR>
	<TR>
		<TD style="background-image:url(../img/fons_9b.jpg); background-repeat:no-repeat;" HEIGHT="100%" WIDTH="154">&nbsp;</TD>
		<TD style="background-image:url(../img/fons_9c.jpg); background-repeat:no-repeat;" WIDTH="621" ALIGN="CENTER" VALIGN="TOP">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="490" BORDER="0">
			<TR>
				<TD><img src="../img/pix.gif" width="190" height="1" border="0"></TD>
				<TD WIDTH="300">&nbsp;<BR>
<BR>
<BR>
<FONT CLASS="titol">Restaurant Masia Can Borrell</FONT><BR>
<BR>
<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<TR>
		<TD><FONT CLASS="gran">Tel.:&nbsp;<BR>
&nbsp;</FONT></TD>
		<TD><FONT CLASS="gran">93 692 97 23<BR>
93 691 06 05</FONT></TD>
	</TR>
</TABLE>
<BR>
<B>Fax:</B> 93 692 40 57<BR>
<BR>
<B>E-mail:</B> restaurant@can-borrell.com<BR>
<BR>
<B>Adre&ccedil;a:</B><BR>
Carretera d'Horta a Cerdanyola (BV-1415), km. 3<BR>
08171 Sant Cugat del Vall&egrave;s<BR>
<A HREF="on.html" CLASS="dins">[ Veure mapa ]</A><BR>
<BR>
<B>Adre&ccedil;a postal:</B><BR>
Cam&iacute; de Can Borrell, s/n - apt. 99<BR>
08171 Sant Cugat del Vall&egrave;s</TD>
			</TR>
			<TR>
				<TD COLSPAN="2">&nbsp;<BR>
<BR>
<B>GPS:</B> Punto de inter&eacute;s: Restaurantes: Restaurant Masia Can Borrell<BR>
<B>GPS:</B> LONGITUD: E 02º 07' 22&quot; - ALTITUD: N 41º 27' 56&quot;<BR>
<BR>
<A NAME="formulari">&nbsp;</A><BR>
<FORM ACTION="../editar/reserves.php" METHOD="POST" NAME="FORMULARI" ONSUBMIT="javascript: return valida(this,'ct');"> 
<input type="hidden" name="redirect" value="http://www.can-borrell.com/cat/gracies.html">
<input type="hidden" name="subject" value="Sol·licitud d'espai a partir de 12 coberts">
<!--<input type="hidden" name="recipient" value="alex@infopruna.net"> -->
 <input type="hidden" name="recipient" value="restaurant@can-borrell.com">
		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="490">
			<TR> 
                  		<TD COLSPAN="4"><FONT CLASS="titol2">Sol·licitud d'espai per a <FONT CLASS="titol">grups a partir de 12 Coberts</FONT></FONT><BR>
(<FONT COLOR="#CC3333">*</FONT> = Camps obligatoris)<BR>
&nbsp;<BR></TD>
			</TR>
			<TR> 
                  		<TD COLSPAN="2"><FONT COLOR="#CC3333">*</FONT>Nom:<BR>
<INPUT NAME="nom" TYPE="TEXT" id="nom" style="width: 310px;" ALT="Si us plau, escrigui el seu nom." VAL="OB"></TD>
                  		<TD ROWSPAN="11"><IMG SRC="../img/pix.gif" WIDTH="15" HEIGHT="1" BORDER="0"></TD>
                  		<TD ROWSPAN="11" VALIGN="TOP">
<FONT CLASS="petita" COLOR="#999999">&nbsp;<BR>
En compliment de la Llei Org&agrave;nica 15/1999 del 13 de desembre, de Protecci&oacute; de Dades de Car&agrave;cter Personal (LOPD), us informem que les dades personals obtingudes com a resultat d'emplenar aquest formulari, rebran un tractament estrictament confidencial per part del Resturant Masia Can Borrell.<BR>
&nbsp;<BR>
Podeu exercir els vostres drets d'acc&eacute;s, rectificaci&oacute;, cancel·laci&oacute; i oposici&oacute; al tractament de les vostres dades personals, en els termes i condicions que preveu la LOPD mitjan&ccedil;ant l'adre&ccedil;a de correu: restaurant@can-borrell.com</FONT></TD></TR>

			<TR> 
                  		<TD COLSPAN="2"><FONT COLOR="#CC3333">*</FONT>Cognom:<BR>
<INPUT NAME="cognom" TYPE="TEXT" id="cognom" style="width: 310px;" ALT="Si us plau, escrigui el seu cognom." VAL="OB"></TD>
                  		<TD ROWSPAN="11"><IMG SRC="../img/pix.gif" WIDTH="15" HEIGHT="1" BORDER="0"></TD>
                  		<TD ROWSPAN="11" VALIGN="TOP"></TD></TR>
			

				<TD><IMG SRC="../img/pix.gif" WIDTH="158" HEIGHT="7" BORDER="0"><BR>
<FONT COLOR="#CC3333">*</FONT>Tel&egrave;fon m&ograve;bil: <BR>
<INPUT NAME="tel" TYPE="TEXT" id="tel" style="width: 152px;" ALT="Si us plau, escrigui un telèfon mòbil vàlid (6XXXXXXXX)." VAL="TM"></TD>
				<TD><IMG SRC="../img/pix.gif" WIDTH="100" HEIGHT="7" BORDER="0"><BR>
				  <FONT COLOR="#CC3333">*</FONT>Tel&egrave;fon fixe:<BR>
<INPUT NAME="fax" TYPE="TEXT" id="fax" style="width: 152px;" ALT="Si us plau, escrigui un telèfon fixe vàlid (9XXXXXXXX)." VAL="TF"></TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="7" BORDER="0"><BR>
<FONT COLOR="#CC3333">*</FONT>E-mail:<BR>
<INPUT NAME="email" TYPE="TEXT" id="email" style="width: 310px;" VAL="EM" ALT="Si us plau, escrigui una adreça d'e-mail">
<BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="10" BORDER="0"></TD>
			</TR>
			<TR>
				<TD COLSPAN="2">
<HR WIDTH="310" SIZE="1" NOSHADE>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="310">
<!-- **************************************************************************************-->
					<TR>
						<TD COLSPAN="2">						    
						*Seleccioni l'àpat<br/>
						<input id="matinit" name="matinit" type="radio" value="comer" VAL="OP" ALT="Selecciona dinar o sopar">
						      Dinar<br>
						      <input id="matinit2" name="matinit" type="radio" value="cenar">
						      Sopar<BR>
<div id="xx" style="display:none"><img src="../img/ic_menjador_ple.gif" alt="En blanc" width="45" height="25" ALIGN="ABSMIDDLE"> Dies amb el menjador ple <br>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="5" BORDER="0"></div></TD>
					</TR>
					<TR>
						<TD COLSPAN="2" ALIGN="CENTER">
						
						<div style="float:left; border:1px solid #999966;" id="calendar-container"></div>						</TD>
					</TR>
					<TR>
						<TD id="tdcalend" COLSPAN="2" HEIGHT="22">
							<div id="calendari_matinit"></div>											</TD>
					</TR>
<!-- **************************************************************************************-->
					<TR>
						<TD><FONT COLOR="#CC3333">*</FONT>Hora:&nbsp;</TD>
						<TD WIDTH="100%" id="tdhora"><INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="HR" MIN="9" MAX="17" ALT="Si us plau, indiqui l'hora (HH:MM)."></TD>
					</TR>
					<TR>
						<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"></TD>
					</TR>
					<TR>
						<TD><FONT COLOR="#CC3333">*</FONT>Men&uacute;:&nbsp;</TD>
						<TD>						
				 <SELECT NAME="menu" id="menu"  class="mono" style="width: 260px;" VAL="OB" ALT="Si us plau, seleccioni un menú.">
					<OPTION VALUE="" >Escollir men&uacute;:</OPTION>
					<OPTION VALUE="0" >Men&uacute; nº1 .................<? echo $ini_array["menu1_1"]?> €</OPTION>
					<OPTION VALUE="1" >Men&uacute; nº1 Celebraci&oacute;.......<? echo $ini_array["menu1c_1"]?> €</OPTION>
					<OPTION VALUE="2" >Men&uacute; nº2 .................<? echo $ini_array["menu2_1"]?> €</OPTION>
					<OPTION VALUE="3" >Men&uacute; nº2 Celebraci&oacute; ......<? echo $ini_array["menu2c_1"]?> €</OPTION>
					<OPTION VALUE="4" >Men&uacute; nº3 .................<? echo $ini_array["menu3_1"]?> €</OPTION>
					<OPTION VALUE="9" >Men&uacute; nº4 .................<? echo $ini_array["menu4_1"]?> €</OPTION>
					<?php if ($ini_array["calsoton"]){ ?>
					<OPTION VALUE="5">Men&uacute; Cal&ccedil;otada ...........<? echo $ini_array["menuc_1"]?> €</OPTION>										  					<?php } ?>
					<OPTION VALUE="6"> Men&uacute; Comuni&oacute; .............<? echo $ini_array["menucomu_1"]?> €</OPTION>
					<OPTION VALUE="7">Men&uacute; Casament ............<? echo $ini_array["menucasam_1"]?> €</OPTION>
</SELECT>					</TD>
					</TR>
					<TR>
					  <TD>&nbsp;</TD>
					  <TD>
						  <div class="calsotada" style="display:none;">
							<p>Si algun comensal <strong>NO disitja cal&ccedil;otada</strong>, la pot substitu&iuml;r pel men&uacute; N&ordm;1.</p>
							<p>Indiqui, a continuaci&oacute;, quants dels comensals prendran men&uacute; N&ordm;1 en comptes de cal&ccedil;otada:</p>
							<p><strong>Reservar Men&uacute; n&ordm;1 per
							  <input id="nocalsot" name="nocalsots" type="text" size="2" maxlength="2" value="0" style="text-align:right">
							  persones que NO desitgen cal&ccedil;otada<br>
							  </strong><span class="petita Estilo1" style="margin-left:120px">(indiqui n&uacute;mero*) </span></p>
							 <div align="justify"><span  class="petita Estilo1">* Indicant zero entenem que <strong>TOTS</strong> menjaran cal&ccedil;otada.</span></div>
						  </div>					  </TD>
					  </TR>
				</TABLE>				</TD>
			</TR>
			<TR> 
				<TD COLSPAN="2">
<HR WIDTH="310" SIZE="1" NOSHADE>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="310">
					<TR>
						<TD><B>COBERTS</B><BR>
Si us plau, indiqui el n&uacute;mero de nens i de cotxets,<BR>
en cas de no haver-n'hi escrigui 0<BR>
&nbsp;</TD>
					</TR>
					<TR>
						<TD ALIGN="RIGHT"><FONT COLOR="#CC3333">*</FONT>Adults (m&iacute;nim 9): <INPUT TYPE="TEXT" NAME="adults" style="width: 30px;" VAL="MM" MIN="9" ALT="Si us plau, especifiqui el número d'adults."><BR>

<FONT COLOR="#CC3333">*</FONT>Nens de 10 a 14 anys (men&uacute; Junior): <INPUT TYPE="TEXT" NAME="nens10_14" style="width: 30px;" VAL="MM" MIN="0" ALT="Si us plau, especifiqui el número de nois."  id="jrs"  onChange="mnu_junior()" ><br>
<div id="mnjrs" style="display:none">
<FONT COLOR="#CC3333">*</FONT>Men&uacute; junior:
<select name="txt_1"  id="xmnjrs"  style="width:190px;">
  <option value="junior" selected="selected">Men&uacute; junior ....<? echo $ini_array["menu1_4"]?> €</option>
  <option value="jr_comu">Men&uacute; comuni&oacute; ...<? echo $ini_array["menucomu_3"]?> €</option>
  <option value="jr_casa">Men&uacute; casament ..<? echo $ini_array["menucasam_3"]?> €</option>
</select>
</div>
<FONT COLOR="#CC3333">*</FONT>Nens de 4 a 9 anys (men&uacute; Infantil): <INPUT TYPE="TEXT" NAME="nens4_9" style="width: 30px;" VAL="MM" MIN="0" ALT="Si us plau, especifiqui el número de nens." id="nens"  onChange="mnu_nens()"><BR>
<div id="mnnens" style="display:none">
<FONT COLOR="#CC3333">*</FONT>Men&uacute; nens:
<select name="txt_2" id="xmnnens"  style="width:190px;">
  <option value="infantil" selected="selected">Men&uacute; infantil ..<? echo $ini_array["menu1_3"]?> €</option>
  <option value="inf_comu">Men&uacute; comuni&oacute; ...<? echo $ini_array["menucomu_2"]?> €</option>
  <option value="inf_casa">Men&uacute; casament ..<? echo $ini_array["menucasam_2"]?> €</option>
</select>
</div>

<FONT COLOR="#CC3333">*</FONT>Cotxets de nadons (m&agrave;xim 2): <INPUT TYPE="TEXT" NAME="cotxets" style="width: 30px;" VAL="MM" MIN="0" MAX="2" ALT="Si us plau, especifiqui el número de cotxets. En cas de ser més de dos truqui al restaurant."></TD>
					</TR>
                    <!--
                    <TR>
						<TD ALIGN="RIGHT"><FONT COLOR="#CC3333">*</FONT>Adults (m&iacute;nim 9): <INPUT NAME="adults" TYPE="TEXT" id="adults" style="width: 30px;" ALT="Si us plau, especifiqui el número d'adults." VAL="MM" MIN="9">
						<BR>
<FONT COLOR="#CC3333">*</FONT>Nens de 10 a 14 anys (men&uacute; Junior): <INPUT NAME="nens10_14" TYPE="TEXT" id="nens10_14" style="width: 30px;" ALT="Si us plau, especifiqui el número de nois." VAL="MM" MIN="0">
<BR>
<FONT COLOR="#CC3333">*</FONT>Nens de 4 a 9 anys (men&uacute; Infantil): <INPUT NAME="nens4_9" TYPE="TEXT" id="nens4_9" style="width: 30px;" ALT="Si us plau, especifiqui el número de nens." VAL="MM" MIN="0">
<BR>
<FONT COLOR="#CC3333">*</FONT>Cotxets de nadons (m&agrave;xim 2): <INPUT NAME="cotxets" TYPE="TEXT" id="cotxets" style="width: 30px;" ALT="Si us plau, especifiqui el número de cotxets. En cas de ser més de dos truqui al restaurant." VAL="MM" MIN="0" MAX="2"></TD>
					</TR> -->
				</TABLE>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
<CENTER>(Tots els <B>nens</B> a partir de 4 anys hauran de<BR>
<B>consumir 1 men&uacute; </B> per cadasc&uacute;)</CENTER>				</TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><HR WIDTH="310" SIZE="1" NOSHADE></TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
Altres observacions:<BR>
<TEXTAREA NAME="observacions" ROWS="6" id="observacions"></TEXTAREA></TD>
			</TR>
			<TR class="test">
			<TR class="test">
			  <TD COLSPAN="2" ALIGN="CENTER"><div align="left">
			    <input name="factura[]" type="checkbox" id="factura" value="1">
			    Vull rebre factura ProForma
			    </div>
			  <div id="factura_dades"> 
				    <div align="left" >CIF/NIF<br>
				        <input name="factura_cif" type="text" id="factura_cif" size="10" >
				        <br>
				      Nom
				      <br>
				      <input name="factura_nom" type="text" id="factura_nom" size="49" >
				      <br>
				      Adreça
				      <textarea name="factura_adresa" rows="2"  id="factura_adresa"></textarea>
				      
				      </div>
				  </div></TD>
			  </TR>
			<TR> 
				<TD COLSPAN="2" ALIGN="CENTER"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
(Aquesta informaci&oacute; <B>en cap cas ser&agrave; una reserva</B>)<BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
<INPUT TYPE="SUBMIT" VALUE="ENVIAR" CLASS="bt">&nbsp;<INPUT TYPE="RESET" VALUE="Esborrar" CLASS="bt"></TD>
			</TR>
		</TABLE>
</FORM>
<BR>
&nbsp;</TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
</TABLE>
</CENTER>
</BODY>
</HTML>