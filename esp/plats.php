<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Carta.php");
$carta=new Carta();
/*
function valor_ANTIGA($camp) 
{
	$ini_array = parse_ini_file("../canborrell.ini");
	//if (in_array ($camp, $ini_array))
		print  str_replace("[*]","<BR>", $ini_array[$camp]); 
}
*/

?>
<HTML>
<HEAD>
<TITLE> Masia Can Borrell </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK rel="stylesheet" type="text/css" href="../estils.css">
	<!-- MENU -->
	<script type="text/javascript" src="../js/dynmenu.js"></script> 
<SCRIPT>
<!--//
function openFoto(url,target,width,height) {
      var Win; 
     pos_left=( screen.width - width ) / 2 - 20;
     pos_top=( screen.height - height ) / 2 - 30;
        var Win = window.open(url,target,'width=' + width + ',height=' + height + ',resizable=0,scrollbars=no,menubar=no,status=no,left=' + pos_left + ',top=' + pos_top);
}

//-->
</SCRIPT>
</HEAD>
<BODY onload="loadXMLDoc()">
<CENTER>
<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775" HEIGHT="100%" BORDER="0">
	<TR>
		<TD BACKGROUND="../img/fons_3a.jpg" COLSPAN="2" ALIGN="RIGHT"><A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICIO"></A></TD>
	</TR>
	<TR>
		<TD id="td_menu" BGCOLOR="#570600" COLSPAN="2" ALIGN="CENTER">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="18" BORDER="0">
			<TR>
				<TD><A HREF="index.html">CAN BORRELL</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="fotos.html">FOTOS-VIDEO</A> <A NAME="0"><IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"></A> <FONT COLOR="#FFFFFF"><B>CARTA Y MEN&Uacute;</B></FONT> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  <A HREF="on.html">MAPA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="excursions.html">EXCURSIONES</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="historia.html">HISTORIA</A></TD>
				<TD ALIGN="RIGHT"><A HREF="horaris.html">HORARIOS</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="reserves.html">RESERVAS</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="contactar.php">CONTACTAR</A></TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
	<TR>
		<TD style="background-image:url(../img/fons_3b.jpg); background-repeat:no-repeat;" HEIGHT="100%" WIDTH="154" ALIGN="center" VALIGN="TOP">&nbsp;<BR>
&nbsp;<BR>
&nbsp;<BR>
&nbsp;<BR>
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="154" BORDER="0">
			<TR>
				<TD CLASS="opac"><FONT COLOR="#FFFFFF"><B>Carta</B></FONT></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#2">Men&uacute; nº1</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#3">Men&uacute; nº1 Celebraci&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#4">Men&uacute; nº2</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#5">Men&uacute; nº2 Celebraci&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#6">Men&uacute; nº3</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#10">Men&uacute; nº4</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#7">Men&uacute; Cal&ccedil;otada</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#8">Men&uacute; Comuni&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="#9">Men&uacute; Bodas</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="2" BORDER="0"><BR>
<A HREF="infomenus.html">Informaci&oacute;n<BR>sobre los Men&uacute;s</A><BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="3" BORDER="0"></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="2" BORDER="0"><BR>
<A HREF="suggeriments.php">Sugerencias y informaci&oacute;n general</A><BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="3" BORDER="0"></TD>
			</TR>
		</TABLE>
		</TD>
		<TD style="background-image:url(../img/fons_3c.jpg); background-repeat:no-repeat;" WIDTH="621" ALIGN="CENTER">
		<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
			<TR>
				<TD><A NAME="1">&nbsp;</A><BR>
&nbsp;<BR>
<FONT CLASS="titol"><B>CARTA</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Sopa casera<BR>
Ensalada verde<BR>
Escalivada<BR>
Esp&aacute;rragos trigueros a la brasa<BR>
Esp&aacute;rragos blancos<BR>
G&iacute;rgolas a la brasa<BR>
Cal&ccedil;ots (temporada)<BR>
Alcachofas a la brasa (temporada)<BR>
Esqueixada<BR>
Entrem&egrave;s<BR>
Caracoles de la casa<BR>
Surtido de pat&eacute;s<BR>
Anchoas de la Escala<BR>
Mel&oacute;n o Pinya con jam&oacute;n<BR>
Cogollos con at&uacute;n y anchoas<BR>
Caracoles &quot;a la llauna&quot;<BR>
&nbsp;<BR>
</UL>
<B>CARNES</B>
<UL>
Cordero a la brasa (3 piezas)<BR>
Costilla de cordero a la brasa (unidad)<BR>
Espalda de cordero a la brasa<BR>
Conejo a la brasa (1/2 pieza)<BR>
Butifarra a la brasa<BR>
Butifarra negra a la brasa<BR>
Pollo a la brasa (1/2 pieza)<BR>
Costilla de ternera a la brasa<BR>
Mand&iacute;bula de cerdo a la brasa (unidad)<BR>
Ternera con setas<BR>
Manitas de cerdo a la brasa (3 piezas)<BR>
Lomo a la brasa<BR>
&nbsp;<BR>
</UL>
<B>PESCADO</B>
<UL>
Mojama a la brasa<BR>
Lubina a la brasa<BR>
&nbsp;<BR>
</UL>
<B>COMPLEMENTOS</B>
<UL>
Jud&iacute;as &quot;del Ganxet&quot;<BR>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
Alioli<BR>
Pan tostado<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>RACIONES</B>
<UL>
Queso<BR>
Jam&oacute;n serrano<BR>
Longaniza<BR>
Chorizo<BR>
&nbsp;<BR>
</UL>
<B>PRECIO</B>
<UL>
Nuestro precio medio aproximado es de: <?php echo PREU_MIG ?> Euros (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="40" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_7.html','_blank',400,361)"><IMG SRC="../img/f_plats_7pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_15.html','_blank',450,300)"><IMG SRC="../img/f_plats_15pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_14.html','_blank',450,286)"><IMG SRC="../img/f_plats_14pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="2">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; Nº 1</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Ensalada<BR>
Escalivada<BR>
G&iacute;rgolas<BR>
Esp&aacute;rragos a la brasa<BR>
Alcachofas<BR>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
Alioli<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<BR>
Conejo<BR>
Pollo<BR>
Butifarra<BR>
Lomo<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta Selva trufa<BR>
Tarta de lim&oacute;n<BR>
Tarta whisky<BR>
Copa sorbete lim&oacute;n<BR>
Crema catalana<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2001); ?> Euros/unidad adultos (IVA incluido)<BR>
<?php echo $carta->preuPlat(2002); ?> Euros/unidad adultos con cava (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Infantil</B> (ni&ntilde;os de 4 a 9 a&ntilde;os)<BR>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2037); ?> Euros/unidad (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Junior</B> (de 10 a 14 a&ntilde;os)<BR>
Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2036); ?> Euros/unidad (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_2.html','_blank',380,450)"><IMG SRC="../img/f_plats_2pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_6.html','_blank',450,373)"><IMG SRC="../img/f_plats_6pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="3">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; Nº 1 CELEBRACI&Oacute;N</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Ensalada<BR>
Escalivada<BR>
G&iacute;rgolas<BR>
Esp&aacute;rragos a la brasa<BR>
Alcachofas<BR>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
Alioli<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<BR>
Conejo<BR>
Pollo<BR>
Butifarra<BR>
Lomo<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta de yema quemada<BR>
Tarta de nata y trufa<BR>
Tarta massini<BR>
Tarta de lim&oacute;n<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2024); ?> Euros/unidad adultos sin cava (IVA incluido)<BR>
<?php echo $carta->preuPlat(2025); ?> Euros/unidad adultos con cava (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Infantil</B> (ni&ntilde;os de 4 a 9 a&ntilde;os)<BR>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2037); ?> Euros/unidad (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Junior</B> (de 10 a 14 a&ntilde;os)<BR>
Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2036); ?> Euros/unidad (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_9.html','_blank',450,316)"><IMG SRC="../img/f_plats_9pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_12.html','_blank',450,315)"><IMG SRC="../img/f_plats_12pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="4">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; Nº 2</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Longaniza<BR>
Chorizo<BR>
Pat&eacute; de Jabugo<BR>
Ensalada<BR>
Escalivada<BR>
Alioli<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>SEGUNDOS</B>
<UL>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
G&iacute;rgolas a la brasa<BR>
Esp&aacute;rragos a la brasa<BR>
Alcachofas a la brasa<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<BR>
Conejo<BR>
Pollo<BR>
Lomo<BR>
Butifarra<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta whisky<BR>
Flan biscuit<BR>
Crema Catalana<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2003); ?> Euros/unidad adultos sin cava (IVA incluido)<BR>
<?php echo $carta->preuPlat(2004); ?> Euros/unidad adultos con cava (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Infantil</B> (ni&ntilde;os de 4 a 9 a&ntilde;os)<BR>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2037); ?> Euros/unidad (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Junior</B> (de 10 a 14 a&ntilde;os)<BR>
Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2036); ?> Euros/unidad (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_16.html','_blank',450,300)"><IMG SRC="../img/f_plats_16pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_10.html','_blank',450,355)"><IMG SRC="../img/f_plats_10pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="5">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; Nº 2 CELEBRACI&Oacute;N</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Longaniza<BR>
Chorizo<BR>
Pat&eacute; de Jabugo<BR>
Ensalada<BR>
Escalivada<BR>
Alioli<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>SEGUNDOS</B>
<UL>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
G&iacute;rgolas a la brasa<BR>
Esp&aacute;rragos a la brasa<BR>
Alcachofas a la brasa<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<BR>
Conejo<BR>
Pollo<BR>
Lomo<BR>
Butifarra<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta de yema quemada<BR>
Tarta de nata y trufa<BR>
Tarta massini<BR>
Tarta de lim&oacute;n<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2023); ?> Euros/unidad adultos sin cava (IVA incluido)<BR>
<?php echo $carta->preuPlat(2027); ?> Euros/unidad adultos con cava (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Infantil</B> (ni&ntilde;os de 4 a 9 a&ntilde;os)<BR>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2037); ?> Euros/unidad (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Junior</B> (de 10 a 14 a&ntilde;os)<BR>
Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2036); ?> Euros/unidad (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_13.html','_blank',266,450)"><IMG SRC="../img/f_plats_13pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_12.html','_blank',450,315)"><IMG SRC="../img/f_plats_12pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="6">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; Nº 3</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
Ensalada<BR>
Surtido de pat&eacute;s<BR>
Llonganiza de pay&eacute;s<BR>
Chorizo de Salamanca<BR>
Pan tostado con tomate y ajos<BR>
Alioli<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Butifarra a la brasa 1/2<BR>
Pollo a la brasa 1/4<BR>
Lomo a la brasa 1/3<BR>
Patatas fritas<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa o sangria<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta de lim&oacute;n<BR>
Tarta Selva trufa<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2012); ?> Euros (IVA incluido)</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_11.html','_blank',450,315)"><IMG SRC="../img/f_plats_11pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_5.html','_blank',450,300)"><IMG SRC="../img/f_plats_5pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="10">&nbsp;</A><BR>
    <FONT CLASS="titol"><B>MEN&Uacute; N&ordm; 4 </B></FONT></p>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
  <strong>Variado de verduras</strong><br />
  <i>(Plato por comensal) <br /><br />
	Escalivada<br />
	Girgolas<br />
	Esp&aacute;rragos <br />
	Alcahofas temporada<br />
  &nbsp;<BR>
</UL>
<B>CARNES A LA BRASA </B><br />
<i>(Raci&oacute;n individual a escoger)</i><br /><br />
<UL>
  Conejo<BR>
    Butifarra<br>
    Pollo<br>
    Lomo<br>
    Quijada de cerdo<br>
    Pies de cerdo
    <BR>
  &nbsp;</p>
  </UL>
<B>GUARNICIONES</B>
<UL>
  Judias con tocino <BR>
  Patatas fritas <BR>
  Alioli<br>
  Pan tostado con tomate
</UL>
<B>BODEGA</B>
<UL>
  Vino de la Casa o sangria<BR>
  Gaseosa<BR>
  Agua<BR>
  &nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
  Mus de lim&oacute;n<BR>
  Tarta Selva trufa<br>
  Vastigo Turr&oacute;n<br>
  Falm 
  <BR>
  &nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS </B><BR>
<B>CHUPITOS<br>
<br>
</B>
<P>&nbsp;<B>PRECIO</B>
<UL>
  <?php echo $carta->preuPlat(2007); ?>
   Euros (IVA incluido)
</UL>
<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_13.html','_blank',450,315)"><IMG SRC="../img/f_plats_13pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_20.html','_blank',450,300)"><IMG SRC="../img/f_plats_20pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A>&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->

<A NAME="7">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; CAL&Ccedil;OTADA</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>ENTRANTES</B>
<UL>
CAL&Ccedil;OTS (temporada)<BR>
Incluye repetici&oacute;n<BR>
&nbsp;<BR>
Jud&iacute;as con tocino<BR>
Patatas fritas<BR>
Alioli<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<BR>
Conejo<BR>
Pollo<BR>
Butifarra<BR>
Lomo<BR>
&nbsp;<BR>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<BR>
Gaseosa<BR>
Agua<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Tarta Selva trufa<BR>
Tarta de lim&oacute;n<BR>
Tarta al whisky<BR>
Copa sorbete-lim&oacute;n<BR>
Crema Catalana<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2010); ?> Euros (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Infantil</B> (ni&ntilde;os de 4 a 9 a&ntilde;os)<BR>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2037); ?> Euros/unidad (IVA incluido)<BR>
&nbsp;<BR>
<B>Men&uacute; Junior</B> (de 10 a 14 a&ntilde;os)<BR>
Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<BR>
<?php echo $carta->preuPlat(2036); ?> Euros/unidad (IVA incluido)
</UL>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="69" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_17.html','_blank',399,450)"><IMG SRC="../img/f_plats_17pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_18.html','_blank',450,315)"><IMG SRC="../img/f_plats_18pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="8">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; COMUNI&Oacute;N</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>VERMUT</B>
<P>
<B>APERITVO</B>
<UL>
Lagostinos<BR>
Patatas chips<BR>
Almendras saladas<BR>
Aceitunas rellenas<BR>
Calamares a la romana<BR>
Tacos tortilla<BR>
Sorbete<BR>
&nbsp;<BR>
</UL>
<B>PRIMEROS</B>
<UL>
Entremeses individual<BR>
Ensalada y Pat&eacute;s<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>SEGUNDOS (Parrillada)</B>
<UL>
Patatas fritas<BR>
Cordero<BR>
Lomo<BR>
Conejo<BR>
Pollo<BR>
Butifarra<BR>
Alioli<BR>
&nbsp;<BR>
</UL>
<B>PASTEL DE CELEBRACI&Oacute;N</B>
<P>&nbsp;<BR>
<B>BODEGA</B>
<UL>
Vino Cabernet tinto o rosado<BR>
Cava Brut Reserva Sard&agrave;<BR>
Agua y refrescos<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2013); ?> Euros (IVA incluido)<BR>
&nbsp;<BR>
<B>Ni&ntilde;os:</B><BR>
<?php echo $carta->preuPlat(2017); ?> Euros ni&ntilde;os de 4 a 9 a&ntilde;os (IVA incluido)<BR>
<?php echo $carta->preuPlat(2018); ?> Euros ni&ntilde;os de 10 a 14 a&ntilde;os (IVA incluido)
</UL>
<B>Incluido centro de flores</B><BR>
&nbsp;<BR>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="40" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_19.html','_blank',450,320)"><IMG SRC="../img/f_plats_19pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_20.html','_blank',450,317)"><IMG SRC="../img/f_plats_20pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_12.html','_blank',450,315)"><IMG SRC="../img/f_plats_12pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
<!---------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->
<A NAME="9">&nbsp;</A><BR>
<FONT CLASS="titol"><B>MEN&Uacute; BODAS</B></FONT>
<HR SIZE="1">
&nbsp;<BR>
<B>APERITVO</B>
<UL>
Lagostinos<BR>
Patatas chips<BR>
Almendras saladas<BR>
Aceitunas rellenas<BR>
Calamares a la romana<BR>
Tacos tortilla<BR>
Sorbete<BR>
&nbsp;<BR>
</UL>
<B>PRIMEROS</B>
<UL>
Entremeses<BR>
Ensalada<BR>
Escalivada<BR>
Esp&aacute;rragos<BR>
G&iacute;rgolas<BR>
Pan tostado con tomate<BR>
&nbsp;<BR>
</UL>
<B>SEGUNDOS (Parrillada)</B>
<UL>
Cordero<BR>
Lomo<BR>
Conejo<BR>
Pollo<BR>
Butifarra<BR>
Alioli<BR>
&nbsp;<BR>
</UL>
<B>PASTEL DE BODA</B>
<P>&nbsp;<BR>
<B>BODEGA</B>
<UL>
Vino Cabernet tinto o rosado<BR>
Cava Brut Reserva Sard&agrave;<BR>
Agua y refrescos<BR>
&nbsp;<BR>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><BR>
<B>CHUPITOS</B>
<P>&nbsp;<BR>
<B>PRECIO</B>
<UL>
<?php echo $carta->preuPlat(2016); ?> Euros (IVA incluido)<BR>
&nbsp;<BR>
<B>Ni&ntilde;os:</B><BR>
<?php echo $carta->preuPlat(2021); ?> Euros ni&ntilde;os de 4 a 9 a&ntilde;os (IVA incluido)<BR>
<?php echo $carta->preuPlat(2022); ?> Euros ni&ntilde;os de 10 a 14 a&ntilde;os (IVA incluido)
</UL>
<B>Guarnici&oacute;n de flores</B><BR>
&nbsp;<BR>
&nbsp;<BR>
<IMG SRC="../img/pix.gif" WIDTH="40" HEIGHT="1" BORDER="0"><A HREF="javascript:openFoto('../img/f_plats_1.html','_blank',300,450)"><IMG SRC="../img/f_plats_1pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_3.html','_blank',350,450)"><IMG SRC="../img/f_plats_3pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A>&nbsp;<A HREF="javascript:openFoto('../img/f_plats_12.html','_blank',450,315)"><IMG SRC="../img/f_plats_12pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
<A HREF="#0"><IMG SRC="../img/bt_amunt.gif" WIDTH="15" HEIGHT="15" BORDER="0" ALT="Amunt"></A><BR>
&nbsp;<BR>
&nbsp;<BR>
&nbsp;<BR>
<B>En todos los precios est&aacute; incluido el IVA</B><BR>
Aceptamos tarjetas <B>Visa</B>, <B>Eurocard</B> y <B>Mastercard</B>.<BR>
&nbsp;<BR>
La empresa se reserva el drerecho de modificar los art&iacute;culos<BR>
y el precio de los men&uacute;s.<BR>
&nbsp;<BR>
Para m&aacute;s informaci&oacute;n:<BR>
<FONT CLASS="titol"><B>Tel.: 93 692 97 23</B></FONT><BR>
&nbsp;<BR>
&nbsp;</TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
</TABLE>
</CENTER>
</BODY>
</HTML>