<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;

$translate['EDIT_RESERVA_FORA_DE_SERVEI']='<p style="color:red">Aquest servei està temporalment fora de servei. Per cancel·lar o notificar qualsevol modificació a la teva reserva truca, si us plau, al<p>
<b>93 692 97 23</b>
<br/>
<b>93 691 06 05</b>
<p>Gracies</p>
';

//MENU
	$translate['CAN BORRELL']='CAN BORRELL';

	$translate['FOTOS-VIDEO']='FOTOS-VÍDEO';

	$translate['CARTA i MENU']='CARTA i MENÚ';

	$translate['ON SOM: MAPA']='ON SÓM: MAPA';

	$translate['EXCURSIONS']='EXCURSIONS';

	$translate['HISTÒRIA']='HISTÒRIA';

	$translate['HORARI']='HORARI';

	$translate['RESERVES']='RESERVES';

	$translate['CONTACTAR']='CONTACTAR';

//FORM
	
	$translate['NO_COBERTS_OBSERVACIONS']='<b>Només tindrem en compte els coberts/cotxets indicats a la primera secció</b>. <span style="color:red">Els canvis en el nombre de coberts o cotxets sol·licitats a les observacions seran ignorats</span>.<br/>El restaurant no pot garantir la disponibilitat de trones. Un cop al restaurant demaneu-les al personal i us la facilitarem si és possible';
	
	$translate['ERROR_LOAD_RESERVA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">No hem trobat la reserva o ja no és possible modificar-la per ser una data massa propera</div>';

	$translate['ERROR_CONTACTAR']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:red">Dades incorrectes. No es pot enviar el missatge</div>';

	$translate['CONTACTAR_OK']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:green">Missatge enviat. </div>';

$translate['[Contactar amb el restaurant]']="Contactar amb el restaurant";

$translate['[Cancel·lar/modificar una reserva existent]'] = 'Cancel·lar/modificar una reserva existent';

	
	$translate['INCIDENCIA_ONLINE']="Tens alguna incidència que no pots solucionar des d'aquest formulari. Descriu breument el teu cas i t'atendrem (via email) tan aviat com poguem";
	
$translate['INCIDENCIA_ONLINE_GRUPS']="Descriu les modificacions que <b>sol·licites</b> per a la teva reserva<br/><br/>Recorda que les modificacions <b>NO TENEN CAP VALIDESA</b> si no reps la confirmació per part del restaurant:";
	
$translate['INFO_NO_EDITAR_GRUPS']="<h3>No és possible editar reserves de GRUP online.</h3><br/><br/> Utilitza aquest formulari de contacte per comunicar-nos els canvis que vulguis fer i et respondrem tan aviat com ens sigui possible.<br/><br/>Gràcies.";
	
	
$translate['INFO_CONTACTE']="Si tens una reserva feta, indica'ns l'ID";
	
$translate['INFO_COMANDA']="Pots escollir diferents menús o diferents plats de la carta, però <b>no pots barrejar menús amb plats de la carta.</b><br/>";
	
	
	$translate['Grups']='Sol·licitud de reserva per Grups';
	$translate['Reserva per grups']='Reserva per a grups';
	
	$translate['Modificar']='Modificar';
	
	$translate['Sol·licitud de reserva']='Sol·licitud de reserva';
	$translate['Nens (de 4 a 9 anys)']="Nens menors de 9 anys <b>sense cotxet</b>";
	$translate['Adults']="Adults (més de 14 anys):";
  $translate['ADULTS_TECLAT']='<span class="gris-ajuda">&#8625;Pots teclejar el número si no apareix un botó amb el valor adequat</span>';
	
	$translate['Cotxets de nadó']="Nens en cotxet de nadó <br/><em style='font-size:0.8em;'>(Malauradament només disposem d'espai per un cotxet per taula)</em>. <br/><b style='font-size:0.8em'>El nen ocuparà el cotxet i no una cadira/trona</b>";

	
	$translate['INFO_QUANTS_SOU']='<b>Digue\'ns quantes persones vindreu</b>, indicant, en primer lloc els majors de 14 anys seguit de juniors i nens. 
			<br/><br/>
			<b>Reservarem espai pels comensals que ens indiquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b>
			<br/><br/>
			
			<b>(NO PODEM GARANTIR LA DISPONIBILITAT DE TRONES).</b> 
					<br/><br/>
			Només permetem l\'entrada de gossos pigall acompanyant invidents<br/><br/>
					<em>Si, en total, sou més de <b>'.($PERSONES_GRUP-1).'</b> persones, marca el botó "Grups"</em><br/><br/>
					<b>TOTAL PERSONES/COTXETS:';
					
	$translate['ALERTA_GRUPS']='<b>Has indicat més de <span style="font-size:1.2em"><?php echo $PERSONES_GRUP-1?></span> persones en total.</b><br/><br/> Cal que omplis el formulari de Grups o redueixis el nombre de comensals.<br/><br/> Si vols anar al formulari de Grups prem "Reserva per grups". Si vols reduïr el nombre de comensals prem "Modificar"';

	
	$translate['LLEI']='					En compliment de la Llei Orgànica 15/1999 del 13 de desembre, de Protecció de Dades de Caràcter Personal (LOPD), us informem que les dades personals obtingudes com a resultat d\'emplenar aquest formulari, rebran un tractament estrictament confidencial per part del Resturant Masia Can Borrell.
 
Podeu exercir els vostres drets d\'accés, rectificació, cancel·lació i oposició al tractament de les vostres dades personals, en els termes i condicions que preveu la LOPD mitjançant l\'adreça de correu: '.MAIL_RESTAURANT;


	$translate['INFO_NO_CONFIRMADA']='<b>Recorda</b>: La reserva <b>NO QUEDA CONFIRMADA</b> fins que rebis un SMS al mòbil que ens has facilitat o un email a l\'adreça que ens has indicat.';

	
	$translate['INFO_CARTA']='Si ho desitges pots triar els plats que demanareu per tenir una idea del preu, evitar que us trobeu algun plat exhaurit i accelerar el servei quan vingueu al restaurant.<br/><br/> 
						<b>Aquesta selecció no et compromet en absolut</b>.<br/><br/> Un cop al restaurant podràs modificar o anul·lar la comanda i, en qualsevol cas, us cobrarem únicament els plats i beugudes que us servim.';

	$translate['PREU']='Preu (IVA inclòs)';
	
	$translate['INFO_HORES']='<b>Recorda</b>: Només apareixen les hores per les que hem trobat taula disponible pel nombre de persones que has demanat.<br/>';
	
	$translate['INFO_DATA']='<b>Indica la data</b>.<br/><br/>
					Assegura\'t de posar la data correcta canviant el mes, si és necessari, amb les fletxetes de la part superior del calendari<br/><br/>
					Recorda que, tret d\'alguns festius, el restaurant resta tancat els dilluns i dimarts<br/><br/>
					Si un dia està desactivat pot ser que no quedin taules lliures.<br/><br/>';
	
	$translate['ALERTA_INFO_INICIAL_GRUPS']='Aquest formulari permet <b>SOL·LICITAR</b> una reserva que el restaurant haurà de CONFIRMAR o DENEGAR. <br/><br/>
			Recordeu que el fet d\'omplir i enviar aquest formulari és el primer pas d\'un procès que acaba 
			amb un <b>pagament mitjançant targeta de crèdit</b> d\'una paga i senyal que serà descomptada del preu final, de manera que <b>no representarà cap despesa extra</b>. 
			<br/><br/><b>Cap sol·licitud de reserva tindrà validesa si no s\'ha fet el pagament</b> abans de la data que us indicarem.';
	$translate['ALERTA_INFO_INICIAL']='Omplint i enviant aquest formulari 
			<b>realizaràs una reserva formal al restaurant, per un dia i hora concrets</b>. 
			<br/><br/>
			Aquest no és un formulari de contacte per fer consultes. 
			Si el que desitges és plantejar-nos algun dubte, desplega la solapa "Contactar amb el restaurant", 
			a sota del menú.<br/><br/>';

			$translate['ALERTA_INFO']='<b>La teva reserva ha estat CONFIRMADA</b>.<br/><br/>
					T\'hem enviat un SMS recordatori al número de mòbil que ens has indicat.<br/><br/>
					
					Pots cancel·lar o modificar les dades de la reserva des de l\'apartat <b>RESERVES</b>, introduïnt el teu mòbil i la contrassenya que trobaràs a l\'SMS.<br/><br/> 
					Et preguem que ens comuniquis qualsevol canvi a la reserva, especialment si es tracta d\'una cancel·lació<br/><br/>';
	$translate['ALERTA_INFO_UPDATE']='<b>La teva reserva ha estat MODIFICADA</b>.<br/><br/>
					T\'hem enviat un SMS recordatori al número de mòbil que ens has indicat.<br/><br/>
					
					Pots cancel·lar o modificar les dades de la reserva des de l\'apartat <b>RESERVES</b>, introduïnt el teu mòbil i la contrassenya que trobaràs a l\'SMS.<br/><br/> 
					Et preguem que ens comuniquis qualsevol canvi a la reserva, especialment si es tracta d\'una cancel·lació<br/><br/>';

$translate['INFO_LOGIN']="Pots cancel·lar o editar la data/hora i els comensals d'una reserva existent. Trobaràs la contrassenya (ID) a l'SMS o email que vas rebre quan vas fer la sol·licitud.";

$translate['RESERVA_CANCELADA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">A petició teva, hem <b>cancel·lat</b> la reserva. <br/>No dubtis a reservar de nou la propera ocasió.
<br/><br/>
Gràcies per utilitzar aquest servei</div>';

$translate['ESBORRA_DADES']="<em>Desitjo que les meves dades siguin eliminades de la base de dades de Can Borrell després de la data de la reserva (per reserves futures els tornaràs a introduïr)</em>";

$translate['Cadira de rodes']="Movilitat reduïda";
$translate['Movilitat reduïda']="Mobilidad reducida";
$translate['Algú amb movilitat reduïda']="Movilitat reduïda";
$translate['Necessites ajuda?']="Necessites ajuda?";
$translate['Contrassenya (ID)']="ID de reserva";


$translate['subject_contactar_restaurant_']="CONTACTAR DES DE FORMULARI RESERVES";

$translate['INFO_CONTACTE_HOME']="Utilitza aquest formulari per a qualsevol dubte o comentari. Sempre responem en un breu interval de temps"
        . "<br/><br/>"
        . "Per realitzar, anul·lar o modificar reserves (comensals, data, hora, etc.) ves a <br/><a href='/reservar/'>RESERVES</a>";
        
$translate['INFO_TEL']="Si tens alguna incidència que no puguis solucionar des dels nostres formularis, pots trucar-nos al 936929723 / 936910605 / Fax: 936924057";
$translate['Formulari de contacte']="Formulari de contacte";
       



/****************************************************************************************************/	
/*******************************************************     JS   ***********************************/	
/****************************************************************************************************/	
//
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
//
// NO ESCRIURE APOSTROF: '
// Es pot escriure tilde: ´

$translateJS['HOLA']="hole";
$translateJS['Hoe semtim.\n\nNo podem reservar per la data que ens demanes']='Ho semtim.\n\nNo podem reservar per la data que ens demanes';
$translateJS['NENS_COTXETS']='<b>La suma de nens més cotxets ha de ser el nombre real de nens que vindran</b><br/>No comptis un mateix nen com a menor de 9 i com a cotxet simultàniament. Per no duplicar places, si inclous un cotxet en el que s&#39;estarà un nen, no l&#39;anotis al grup anterior (Nens menors de 9 anys).';
//$translateJS['OBSERVACIONS_COTXETS']='Cal que especifiquis els cotxets de nadó a la secció 1 del formulari.<br/><br/> No podem garantir l&#39;espai pels cotxets que indiquis a les observacions';
$translateJS['OBSERVACIONS_COTXETS']='No tindrem en compte les indicacions que ens facis al camp observacions referents a coberts de nens/adults o cotxets de nadó'
 . '<br/><br/>'
        . 'Disposem de recursos limitats i només podem garantitzar el que ens demanes a la primera secció d&#39;aquest formulari'
        . '<br/><br/>'
        . 'Gracies la teva comprensió';

/**/
$translateJS["fr-seccio-quants"] = 'En aquesta secció has d&quot;indicar exactament quantes persones (adults, júniors i nens) vindran. <br/>A més, opcionalment, pots indicar si portareu cotxet i si us acompanya algú amb mobilitat reduïda o cadira de rodes. <br/><b>La suma de nens més cotxets ha de ser el nombre real de nens que vindran.</b>	<br/><br/><br/>		<b>Reservarem espai pels comensals que ens indiquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b><br/><br/>Aquest formulari és per a reserves de grups petits. Si sou més de '.($PERSONES_GRUP-1).' persones cal que premis a <b>Sol·licitud de reserva per Grups</b><br/><br/><br/><br/>Disposem d&quot;un nombre limitat de trones i no en podem garantir la disponibilitat.<br/><br/>Només permetem l&#39;entrada de gossos pigall acompanyant invidents<br/><br/>Un cop omplis aquestes dades, accediràs al pas 2, més avall ';
$translateJS["fr-seccio-dia"] = 'Assegura&#39;t que el nombre d&#39;adults/nens/juniors és correcte i <b>selecciona el dia al calendari</b>.<br/><br/> Alguns dies apareixen desactivats perquè el resturant està tancat o perquè els menjadors ja estan plens. En el següent pas podràs seleccionar l&#39;hora ';
$translateJS["fr-seccio-hora"] = 'Selecciona l&#39;hora entre les que apareixen a la botonera.<br/><br/> Només les hores que es presenten estn disponibles per reservar. Si no s&#39;ajusten a les teves preferències, pots canviar el dia en el pas anterior per veure si disposem de més horaris ';
$translateJS["fr-seccio-carta"] = 'En aquest pas pots fer una ullada a la nostra carta i, si vols, seleccionar els plats que voldreu prendre. Això ens servirà a nosaltres per oferir-te un servei millor sense comprometre&#39;t a res. Aquesta selecció no et causarà cap despesa extra.<br/><br/> Només et cobrarem el que realment consumeixis. <br/><br/> Podràs canviar o cancel·lar aquesta selecció més endavant, en aquest mateix formulari, o un cop al restaurant en confirmar la comanda.<br/><br/> Pots ometre aquest pas prement el botó <b>Continuar</b>';
$translateJS["fr-seccio-client"] = 'Necessitem algunes dades personals per garantir la reserva.<br/><br/> Omple-les aquí començant pel número de telèfon mòbil.<br/><br/> Recorda que pots fer comentaris o peticions al camp <b>Observacions</b>, però no et podem garantir el que hi sol·licitis. El restaurant atendrà i contestarà els teus comentaris per fer-te saber si podem o no satisfer-te';
$translateJS["fr-seccio-submit"] = 'Comprova detingudament les dades introduïdes i el resum final per evitar confusions. <br/><br/>Si tot és correcte prem a <b>Sol·licitar reserva</b> i espera a veure la resposta en pantalla per assegurar-te que el procés finalitza satisfactòriament';

$translateJS["grups-fr-seccio-quants"] = 'En aquesta secció has d&#39;indicar exactament quantes persones (adults, júniors i nens) vindran.		<br/><br/>	<b>Reservarem espai pels comensals que ens induquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b><br/><br/>Aquest formulari és per a reserves de grups grans. Si sou menys de '.($PERSONES_GRUP).' persones cal que premis a <b><='.($PERSONES_GRUP-1).'</b><br/><br/>A més, opcionalment, pots indicar si portareu cotxet i si us acompanya algú amb mobilitat reduïda o cadira de rodes. <br/><br/>Disposem d&#39;un nombre limitat de trones i no podem garantir la disponibilitat.<br/><br/>Només permetem l&#39;entrada de gossos pigall acompanyant invidents<br/><br/>Un cop omplis aquestes dades, accediràs al pas 2, més avall ';
$translateJS["grups-fr-seccio-dia"] = $translateJS["fr-seccio-dia"];
$translateJS["grups-fr-seccio-hora"] = $translateJS["fr-seccio-hora"];
$translateJS["grups-fr-seccio-carta"] = "Per reserves de grups cal que ens indiquis, <b>com a mínim, un menú per cada comensal </b><br/><br/>Si has marcat nens o juniors al pas 1 també necessitem saber quin menú prendran ells.<br/><br/>És imprescindible que marquis els menús per poder completar la reserva";
$translateJS["grups-fr-seccio-client"] =$translateJS["fr-seccio-client"];
$translateJS["grups-fr-seccio-submit"] =$translateJS["fr-seccio-submit"];



$translateJS['err0'] = 'No ha estat possible crear la reserva.';
$translateJS['err1'] = 'Test error';
$translateJS['err2'] = 'Test error';
$translateJS['err3'] = 'No hem trobat taula disponoble';
$translateJS['err4'] = 'El mòbil no és correcte';
$translateJS['err5'] = 'El camp nom no és correcte';
$translateJS['err6'] = 'El camp cognoms no és correcte';
$translateJS['err7'] = 'El nombre de comensals no és correcte';
$translateJS['err8'] = 'No hi ha taula per l&#39;hora que has demanat';
$translateJS['err9'] = 'No podem modificar la reserva';
$translateJS['err10'] = 'Per aquesta data cal que seleccionis un menú per cada comensal';
$translateJS['err99'] = 'El camp cognom no és correcte';
$translateJS['err100'] = 'Error de sessió';
$translateJS['err_contacti'] = 'Contacti amb el restaurant:936929723 / 936910605';

$translate['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d&#39;una reserva online.<br/><em>(Per editar o cancel·lar utilitza l&#39;enllaç que trobarà més amunt, sota la barra de navegació d&#39;aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa&#39;t en contacte amb nosaltres:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translateDirectJS['err21'] = '<b>No podem fer-te la reserva on-line a causa d&#39;algun problema amb una reserva anterior!!</b><br/><br/>Si us plau, per reservar contacta amb el restaurant:936929723 / 936910605 /';
$translateDirectJS['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d&#39;una reserva online.<br/><em>(Per editar o cancel·lar utilitza l&#39;enllaç que trobarà més amunt, sota la barra de navegació d&#39;aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa&#39;t en contacte amb nosaltres:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translateDirectJS['CAP_TAULA']="No tenim cap taula disponible per la data/coberts/cotxets que ens demanes.<br/><br/>Intenta-ho per una altra data";

require_once('translate.php');

?>