<?php
//MENU
if (!defined('TRANSLATE_DEBUG')) define('TRANSLATE_DEBUG', FALSE);


	$translate['CAN BORRELL']='CAN BORRELL';

	$translate['FOTOS-VIDEO']='FOTOS-VÍDEO';

	$translate['CARTA I MENU']='CARTA I MENÚ';

	$translate['ON SOM: MAPA']='ON SÓM';

	$translate['EXCURSIONS']='EXCURSIONS';

	$translate['HISTORIA']='HISTÒRIA';

	$translate['HORARI']='HORARI';

	$translate['PREMSA']='PREMSA';

	$translate['RESERVES']='RESERVES';

	$translate['CONTACTAR']='CONTACTAR';

/****************************************************************************************************/	
/*************************************************     FUNCIONS   ***********************************/	
/****************************************************************************************************/	
function l($text,$echo=true)
{
	global $translate;//	return $translate[$text];
	global $notrans;
        
	if (TRANSLATE_DEBUG)
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