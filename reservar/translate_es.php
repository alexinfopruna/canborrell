<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;


$translate['EDIT_RESERVA_FORA_DE_SERVEI']='<p style="color:red">Este servicio está teporalmente fuera de sericio. Para cancelar o notificar cualquier modificación en tu reserva llama, por favor, al<p>
<b>93 692 97 23</b>
<br/>
<b>93 691 06 05</b>
<p>Gracias</p>
';



// MENU
$translate['CAN BORRELL'] = 'CAN BORRELL';

$translate['FOTOS-VIDEO'] = 'FOTOS-VIDEO';

$translate['CARTA I MENU'] = 'CARTA y MENÚ';

$translate['ON SOM: MAPA'] = 'DONDE ESTAMOS: MAPA';

$translate['EXCURSIONS'] = 'EXCURSIONES';

$translate['HISTÒRIA'] = 'HISTORIA';

$translate['HORARI'] = 'HORARIO';

$translate['RESERVES'] = 'RESERVAS';

$translate['CONTACTAR'] = 'CONTACTAR';
// FORM
$translate['Reserva per grups'] = 'Reserva para grupos';

$translate['Modificar'] = 'Modificar';

$translate['Sol·licitud de reserva'] = 'Solicitud de reserva';

$translate['[Cancel·lar/modificar una reserva existent]'] = 'Cancelar/modificar una reserva existente';

$translate['NO_COBERTS_OBSERVACIONS']='<b>Sólo se tendrán en cuenta los cubiertos/cochecitos indicados en la primera sección</b>. <span style="color:red">Los cambios en el número de cubiertos o cochecitos solicitados en las observaciones serán ignorados</span>.<br/>El restaurant no puede garantizar la disponibilidad de tronas. Una vez en el restaurant pedid-las al personal y os la facilitaremos si es posible';

$translate['INCIDENCIA_ONLINE']="¿Tienes alguna incidencia que no puedes solucionar desde este formulario. Describe brevemente tu caso y te atenderemos vía email tan pronto como podamos?";

$translate['INCIDENCIA_ONLINE_GRUPS']="Describe las modificaciones que <b>solicitas</b> para tu reserva<br/><br/>Recuerda que las modificaciones <b>NO TIENEN NINGUNA VALIDEZ</b> si no recibes la confirmación por parte del restaurant:";

$translate['INFO_NO_EDITAR_GRUPS']="<h3>No es posible editar reservas de GRUPO online.</h3> <br/><br/>Utiliza este formulario de contacto per comunicarnos los cambios que desees hacer y te responderemos tan pronto como nos sea posible.<br/><br/>Gracies.";



$translate['[Contactar amb el restaurant]']="Contactar con el restaurant";
$translate['INFO_CONTACTE']="Si tienes una reserva hecha, indicanos el ID";

$translate['INFO_COMANDA']="Puedes escoger diferentes menús o diferentes platos de la carta, pero <b>no puedes mezclar menús con platos de la carta.</b><br/>";



$translate['ERROR_LOAD_RESERVA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">No hemos encontrado la reserva o ya no es posible modificarla por ser una fecha cercana</div>';

$translate['ERROR_CONTACTAR']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum" style="color:red">Datos incorrectos. No se puede enviar el mensaje</div>';


	$translate['CONTACTAR_OK']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:green">Mensaje enviado. </div>';


	$translate['Ajuda']='Ayuda';
	$translate['Correu electrònic']='Correo electrónico';
	$translate['Pel dia:']='Para el día:';
	$translate['Cap']='Ninguno';
	$translate['Doble ample']='Doble ancho';
	$translate['Doble llarg']='Doble largo';
	$translate['inclòs']='incluido';
	$translate['Camps obligatoris']='Campos obligatorios';
	$translate['Aquest camp és necessari']='Este campo es necesario';
	$translate['La nostra carta']='Nuestra carta';
	$translate['Els nostres menús']='Nuestros menús';
	$translate['Connexió amb el sistema de reserves']='Connexión con el sistema de reservas';
	$translate['Cap taula o restaurant tancat']='No hay mesas o el restaurant está cerrado';
	$translate['Editant reserva ID']='Editando reserva ID';
	$translate['Sol·licitud de reserva per a GRUPS']='Solicitud de reserva para GRUPOS';


	
	
$translate["Hi ha errors al formulari. Revisa les dades, si us plau"]='Hay errores en el formulario. Revisa los datos, por favor';

$translate['Paga i senyal necessària']="Paga i señal necesaria";
$translate['INFO_QUANTS_SOU']='<b> Dinos cuántas personas vendrán </b>, indicando, en primer lugar los mayores de 14 años
 seguido de juniors y niños. 
<br/> 
                         <div class=info-paga-i-senyal> <b> Si sois más de '. (persones_paga_i_senyal-1).' personas,
será necesario que realices una paga y señal de '. import_paga_i_senyal.'€ con tarjeta de crédito </ b>.
Este importe se te descontará del precio final de las consumiciones, por lo que no representará ningún gasto extra.
El pago se realizará a través de una pasarela bancaria segura. Can Borrell no tendrá acceso a los datos introducidos.
              </div> 
<br/> <br/> 
		<b>Reservaremos espacio para los comensales que nos indicas aquí. La reserva no será válida para un número de persones que no coincida con el solicitado</b>
		 <br/> <br/>
		
		<b>(NO PODEMOS GARANTIZAR LA DISPONIBILIDAD DE TRONAS).</b>  <br/><br/>
		Solo aceptamos perros guía acompañando a invidentes<br/><br/>
<em> Si, en total, sois más de <b> '. ($PERSONES_GRUP-1 ).'</b> personas, marca el botón "Grupos" </em> <br/> <br/>
<b> TOTAL PERSONAS/COCHECITOS: ';

$translate['ALERTA_GRUPS']='<b> Tienes indicado más de <span style="font-size:1.2em"> <?php Php echo $ PERSONES_GRUP-1?> </Span> personas en total. </B > <br/> <br/> necesario que rellenes el formulario de Grupos o reduzcas el número de comensales. <br/> <br/> Si quieres ir al formulario de Grupos pulsa "Reserva para grupos". Si quieres reducir el número de comensales pulsa "Modificar" ';


$translate['LLEI'] = 'En cumplimiento de la Ley Orgánica 15/1999 de 13 de diciembre, de Protección de Datos de Carácter Personal (LOPD), le informamos que los datos personales obtenidos como resultado de rellenar este formulario , recibirán un tratamiento estrictamente confidencial por parte del restaurante Masia Can Borrell.
Puede ejercer sus derechos de cceso, rectificación, cancelación y oposición al tratamiento de sus datos personales, en los términos y condiciones previstos en la LOPD mediante la dirección de correo: '.MAIL_RESTAURANT ;


$translate['INFO_NO_CONFIRMADA']='<b> Recuerda </b>: La reserva <b> NO QUEDA CONFIRMADA </b> hasta que recibas un SMS en el móvil que nos has facilitado o un email en la dirección que nos has indicado.';


$translate['INFO_CARTA'] = 'Si lo deseas puedes elegir los platos que pedireis para tener una idea del precio. <br/> <br/>
<b> Esta selección no te compromete en absoluto </b>. <br/> <br/> Hasta el día anterior a la reserva puedes modificar tu elección online. Una vez en el restaurante  también podrás modificar o anular el pedido comunicándoselo al camarero y, en cualquier caso, te cobraremos únicamente los platos y bebidas que te sirvamos. ';

$translate['PREU'] = 'Precio (IVA incluido)';

$translate['INFO_HORES']='<b> Recuerda </b>: Sólo aparecen las horas para las que hemos encontrado mesa disponible para el número de personas que has pedido. <br/> ';

$translate['INFO_DATA']='<b> Indica la fecha </b>. <br/> <br/>
Asegúrate de poner la fecha correcta cambiando el mes, si es necesario, con las flechas de la parte superior del calendario <br/> <br/>
Recuerda que, salvo algunos festivos, el restaurante permanece cerrado los lunes y martes <br/> <br/>
Si un día está desactivado puede que no queden mesas libres. <br/> <br/> ';

$translate['ALERTA_INFO']='<b> La Reserva ha sido CONFIRMADA </b>. <br/> <br/>
Te hemos enviado un SMS recordatorio al número de móvil que nos has indicado. <br/> <br/>

Puedes cancelar o modificar los datos de la reserva desde el apartado <b> RESERVAS </b>, introduciendo tu móvil y la contraseña que encontrarás en el SMS. <br/> <br/>
Te rogamos que nos comuniques cualquier cambio en la reserva, especialmente si se trata de una cancelación <br/> <br/>';

$translate['ALERTA_INFO_INICIAL']='Rellenando y enviando este formulario 
		<b> realizaràs una reserva formal en el restaurante, para un día y hora concretos </b>. 
		<br/><br/>
		Este no es un formulario de contacto para realizar consultas. 
		Si lo que deseas es plantearnos alguna duda o sugerencia, 
		despliega la solapa "Contactar con el restaurante", debajo del menú. <br/> <br/>';

$translate['ALERTA_INFO_INICIAL_GRUPS']='Este formulario permite <b> SOLICITAR </b> una reserva que el restaurante tendrá que CONFIRMAR o DENEGAR. <br/> <br/>
Recuerde que el hecho de rellenar y enviar este formulario es el primer paso de un proceso que termina
con un <b> pago mediante tarjeta de crédito </b> de una paga y señal que será descontada del importe final, 
		de manera que <b>no representará un gasto extra</b>.
<br/> <br/> <b> Ninguna solicitud de reserva tendrá validez si no se ha satisfecho el pago</b> antes de la fecha que os indicaremos.';



$translate['ALERTA_INFO_UPDATE']='<b> La Reserva ha sido MODIFICADA </b>. <br/> <br/>
Te hemos enviado un SMS recordatorio al número de móvil que nos has indicado. <br/> <br/>

Puedes cancelar o modificar los datos de la reserva desde el apartado <b> RESERVAS </b>, introduciendo tu móvil y la contraseña que encontrarás en el SMS. <br/> <br/>
Te rogamos que nos comuniques cualquier cambio en la reserva, especialmente si se trata de una cancelación <br/> <br/>';

$translate['RESERVA_CANCELADA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">A petición tuya, hemos <b>cancelado</b> la reserva. <br/>No dudes en reservar de nuevo para la próxima ocasión. 
<br/><br/>
Gracias por utilizar este servicio
</div>';



$translate['INFO_LOGIN']="Puedes cancelar o modificar la fecha / hora y los comensales de una reserva existente. Encontrarás la contraseña (ID) en el SMS o email que recibiste cuando hiciste la solicitud.";

$translate['Contrassenya (ID)']="ID de reserva";
$translate['Mòbil']="Móvil";
$translate['Quants sou?']="¿Cuántos sois?";
$translate['Quin dia voleu venir?']="¿Qué día queréis venir?";
$translate['Adults (més de 14 anys)']="Adultos (más de 14 años )";
$translate['ADULTS_TECLAT']='<span class="gris-ajuda">&#8625;Puedes teclear el número si no aparece ningún botón con el valor adecuado</span>';

$translate['Juniors (de 10 a 14 anys):']="Juniors (de 10 a 14 años )";
$translate['Nens (de 4 a 9 anys)']="Niños menores de 9 años <b>sin cochecito</b>";
$translate['Cotxets de nadó']="Niños en cochecito de bebé <br/><em style='font-size:0.8em'>(desafortunaamente solo disponemos de espacio para un cochecito por mesa)</em>. <br/><b style='font-size:0.8em'>El niño ocupará el cochecito y no una silla/trona</b>";
$translate['Grups']="Solicitud de reserva para Grupos";
$translate['A quina hora?']="¿A qué hora?";
$translate['Dinar']="Comida";
$translate['Sopar']="Cena";
$translate['Vols triar els plats?']='¿Quieres elegir los platos ?';
$translate['SELECCIÓ']='SELECCIÓN
<br/><span class="resum ">Puedes elegir diferentes tipos de menú o diferentes platos de la carta, pero <b>no puedes mezclar carta y menú</b></span>
';
$translate['No hi cap plat seleccionat']="No hay ningún plato seleccionado";
$translate['La nostra carta']="Nuestra carta";
$translate['Telèfon mòbil']="Teléfono móvil";
$translate['Ens vols deixar una altre telèfon?']="¿Quieres dejar otro teléfono?";
$translate['Nom']="Nombre";
$translate['Cognoms']="Apellidos";
$translate['Observacions']="Observaciones";
$translate['Envia la sol·licitud']="Enviar solicitud";
$translate['Resum reserva']="Resumen reserva";
$translate['Data']="Fecha";
$translate['Adults']="Adultos";
$translate['Juniors']="Juniors";
$translate['Nens']="Niños";
$translate['Cotxets']="Cochecitos";
$translate['Comanda']="Pedido";
$translate['Hora']="Hora";
$translate['plats']="platos";
$translate['Continuar']="Continuar";
$translate['Carta']="Carta";
$translate['Donan´s algunes dades de contacte']="Dános algunos datos de contacto";
$translate['Sense']="Sin";
$translate['Sol·licitar reserva']="Solicitar reserva";

$translate['ESBORRA_DADES']="<em>Deseo que mis datos sean eliminados de la base de datos de Can Borrell tras la fecha de la reserva (para reservas futuras los volverás a introducir)</em>";
$translate['Cadira de rodes']="Mobilidad reducida";
$translate['Portem una cadira de rodes']="Llevaremos una silla de ruedas";
$translate['Movilitat reduïda']="Mobilidad reducida";
$translate['Algú amb movilitat reduïda']="Mobilidad reducida";

$translate['Per la data seleccionada és necessari escollir els menús']="Para esta fecha es necesario seleccionar los menú";
$translate['Per la data seleccionada és necessari escollir menú per tots els comensals']="Para la fecha seleccionada es necesario seccionar menú para todos los comensales";

$translate['Necessites ajuda?']="¿Necesitas ayuda?";


$translate['subject_contactar_restaurant']="CONTACTAR DES DE FORMULARI RESERVES";

$translate['INFO_CONTACTE_HOME']="Utiliza este formulario para cualquier duda o comentario. Siempre respondemos en un breve intervalo de tiempo"
        . "<br/><br/>"
        . "Para realizar, anular o modificar reservas (comensales, fecha, hora, etc.) ves a <br/><a href='/reservar/'>RESERVAS</a>";
        
$translate['INFO_TEL']="Si tienes alguna incidencia que no puedas solucionar desde nuestros formularios, puedes llamarnos al 936929723 / 936910605 / Fax: 936924057";
$translate['Formulari de contacte']="Formulario de contacto";
       

/****************************************************************************************************/	
/*******************************************************     JS   ***********************************/	
/****************************************************************************************************/	
//
// ATENCIOOOOOOOOOOOO
//
// NO ESCRIURE APOSTROF: '
// Es pot escriure tilde: ´

$translateJS['HOLA']="hole";
$translateJS['Ho semtim.\n\nNo podem reservar per la data que ens demanes']="Lo sentimos.No podemos reservar para la fecha que has indicado";


// $translateJS passa per html htmlentities
// $translateDirectJS es passa directe a JS sense traduïr simbols

/*******************************************************     VALIDATE   ***********************************/	
$translateJS['fr-seccio-quants'] = 'En esta sección debes indicar exactamente cuántas personas (adultos, juniors y niños) van a venir. '
        . '<br/><div class=info-paga-i-senyal> <b> Recuerda que si sois más de '. (persones_paga_i_senyal-1)
        .' personas, será necesario que realices una paga y señal de '. import_paga_i_senyal.'€ con tarjeta de crédito </b>.</div><br/> '
        . 'Además  puedes indicar si traeréis cochecito y si os acompaña alguien con mobilidad reducidad o silla de ruedas.<br/><b>La suma de niños más cochecitos ha de ser el número real de niños que van a venir</b><br/><br/>  		<b>Reservaremos espacio para los comensales que nos indicas aquí. La reserva no será válida para un número de persones que no coincida con el solicitado</b>  <br/><br/> Este formulario es para reservas de grupos pequeños. Si sois más de '.($PERSONES_GRUP-1).' personas clica sobre <b>Solicitud de reserva para grupos</b><br/><br/>	Disponemos de un número limitado de tronas y no podemos garantizar su disponibilidad <br/><br/> Solo permitimos la entrada de perros guía acompañando invidentes. <br/><br/>Una vez rellenes estos datos, accederás al paso 2, más abajo';
$translateJS['fr-seccio-dia'] = 'Selecciona el día en el calendario. <br/><br/> Algunos dias aparecen desactivados debido a que el resturant está cerrado o porque los comedores ya están llenos. <br/><br/> En el siguiente paso podrás seleccionar la hora';
$translateJS['fr-seccio-hora'] = 'Selecciona la hora entre las que aparecen en la botonera. <br/><br/> Solo las hora que se presentan está disponibles para reservar. <br/><br/> Si no se ajustan a tus preferencias, puedes cambiar el día en el paso anterior para ver si disponemos de más horarios';
$translateJS['fr-seccio-carta'] = 'En este paso puedes echar un vistazo a nuestra carta y, si lo deseas, seleccionar ya los platos que tomaréis. <br/><br/> Esto nos servirá a nosotros para ofrecerte un servicio mejor y no te compromete a nada y no causará ningún gasto extra. <br/><br/> Solo te cobraremos lo que realmente consumas.<br/><br/>  Podrás cambiar o cancelar esta selección más adelante, en este mismo formulario, o en el mismo restaurant al confirmar el pedido.<br/><br/>  Puedes omitir este paso pulsando el botón <b>Continuar<b/>';
$translateJS['fr-seccio-client'] = 'Necesitamos algunos datos personales para garantizar tu reserva. <br/><br/>Rellénalos aquí empezando por el número de teléfono móvil. <br/><br/>Recuerda que puedes hacer comentarios o peticiones en el campo <b>Observaciones</b>, pero no te podemos garantizar lo que allí solicites. El restaurant atenderá i contestará tus peticiones para hacerte saber si podemos o no satisfacerte';
$translateJS['fr-seccio-submit'] = 'Comprueba detenidamente los datos introducidos y el resumen final para evitar confusiones.<br/><br/>  Si todo es correcto pulsa en <b>Solicitar reserva</b> y espera a ver la respuesta en pantalla para asegurarte que el proceso finaliza satisfactoriamente';

$translateJS['grups-fr-seccio-quants'] = 'En esta sección debes indicar exactamente cuántas personas (adultos, juniors y niños) van a venir.  <br/><br/> <b>Reservaremos espacio para los comensales que nos indicas aquí. La reserva no será válida para un número de persones que no coincida con el solicitado</b> <br/><br/>Este formulario es para reservas de grupos grandes. Si sois menos de '.($PERSONES_GRUP).' personas clica sobre <b><='.($PERSONES_GRUP-1).'</b><br/><br/>Disponemos de un número limitado de tronas y no podemos garantizar su disponibilidad<br/><br/>Además  puedes indicar si traeréis cochecito y si os acompaña alguien con mobilidad reducidad o silla de ruedas. <br/><br/> Solo permitimos la entrada de perros guía acompañando invidentes.<br/><br/> Una vez rellenes estos datos, accederás al paso 2, más abajo';
$translateJS["grups-fr-seccio-dia"] = $translateJS["fr-seccio-dia"];
$translateJS["grups-fr-seccio-hora"] = $translateJS["fr-seccio-hora"];
//$translateJS["grups-fr-seccio-carta"] = "Para reservas de grupos es necesario que nos indiques el menú que tomaréis por cada grupo de edad. <br/> <br/> Si has marcado niños o juniors en el paso 1 también necesitamos saber qué menú tomarán ellos. <br/> <br/> <b>Es imprescindible</b> que marques los menús para poder completar la reserva";
$translateJS["grups-fr-seccio-carta"] = "Para reservas de grupos es necesario que nos indiques, <b>por lo menos, un menú para cada comensal</b> <br/> <br/> Si has marcado niños o juniors en el paso 1 también necesitamos saber qué menú tomarán ellos. <br/> <br/> <b>Es imprescindible</b> que marques los menús para poder completar la reserva";
$translateJS["grups-fr-seccio-client"] =$translateJS["fr-seccio-client"];
$translateJS["grups-fr-seccio-submit"] =$translateJS["fr-seccio-submit"];




$translateJS['Aquest camp és necessari']="Este campo es necesario";
$translateJS["El mínim de comensals és de "]="El mínimo de comensales es de ";
$translateJS["Dona´ns un mòbil"]="Dinos un móvil";
$translateJS["Dona´ns el teu nom"]="Dinos tu nombre";
$translateJS["Dona´ns els teus cognoms"]="Dinos tus apellidos";
$translateJS["Dona´ns un email"]="Dinos un email";
$translateJS["El format no és correcte"]="El formato no es correcto";
$translateJS['Selecciona el dia']="Selecciona el dia";
$translateJS['Sense']="Sin";
$translateJS['Selecciona, coma a mínim, dos adults']="Selecciona, como mínimo, dos adultos";
$translateJS['SELECCIÓ'] = 'SELECCION';

$translateJS['COTXET DOBLE AMPLE'] = 'COCHECITO DOBLE ANCHO';
$translateJS['COTXET DOBLE LLARG'] = 'COCHECITO DOBLE LARGO';
$translateJS['Per menys de'] = 'Este formulario es para reservas a partir de '.$PERSONES_GRUP.' personas';
$translateJS['No hi ha cap plat seleccionat'] = 'No hay ningún plato seleccionado';

$translateJS['Menús']='Menús';
$translateJS['Menús Nadal']='Menús Navidad';
$translateJS['NENS_COTXETS']='<b>La suma de niños más cochecitos ha de ser el número real de niños que van a venir</b><br/>No cuentes un mismo niño como menor de 9 y cochecito a la vez. Para no duplicar plazas, si incluyes un cochecito en el que permanecerá un niño, no lo anotes en el grupo anterior (Niños menores de 9 años).';
//$translateJS['OBSERVACIONS_COTXETS']='<br/><br/> No podemos garantizar el espacio para cochecitos si lo indicas como observaciones';
$translateJS['OBSERVACIONS_COTXETS']='No tendremos en cuenta las indicaciones que nos hagas en el campo observaciones referentes a cubiertos de niños/adultos o cochecitos de bebé. '
        . '<br/><br/>'
        . 'Disponemos de recursos limitados y <b>solo podemos garantizarte lo que solicites en la primera sección</b> de este formulario'
        . '<br/><br/>Gracias por tu comprensión';

$translateJS["PAGA_I_SENYAL"] ="<div>A continuación has de realizar el pago de ".import_paga_i_senyal."€ para garantizar la asistència el día de la reserva. "
        . "Este importe será descontado de la cuenta total.<br/><br/>"
        . "Te transferimos a una passarela bancaria externa a Can Borrell. El restaurant no tendrá acceso a los datos que introduzcas"
        . "<br/><br/></div>";



/*******************************************************     ERRORS   ***********************************/	
$translateJS['err33'] = 'Test error33';
$translateJS['err0'] = 'No ha estat possible crear la reserva.';
$translateJS['err1'] = 'Test error1';
$translateJS['err2'] = 'Test error2';
$translateJS['err3'] = 'No hem trobat taula disponoble';
$translateJS['err4'] = 'El mòbil no és correcte';
$translateJS['err5'] = 'El camp nom no és correcte';
$translateJS['err6'] = 'El camp cognoms no és correcte';
$translateJS['err7'] = 'El nombre de comensals no és correcte';
$translateJS['err8'] = 'No hi ha taula per l´hora que has demanat';
$translateJS['err10'] = 'Para esta fecha debes seleccionar un menú para cada comensal';
$translateJS['err99'] = 'Test error';
$translateJS['err100'] = 'Error de sessió';
$translateJS['err_contacti'] = 'Contacti amb el restaurant: 936929723 / 936910605';

$translate['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d´una reserva online.<br/><em>(Per editar o cancel·lar utilitza l´enllaç que trobarà més amunt, sota la barra de navegació d´aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa´t en contacte amb nosaltres:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translateDirectJS['err21'] = '<b>No podemos hacer la reserva on-line a causa de algún problema con una reserva anterior</b><br/><br/>Por favor, para reservar contacta con el restaurant:936929723 / 936910605';
$translateDirectJS['err20'] = '<b>Ya tienes una reserva hecha en Can Borrell!</b><br/><br/>Puedes modificarla o eliminarla pero no puedes crear más de una reserva online<br/><em>(Para editar o cancelar, utiliza el enlace que hay arriba, bajo la barra de navegación de esta página )</em><br/><br/><br/><br/><br/>Si lo deseas ponte en contacto con nosotros:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que nos consta es para el dia ';
$translate['err21'] = '<b>No podem fer-te la reserva on-line a causa d´una reserva anterior!!</b><br/><br/>Si us plau, per reservar contacta amb el restaurant:936929723 / 936910605';
$translateDirectJS['CAP_TAULA']="No tenemos ninguna mesa disponible para la fecha/cubiertos/cochecitos que nos pides.<br/><br/>Inténtalo para otra fecha";

require_once('translate.php');

?>