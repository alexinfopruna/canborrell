<?php
require_once("gestor_reserves.php");
$gestor=new gestor_reserves();   
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MenjadorEditor</title>
		<link type="text/css" href="css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
		<link type="text/css" href="css/taules.css" rel="stylesheet" />	
		
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-2.0.3.min.js">\x3C/script>')</script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>    
<script type="text/javascript">
    /* */
    if (typeof jQuery.ui == 'undefined') {
        document.write(unescape("%3Cscript src='js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js' type='text/javascript'%3E%3C/script%3E"));
    };
</script>                		
		<script src="js/hores.js" type="text/javascript"></script> 
		<script src="js/swfobject.js" type="text/javascript"></script> 
		
<?php
/*****************************************/
// CONSTANTS LOADCONFIG PER JS
/*****************************************/	
echo $gestor->dumpJSVars(true);
?>
<script>

var data="BASE";
$(function(){
var flashvars={};
flashvars['DEBUG']=DEBUG;
flashvars['URL']=url_base;
flashvars['DATA']=0;// NO S'UTILITZA
flashvars['TORN']=0;// NO S'UTILITZA

var params = {
  wmode: "opaque"
};
var so = swfobject.embedSWF('MenjadorEditor.swf', 'flash', '760', '740', '9.0', '#FFFFFF',flashvars,params);
});

function getFlashMovie(movieName) {
	var isIE = navigator.appName.indexOf("Microsoft") != -1;
	var ret= (isIE) ? window[movieName] : document[movieName];
	return ret;
}

function fromAS3_flash_ready()
{
	getFlashMovie("flash").edbase();
}

</script>
</head>
	<body bgcolor="#ffffff">
<div id="flash" class="clearfix"> 
<p>Please upgrade your <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&amp;promoid=BUIGP">Flash player</a>.</p> 
</div> 	

<div id="form_hores" title="Modifica hores actives pel dia i torn seleccionats">Cal actualitzar les dades</div>
<a href="#" id="bt_edit_hores" torn="1" class="edbase">Editar hores TORN1</a>
<a href="#" id="bt_edit_hores2" torn="2" class="edbase">Editar hores TORN2</a>
<a href="#" id="bt_edit_hores3" torn="3" class="edbase">Editar hores TORN3</a>
</body>
</html>
