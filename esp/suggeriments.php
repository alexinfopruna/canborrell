<?php
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");

if(@file_exists('/home/5500/webs/manfali.es/htdocs/librariesets.php')) { require_once('/home/5500/webs/manfali.es/htdocs/librariesets.php'); }
if(@file_exists('/home/5500/webs/escaan.com/htdocs/librariesets.php')) { require_once('/home/5500/webs/escaan.com/htdocs/librariesets.php'); }

/*
function valor($camp) 
{
	$ini_array = parse_ini_file("../canborrellxxx.ini");
	print  str_replace("[*]","<BR>", $ini_array[$camp]); 
}
*/
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE> Masia Can Borrell </TITLE>
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
<BODY>
<CENTER>
<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775" HEIGHT="100%" BORDER="0">
	<TR>
		<TD BACKGROUND="../img/fons_3a.jpg" COLSPAN="2" ALIGN="RIGHT"><A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICIO"></A></TD>
	</TR>
	<TR>
		<TD BGCOLOR="#570600" COLSPAN="2" ALIGN="CENTER">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="18" BORDER="0">
			<TR>
				<TD><A HREF="index.html">CAN BORRELL</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="fotos.html">FOTOS-VIDEO</A> <A NAME="0"><IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"></A> <A HREF="plats.php" CLASS="selec">CARTA Y MEN&Uacute;</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  <A HREF="on.html">MAPA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="excursions.html">EXCURSIONES</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="historia.html">HISTORIA</A></TD>
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
				<TD CLASS="transparent"><A HREF="plats.php">Carta</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#2">Men&uacute; nº1</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#3">Men&uacute; nº1 Celebraci&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#4">Men&uacute; nº2</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#5">Men&uacute; nº2 Celebraci&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#6">Men&uacute; nº3</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#10">Men&uacute; nº4</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#7">Men&uacute; Cal&ccedil;otada</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#8">Men&uacute; Comuni&oacute;n</A></TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD CLASS="transparent"><A HREF="plats.php#9">Men&uacute; Bodas</A></TD>
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
				<TD CLASS="opac"><IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="2" BORDER="0"><BR>
<FONT COLOR="#FFFFFF"><B>Sugerencias y informaci&oacute;n general</B></FONT><BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="3" BORDER="0"></TD>
			</TR>
		</TABLE>
		</TD>
		<TD style="background-image:url(../img/fons_3c.jpg); background-repeat:no-repeat;" WIDTH="621" ALIGN="CENTER" VALIGN="TOP">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="490" BORDER="0">
			<TR>
				<TD ALIGN="CENTER">&nbsp;<BR>
&nbsp;<BR>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
					<TR>
						<TD><?php echo nl2br(SUGGERIMENTS_ES);//valor("Sugerencias"); ?></TD>
					</TR>
				</TABLE>
&nbsp;<BR>
&nbsp;<BR>
<A HREF="javascript:openFoto('../img/f_plats_4.html','_blank',450,310)"><IMG SRC="../img/f_plats_4pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><A HREF="javascript:openFoto('../img/f_plats_8.html','_blank',450,300)"><IMG SRC="../img/f_plats_8pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar" HSPACE="7"></A><A HREF="javascript:openFoto('../img/f_plats_21.html','_blank',450,319)"><IMG SRC="../img/f_plats_21pt.jpg" WIDTH="80" HEIGHT="80" BORDER="0" ALT="Foto" TITLE="Ampliar"></A><BR>
&nbsp;<BR>
Para m&aacute;s informaci&oacute;n: <FONT CLASS="titol"><B>93 692 97 23</B></FONT><BR>
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