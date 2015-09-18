<?php
	$url=$_GET['url'];
	if (!isset($_SESSION)) session_start();
	if (isset($_SESSION['lang'])) $lang=$_SESSION['lang'];
	
	if (stristr($url,"lang=cat")) $lang="cat";
	if (stristr($url,"lang=esp")) $lang="esp";
	if (stristr($url,"/cat/")) $lang="cat";
	else if (stristr($url,"/esp/")) $lang="esp";
	
	if ($lang!='cat' && $lang!='esp') $lang='esp';
	
	$_SESSION['lang']=$lang;
	$l=substr($lang,0,2);
	if (!function_exists("l")) require_once("translate_menu_$l.php");
	
	$ruta_lang="../$lang/";
	echo '<span id="INFO_____MENU" style="color:white;display:none;">';
	echo "<br/>url=$url";
	echo "<br/>ruta_lang=$ruta_lang";
	echo "<br/>lang=$lang";
	echo '</span>';
	function active($desti)
	{
		global $lang;
		global $ruta_lang;
		
		$url=$_GET['url'];
		
		
		$parts=pathinfo	($url);
		$root=parse_url($url);
		$root=$root['host'];
		
		$self=$parts['filename'];
		
		$parts=pathinfo($desti);
		$dest=$parts['filename'];
		
		
		$self=substr($self,0,strlen($dest));
		
		$class=($dest==$self)?'menu-active':'';
		echo ' href="'.$ruta_lang.$desti.'" class="'.$class.'" ';
	}
?>
		<table id="table_menu" style="margin:auto auto;">
			<TR id="tr_menu">
				<TD ALIGN="CENTER">
					<A <?php active('index.php')?>><?php l("CAN BORRELL");?></A>  
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					
					<A <?php active('fotos.html')?> ><?php l("FOTOS-VIDEO");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					
					<A <?php active('plats.php')?>><?php l("CARTA I MENU")?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  
					
					<A <?php active('on.html')?>><?php l("ON SOM: MAPA");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					
					<A <?php active('excursions.html')?>><?php l("EXCURSIONS");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					
					<A <?php active('historia.html')?>><?php l("HISTORIA");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					<!--  -->
					<A <?php active('premsa.html')?>><?php l("PREMSA");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0"> 
					
					<A <?php active('horaris.html')?>><?php l("HORARI");?></A> 
					<IMG SRC="../img/separa_mn.gif" WIDTH="1" HEIGHT="8" BORDER="0">  
					
					<A <?php active('../reservar/form.php')?>><?php l("RESERVES");?></A>
					<!--<A <?php active('contactar.php')?>><?php l("RESERVES");?></A> -->
				</TD>
			</TR>
		</table>
