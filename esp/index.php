<?php
            define('ROOT',"../taules/");
            require_once (ROOT."gestor_reserves.php");  
            $g=new gestor_reserves();
             
            $extres['subject']="Can Borrell: FORMULARI DE CONTACTE HOME";
		$extres['reserva_consulta_online']=$_POST['reserva_consulta_online'];
		$extres['client_email']=$_POST['client_email'];
		$extres['client_nom']=$_POST['client_nom'];
		$extres['client_cognoms']="";
                
            if ($_REQUEST['client_email']){
                $g->enviaMail(null, "../reservar/contactar_restaurant_",MAIL_RESTAURANT,$extres);
                header("Location: ".  $_SERVER['PHP_SELF']."?snd");
                echo '<script>var ENVIAT=true;</script>';
            }
           include("../reservar/translate_es.php");
?><HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE> Masia Can Borrell </TITLE>

	 <?php 
     
         echo Gestor::loadJQuery(); 
         
         /* CONTACTE */
         
            
            if (isset($_REQUEST['snd'])) echo '<script>var ENVIAT=true;</script>';
         ?>
 	<script type="text/javascript" src="../js/dynmenu.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="../taules/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../taules/js/jquery.validate_es.js"></script>

       <link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
	<LINK rel="stylesheet" type="text/css" href="../estils.css">

        <script>
            $(function(){
                if (typeof ENVIAT != 'undefined') $(".cb-contacte").html('<span style="color:green">Correo enviado!</span>');
                else   $(".cb-contacte").html("<button>Contacto</button>").click(function(){$("#caixa_contacte").dialog("open")});
                
        $("#caixa_contacte").dialog({
                    autoOpen:false,
                    title:"Formulario de contacto",
                });
                $("#form_contactar").validate({
                    errorElement: "em",
                });
                
            });
        </script>


	
	
</HEAD>
<BODY onload="loadMenu()">
<CENTER>

<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775" HEIGHT="100%" BORDER="0">
	<TR>
		<TD BACKGROUND="../img/fons_1a.jpg" COLSPAN="2" ALIGN="RIGHT">
		
		<div class="novetat ui-corner-all">
			<a href="../reservar/form.php?lang=cat" title="Reserva online ràpida i senzilla: Des de casa, sense trucades ni esperes">
                            Reserva online, <b>ahora también desde el móvil</b>
			</a>
		</div>
		
		<A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICI"></A>
                </TD>
	</TR>
	<TR>
		<TD BGCOLOR="#570600" COLSPAN="2" ALIGN="CENTER">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="18" BORDER="0">
			<TR>
				<TD ALIGN="CENTER"><FONT COLOR="#FFFFFF"><B>CAN BORRELL</B></FONT> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="fotos.html">FOTOS-V&Iacute;DEO</A> <A NAME="0"><IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"></A> <A HREF="plats.php">CARTA i MEN&Uacute;</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  <A HREF="on.html">ON SOM: MAPA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="excursions.html">EXCURSIONS</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="historia.html">HIST&Ograve;RIA</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="horaris.html">HORARI</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="reserves.html">RESERVES</A> <IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> <A HREF="contactar.php">CONTACTAR</A></TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
	<TR>
		<TD style="background-image:url(../img/fons_1b.jpg); background-repeat:no-repeat;" HEIGHT="100%" WIDTH="154" ALIGN="RIGHT" VALIGN="BOTTOM"><B>Masia Can Borrell<BR>
Sant Cugat del Vall&egrave;s</B><BR>
<span class="cb-contacte">Tel.: 93 692 97 23<BR>
93 691 06 05<BR>
Fax: 93 692 40 57</span><BR>
<IMG SRC="../img/pix.gif" WIDTH="1" HEIGHT="38" BORDER="0"></TD>
		<TD style="background-image:url(../img/fons_1c.jpg); background-repeat:no-repeat;" WIDTH="621" ALIGN="CENTER" VALIGN="TOP">
		<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="490" BORDER="0">
			<TR>
				<TD>&nbsp;<BR>
<BR>
<BR>
La masía de Can Borrell se encuentra en un entorno privilegiado. Situada al término municipal de Sant Cugat del Vallès, y con una extensión de 216 hectáreas es en pleno corazón del Parc Natural de Collserola.<BR>
<IMG SRC="../img/f_canborrell_1.jpg" WIDTH="332" HEIGHT="220" BORDER="0" ALT="Foto" VSPACE="12"><IMG SRC="../img/pix.gif" WIDTH="12" HEIGHT="1" BORDER="0"><IMG SRC="../img/f_canborrell_2.jpg" WIDTH="146" HEIGHT="220" BORDER="0" ALT="Foto" VSPACE="12"><BR>
<BR>
Esta bella masía disfruta de un paisaje forestal y agrícola que nos hace reencontrar con la naturaleza y nos hace pensar que estamos lejos del área metropolitana, a pesar de estar a escasos veinte minutos de Barcelona.&nbsp;<BR>
<CENTER>Carretera d'Horta a Cerdanyola (BV-1415), km 3 - 08171 Sant Cugat del Vall&egrave;s</CENTER><BR>
&nbsp;</TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
        <tr><td><BR><BR><BR></TD><td></TD></TR>
</TABLE>
</CENTER>
<?php

  include("../form_contacte.php");
?>

</BODY>
</HTML>