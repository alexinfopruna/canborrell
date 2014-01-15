<?php
//MENU
// MENU
$translate['CAN BORRELL'] = 'CAN BORRELL';

$translate['FOTOS-VIDEO'] = 'FOTOS-VIDEO';

$translate['CARTA I MENU'] = 'CARTA-MENÚ';

$translate['ON SOM: MAPA'] = 'DONDE ESTAMOS';

$translate['EXCURSIONS'] = 'EXCURSIONES';

$translate['HISTÒRIA'] = 'HISTORIA';

$translate['PREMSA'] = 'PRENSA';

$translate['HORARI'] = 'HORARIO';

$translate['RESERVES'] = 'RESERVAS';

$translate['CONTACTAR'] = 'CONTACTAR';

/****************************************************************************************************/	
/*************************************************     FUNCIONS   ***********************************/	
/****************************************************************************************************/	
function l($text,$echo=true)
{
	global $translate;//	return $translate[$text];
	global $notrans;
	if (false && TRANSLATE_DEBUG)
	{
		/*
		// DEBUG
		*/
		if (isset($translate[$text])) 
			if ($translate[$text]=="=")	$trans='<span class=\'igual\'>'.$text.'</span>';
			else $trans='<span class=\'translated\'>'.$translate[$text].'</span>';
		else $trans=TRANSLATE_NO_TRANS.'<span class=\'no-trans\'>'.$text.'</span>';
	}
	else
	{
		if (isset($translate[$text])) 
			if ($translate[$text]=="=")	$trans=$text;
			else $trans=$translate[$text];
		else $trans=$text;
	}
	//echo "---$text - ".(isset($translate[$text])?"ok":"ko")." > ";
	if ($echo) echo $trans;
	
	return ($trans);
}
?>