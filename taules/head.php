<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>MenjadorEditor</title>
		
<link type="text/css" href="css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link rel="stylesheet" type="text/css" href="js/jquery-autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="js/jquery-autocomplete/lib/thickbox.css" />

<link type="text/css" href="css/admin.css" rel="stylesheet" />	
<link type="text/css" href="css/taules.css" rel="stylesheet" />	

		<!--<script type="text/javascript">
			document.write("\<script src='//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'>\<\/script>");
		</script>				
		<script type="text/javascript" src="js/include.js"></script>-->


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
  <?php //RES ?>
  <!-- -->
<!-- <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>


  <script>alert("JQUERY");</script>
	<script src="js/jquery-1.5.min.js"></script>-->



		<script type="text/javascript" src="js/ui/js/jquery-ui-1.8.9.custom.min.js"></script>
		<script type="text/javascript" src="js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
		<script type="text/javascript" src="js/jquery.metadata.js"></script>
		<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"> </script>
		<script type="text/javascript" src="js/jquery.bestupper.min.js"></script> 
		<script type="text/javascript" src="js/jquery.timers.js"></script>
		<script type="text/javascript" src="js/jquery-autocomplete/jquery.autocomplete.js"></script> 
		<script type="text/javascript" src="js/swfobject.js"></script> 
		<script type="text/javascript" src="js/jquery.fileDownload.js"></script> 

		<script type="text/javascript" src="js/taules.js"></script>

		<script type="text/javascript" src="js/calendari.js"></script>
		<script type="text/javascript" src="js/as3.js"></script>
		<script type="text/javascript" src="js/hores.js"></script>
		<script type="text/javascript" src="js/resposta.js"></script>

<?php
// corregeix si és DL o DM o dia passat
if (isset($_SESSION['data']) && $_SESSION['data']<date("Y-m-d")) $_SESSION['data']=date("Y-m-d");
$date=date("d/m/Y");
if (strftime('%w',strtotime(date("Y-m-d")))==1) $date= date("d/m/Y", strtotime('+2 day')) ; 
if (strftime('%w',strtotime(date("Y-m-d")))==2) $date= date("d/m/Y", strtotime('+1 day')) ; 

if (!isset($_SESSION['torn'])) $_SESSION['torn']=1;

// DEV CSS
if (strpos($_SERVER['SCRIPT_FILENAME'], "_dev")) $bg = "dev";
if ($_SERVER['HTTP_HOST']=="localhost" ) $bg = "local";



/*****************************************/
// CONSTANTS LOADCONFIG PER JS
/*****************************************/	
  echo $gestor->dumpJSVars(true);
?>


<script>
	<?php 
		$llista_negra=llegir_dies(LLISTA_DIES_NEGRA);
		$llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
		print crea_llista_js($llista_negra,"LLISTA_NEGRA"); 
		print "\n\n";	
		print crea_llista_js($llista_blanca,"LLISTA_BLANCA");  	
		$data=isset($_SESSION['data'])?$gestor->cambiaf_a_normal($_SESSION['data']):$date;
		print "date_session='".$data."';\n";
		print "var permisos='".$_SESSION['permisos']."';\n";
		print "var torn_session='".$_SESSION['torn']."';\n";
		print 'var arxiu="produccio";'."\n";
				

		if (isset($_REQUEST['Historic']))
		{
			$passat = "Futur";
			print "var historic=1;\n";
		}
		else  
		{
			$passat = "Historic";
			print "var historic=0;\n";
		}
// TODO AUTO DEFINE
		print "var CONFIG='".$CONFIG."';\n";
		
	?>
</script>