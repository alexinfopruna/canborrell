<?php 
if (!defined('ROOT')) define('ROOT', "");
include(ROOT."Gestor.php");

	session_start(); 
	$_SESSION["idioma"]=$_GET["lang"]=$lang="esp";	

		require_once(INC_FILE_PATH.'alex.inc'); 

	
	$ini_array = parse_ini_file("../canborrell.ini");
?>
<HTML>
<HEAD>
<TITLE> Masia Can Borrell </TITLE>
	<LINK rel="stylesheet" type="text/css" href="../estils.css">
	
<!-- this goes into the <head> tag ALEX ESTILS! -->
<style type="text/css">
.special { background-color: #000; color: #fff; }
.disabled {
	background-color: #ffffff;
	color: #000000;
	border: solid;
	border-color: #aaaaaa;
	border-width:1px 1px 1px 1px;

}
option{	font-family: monospace;}
</style>	
	
	<script type="text/javascript" src="../pgrvalida.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../calendari.css">
  <script type="text/javascript" src="../js/calendar.js"></script>
  <script type="text/javascript" src="../js/lang/calendar-es.js"></script>
  <script type="text/javascript" src="../js/calendar-setup.js"></script>
  <script language="javascript" src="../editar/js/jquery-1.2.3.pack.js"></script>
  <script type="text/javascript" src="../js/jquery.spin.js"></script>
	<!-- MENU -->
	<script type="text/javascript" src="../js/dynmenu.js"></script> 

  <script>

 // JQUERY CALSOTADA
 $(function(){
 	$("#matinit").change(function(){ajax(0)});
 	$("#matinit2").change(function(){ajax(1)});

	function ajax(torn)
	{
		// torn 0=migdia / 1=nit
		$.ajax({url:"calendari.php?torn="+torn,	success: function(datos)
		{
			$(".calendar").html("");
			$("#xx").show();
			$("#calendari_matinit").html(datos);
			if (torn==3)$("#calendari_matinit").html(datos);
			
			//////
			if (torn==0)
			{
			$("#tdhora").html('<INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="HR" MIN="12" MAX="16" ALT="Por favor, indique la hora (HH:MM)">')
			}
			else
			{
				$("#tdhora").html('<INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="HR" MIN="21" MAX="23" ALT="Por favor, indique la hora (HH:MM)">')
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
	}else
	{
		document.getElementById("mnnens").style["display"]="none";
  		//alert("off");
	
	}
    return true;
  }
 
  </script>
  <style type="text/css">
<!--
.Estilo1 {color: #333333}
-->
  </style>
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
          <TD><A HREF="index.html">CAN BORRELL</A> <IMG SRC="../img/separa_mn.gif" alt="7" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="fotos.html">FOTOS-VIDEO</A> <IMG SRC="../img/separa_mn.gif" alt="6" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="plats.php">CARTA Y MEN&Uacute;</A> <IMG SRC="../img/separa_mn.gif" alt="5" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="on.html">MAPA</A> <IMG SRC="../img/separa_mn.gif" alt="4" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="excursions.html">EXCURSIONES</A> <IMG SRC="../img/separa_mn.gif" alt="3" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="historia.html">HISTORIA</A></TD>
          <TD ALIGN="RIGHT"><A HREF="horaris.html">HORARIOS</A> <IMG SRC="../img/separa_mn.gif" alt="2" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="reserves.html">RESERVAS</A> <IMG SRC="../img/separa_mn.gif" alt="1" WIDTH="1" HEIGHT="8" BORDER="0"> <FONT COLOR="#FFFFFF"><B>CONTACTAR</B></FONT></TD>
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
<B>Direcci&oacute;n:</B><BR>
Carretera d'Horta a Cerdanyola (BV-1415), km. 3<BR>
08171 Sant Cugat del Vall&egrave;s<BR>
<A HREF="on.html" CLASS="dins">[ Ver mapa ]</A><BR>
<BR>
<B>Direcci&oacute;n postal:</B><BR>
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
<FORM ACTION="../editar/reserves.php" METHOD="POST" NAME="FORMULARI" ONSUBMIT="javascript: return valida(this,'es');">
<input type="hidden" name="redirect" value="http://www.can-borrell.com/esp/gracies.html">
<input type="hidden" name="subject" value="Solicitud de espacio a partir de 12 Cubiertos">
<input type="hidden" name="recipient" value="david@topeweb.com">
		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="490">
			<TR> 
                  		<TD COLSPAN="4"><FONT CLASS="titol2">Solicitud de espacio para grupos a partir de <FONT CLASS="titol">12 Cubiertos</FONT></FONT><BR>
(<FONT COLOR="#CC3333">*</FONT> = Campos obligatorios)<BR></TD>
			</TR>
			<TR> 
                  		<TD COLSPAN="2"><FONT COLOR="#CC3333">*</FONT>Nombre:<BR>
<INPUT NAME="nom" TYPE="TEXT" id="nom" style="width: 310px;" ALT="Por favor, escriba su nombre." VAL="OB"></TD>
                  		<TD width="15" ROWSPAN="10"><IMG SRC="../img/pix.gif" WIDTH="15" HEIGHT="1" BORDER="0"></TD>
                  		<TD width="157" ROWSPAN="10" VALIGN="TOP">
<FONT CLASS="petita" COLOR="#999999">&nbsp;<BR>
En cumplimiento de la Ley Org&aacute;nica 15/1999 del 13 de diciembre, de Protecci&oacute;n de Datos de Car&aacute;cter Personal (LOPD), os informamos que los datos personales obtenidos como resultado de rellenar este formulario, recibir&aacute;n un tratamiento estrictamente confidencial por parte del Resturant Masia Can Borrell.<BR>
&nbsp;<BR>
Pod&eacute;is ejercer vuestros derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n y oposici&oacute;n al tratamiento de vuestros datos personales, en los t&eacute;rminos y condiciones que prev&eacute; la LOPD mediante la direcci&oacute;n de correo: restaurant@can-borrell.com</FONT></TD>
			</TR>
			<TR> 
                  		<TD COLSPAN="2"><FONT COLOR="#CC3333">*</FONT>Apellidos:<BR>
<INPUT NAME="cognom" TYPE="TEXT" id="cognom" style="width: 310px;" ALT="Por favor, escriba su apellido." VAL="OB"></TD>
                  		<TD ROWSPAN="10"><IMG SRC="../img/pix.gif" WIDTH="15" HEIGHT="1" BORDER="0"></TD>
                  		<TD ROWSPAN="10" VALIGN="TOP"></TD></TR>
			
			<TR> 
			<TR> 
				<TD width="158"><IMG SRC="../img/pix.gif" WIDTH="158" HEIGHT="7" BORDER="0"><BR>
<FONT COLOR="#CC3333">*</FONT>Tel&eacute;fono m&oacute;vil:<BR>
<INPUT NAME="tel" TYPE="TEXT" id="tel" style="width: 152px;" ALT="Por favor, escriba su teléfono móvil válido." VAL="TM"></TD>
				<TD width="160"><IMG SRC="../img/pix.gif" WIDTH="100" HEIGHT="7" BORDER="0"><BR>
Tel. fijo:<BR>
<INPUT NAME="fax" TYPE="TEXT" id="fax" style="width: 152px;"  ALT="Por favor, escriba un teléfono fijo válido." VAL="TF"></TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="7" BORDER="0"><BR>
<FONT COLOR="#CC3333">*</FONT>E-mail:<BR>
<INPUT NAME="email" TYPE="TEXT" id="email" style="width: 310px;"  VAL="EM" ALT="Por favor, escriba una dirección de e-mail">
<BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="10" BORDER="0"></TD>
			</TR>
			<TR>
				<TD COLSPAN="2">
<HR WIDTH="310" SIZE="1" NOSHADE>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="310">
<!-- **************************************************************************************-->
					<TR>
						<TD COLSPAN="2">						*Seleccione horario <br/>
						<input id="matinit" name="matinit" type="radio" value="comer" VAL="OP" ALT="Selecciona comer o cenar">
						      Comer<br>
						      <input id="matinit2" name="matinit" type="radio" value="cenar">
						      Cenar<BR>
<div id="xx" style="display:none"><img src="../img/ic_menjador_ple.gif" alt="En blanc" width="45" height="25" ALIGN="ABSMIDDLE"> Dias con comedor lleno <br>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="5" BORDER="0"></div></TD>
					</TR>
					<TR>
						<TD COLSPAN="2" ALIGN="CENTER"><div style="float:left; border:1px solid #999966;" id="calendar-container"></div>					</TD>
					</TR>
					<TR>
						<TD COLSPAN="2" HEIGHT="22"><div id="calendari_matinit"></div>					</TR>
<!-- **************************************************************************************-->
					<TR>
						<TD><FONT COLOR="#CC3333">*</FONT>Hora:&nbsp;</TD>
						<TD WIDTH="100%"  id="tdhora"><INPUT NAME="hora" TYPE="TEXT" id="hora" style="width: 60px;" VAL="OB" ALT="Por favor, indique la hora (HH:MM)."></TD>
					</TR>
					<TR>
						<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"></TD>
					</TR>
					<TR>
						<TD><FONT COLOR="#CC3333">*</FONT>Men&uacute;:&nbsp;</TD>
						<TD>
                       
				          <p>
				            <select name="menu" id="menu" style="width: 260px;"  val="OB" alt="Por favor, seleccione un menú.">
                              <option value="">Escoger men&uacute;:</option>
                              <option value="0">Men&uacute; nº1 ..............<? echo $ini_array["menu1_1"]?> €</option>
                              <option value="1">Men&uacute; nº1 Celebraci&oacute;n...<? echo $ini_array["menu1c_1"]?> €</option>
                              <option value="2">Men&uacute; nº2 ..............<? echo $ini_array["menu2_1"]?> €</option>
                              <option value="3">Men&uacute; nº2 Celebraci&oacute;n ..<? echo $ini_array["menu2c_1"]?> €</option>
                              <option value="4">Men&uacute; nº3 ..............<? echo $ini_array["menu3_1"]?> €</option>
                              <option value="9">Men&uacute; nº4 ..............<? echo $ini_array["menu4_1"]?> €</option>
                              <?php if ($ini_array["calsoton"]){ ?>
                              <option value="5">Men&uacute; Cal&ccedil;otada ........<? echo $ini_array["menuc_1"]; ?> €</option>
                              <? }?>
                              <option value="6">Men&uacute; Comuni&oacute;n .........<? echo $ini_array["menucomu_1"]?> €</option>
                              <option value="7">Men&uacute; Bodas ............<? echo $ini_array["menucasam_1"]?> €</option>
                            </select>
				          </p>				          </TD>
					</TR>
					<TR>
					  <TD>&nbsp;</TD>
					  <TD>
						  <div class="calsotada" style="display:none;">
							<p>Si alg&uacute;n comensal <strong>NO desea cal&ccedil;otada</strong>, la puede substituir por el men&uacute; N&ordm;1.</p>
							<p>Indique, a continuaci&oacute;n, cuántos  comensales tomar&aacute;n men&uacute; N&ordm;1 en lugar de cal&ccedil;otada:</p>
							<p align="justify"><strong>Reservar Men&uacute; n&ordm;1 para
							    <input id="nocalsot" name="nocalsots" type="text" size="2" maxlength="2" value="0" style="text-align:right">
							  personas que NO desean cal&ccedil;otada.<br>
							  </strong><span class="petita Estilo1" style="margin-left:125px">(indique n&uacute;mero*)</span><br>
							  <br>
							  <span  class="petita Estilo1">* Indicando cero entendemos que <strong>TODOS</strong> comer&aacute;n cal&ccedil;otada</span>						  </p>
							</div>					      </TD>
					  </TR>
				</TABLE>				</TD>
			</TR>
			<TR> 
				<TD COLSPAN="2">
<HR WIDTH="310" SIZE="1" NOSHADE>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="310">
					<TR>
						<TD><B>CUBIERTOS</B><BR>
Por favor, indique el n&uacute;mero de ni&ntilde;os y de cochecitos, en caso de no haber escriba 0<BR>
&nbsp;</TD>
					</TR>
					
                    <TR>
						<TD ALIGN="RIGHT"><FONT COLOR="#CC3333">*</FONT>Adultos (m&iacute;nimo 9): <INPUT TYPE="TEXT" NAME="adults" style="width: 30px;" VAL="MM" MIN="9" ALT="Por favor, especifique el número de adultos."><BR>
<FONT COLOR="#CC3333">*</FONT>Niños de 10 a 14 a&ntilde;os (men&uacute; Junior): 
<INPUT TYPE="TEXT" NAME="nens10_14" style="width: 30px;" VAL="MM" MIN="0" ALT="Por favor, especifique el número de chicos."  id="jrs"  onChange="mnu_junior()" ><br>
<div id="mnjrs" style="display:none">
<FONT COLOR="#CC3333">*</FONT>Men&uacute; junior:
<select name="txt_1"  id="xmnjrs" style="width:190px;">
  <option value="junior" selected="selected">Men&uacute; junior ....<? echo $ini_array["menu1_4"]?> €</option>
  <option value="jr_comu;">Men&uacute; comuni&oacute;n ..<? echo $ini_array["menucomu_3"]?> €</option>
  <option value="jr_casa">Men&uacute; boda ......<? echo $ini_array["menucasam_3"]?> €</option>
</select>
</div>


<FONT COLOR="#CC3333">*</FONT>Nens de 4 a 9 anys (men&uacute; Infantil): <INPUT TYPE="TEXT" NAME="nens4_9" style="width: 30px;" VAL="MM" MIN="0" ALT="Por favor, especifique el número de ni&ntilde;os." id="nens"  onChange="mnu_nens()"><BR>
<div id="mnnens" style="display:none">
<FONT COLOR="#CC3333">*</FONT>Men&uacute; niños:
<select name="txt_2" id="xmnnens"  style="width:190px;"	>
  <option value="infantil" selected="selected">Men&uacute; infantil ..<? echo $ini_array["menu1_3"]?> €</option>
  <option value="inf_comu;">Men&uacute; comuni&oacute;n ..<? echo $ini_array["menucomu_2"]?> €</option>
  <option value="inf_casa">Men&uacute; boda ......<? echo $ini_array["menucasam_2"]?> €</option>
</select>
</div>





<FONT COLOR="#CC3333">*</FONT>Cochecitos de beb&eacute;s (m&aacute;ximo 2): 
<INPUT TYPE="TEXT" NAME="cotxets" style="width: 30px;" VAL="MM" MIN="0" MAX="2" ALT="Por favor, especifique el número de cochecitos. En caso de ser más de dos llame al restaurante."></TD>
					</TR>
				</TABLE>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
<CENTER>(Todos los <B>ni&ntilde;os</B> a partir de 4 a&ntilde;os tendr&aacute;n que<BR>
<B>consumir 1 men&uacute;</B> cada uno)
</CENTER></TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><HR WIDTH="310" SIZE="1" NOSHADE></TD>
			</TR>
			<TR> 
				<TD COLSPAN="2"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
Otras observaciones:<BR>
<textarea name="observacions" rows="6" id="observacions"></textarea></TD>
			</TR>
			<TR class="test">
			  <TD COLSPAN="2" ALIGN="CENTER"><div align="left">
			    <input name="factura[]" type="checkbox" id="factura" value="1"  >
			    Deseo recibir factura ProForma
			    </div>
			  <div id="factura_dades"> 
				    <div align="left" >CIF/NIF<br>
				        <input name="factura_cif" type="text" id="factura_cif" size="10" >
				        <br>
				      Nombre<br>
				      <input name="factura_nom" type="text" id="factura_nom" size="49" >
				      <br>
				      Direcci&oacute;n<br>
				      <textarea name="factura_adresa" rows="2"  id="factura_adresa"></textarea>
				      
				      </div>
				  </div></TD>
			  </TR>
			
			<TR> 
				<TD COLSPAN="2" ALIGN="CENTER"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
(Esta informaci&oacute;n <B>en ning&uacute;n caso</B> ser&aacute; una reserva)<BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="8" BORDER="0"><BR>
<INPUT TYPE="SUBMIT" VALUE="ENVIAR" CLASS="bt">&nbsp;<INPUT TYPE="RESET" VALUE="Borrar" CLASS="bt"></TD>
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