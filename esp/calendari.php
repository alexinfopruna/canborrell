<?php header('Content-Type: text/html; charset=ISO-8859-15');

if (!defined('ROOT')) define('ROOT', "../taules/");
require(ROOT."Gestor.php");


?>


if(@file_exists('/home/5500/webs/manfali.es/htdocs/librariesets.php')) { require_once('/home/5500/webs/manfali.es/htdocs/librariesets.php'); }
if(@file_exists('/home/5500/webs/escaan.com/htdocs/librariesets.php')) { require_once('/home/5500/webs/escaan.com/htdocs/librariesets.php'); }
<div id="calendarix">
						<script type="text/javascript">
						  function dateChanged(calendar) {
						    if (calendar.dateClicked) {
						      var y = calendar.date.getFullYear();
						      var m = calendar.date.getMonth();     // integer, 0..11
						      var d = calendar.date.getDate();      // integer, 1..31
						      document.getElementById('DATA').value = calendar.date;
							  var d = new Date();
							  d = calendar.date;
                              
                              //document.getElementById('DATA3').value=d;
							  document.getElementById('DATA').value = Setmana[d.getDay()]+", "+calendar.date.getDate()+" "+Mesos[calendar.date.getMonth()]+ " de "+calendar.date.getFullYear();
							  
document.getElementById('DATA2').value=calendar.date.getDate()+"/"+(calendar.date.getMonth()+1)+"/"+calendar.date.getFullYear();							  
						    }
						  };
						  
///// ALEX	
	
<?php
// torn 0=migdia / 1=nit

$fitxer=INC_FILE_PATH."bloq.txt";
if ($_GET["torn"]) $fitxer=INC_FILE_PATH."bloq_nit.txt";

require(INC_FILE_PATH."llista_dies.php");
$dies=llegir_dies($fitxer);  
crea_llista_js($dies);
?>				  
function dateIsSpecial(year, month, day) {
var m = SPECIAL_DAYS[month];
if (!m) return false;
for (var i in m) if (m[i] == day) return true;
return false;
};

function ourDateStatusFunc(date, y, m, d) {
if (dateIsSpecial(y, m, d))
return "disabled";
else
return false; // other dates are enabled
// return true if you want to disable other dates
};
				  

						  Calendar.setup(
						    {
								firstDay:1,
								weekNumbers: false,
						      flat         : "calendar-container", // ID of the parent element
						      flatCallback : dateChanged,          // our callback function
							  dateStatusFunc : ourDateStatusFunc

						    }
						  );
						  
var Setmana = ["Domingo","Lunes","Martes","Mi�rcoles","Jueves","Viernes","S�bado"];
var Mesos = ["de Enero","de Febrero","de Marzo","de Abril","de Mayo","de Junio","de Julio", "de Agosto","de Septiembre","de Octubre","de Noviembre", "de Diciembre"];
// NO MODIFICAR RES A PARTIR D'AQUEST PUNT *************************************************
// Comprova si n �s un valor num�ric.
function isInt(n) {
	if (!((n >= "0") && (n <= "9")))
		return false
	else
		return true;
}
// quindiaes(nom_input_dia,nom_input_mes,nom_input_any,nom_input_on_imprimim_resultat)
function quindiaes(dd,mm,aa,ii){
	dia = document.getElementById(dd).value;
	mes = document.getElementById(mm).value;
	any = document.getElementById(aa).value;
	if(!isInt(dia)) {document.getElementById(ii).value ="";return;}
	if(!isInt(mes)) {document.getElementById(ii).value ="";return;}
	if(!isInt(any)) {document.getElementById(ii).value ="";return;}
	var d = new Date();
	d.setDate(dia);
	d.setMonth(mes - 1);
	d.setFullYear(any);
	document.getElementById(ii).value = Setmana[d.getDay()]+", "+dia+" "+Mesos[mes-1]+ " de "+any;
}
////////////////////////////////////////


						  
						</script>
						
<input type="text" value="" ID="DATA" name="data" style="width: 100%; border:0px; font-weight:bold; background-color:#F8F8F0; color:#999966;" VAL="OB" ALT="Si us plau, tri� una data." READONLY>
						<input type="hidden" value="" ID="DATA2" name="DATA2" style="width: 100%; border:0px; font-weight:bold; background-color:#F8F8F0; color:#999966;"  READONLY>
						
</div>