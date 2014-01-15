<?php
define("ROOT", "../taules/");
include(ROOT."Gestor.php");

/****************************************************************************************/
/****************************************************************************************/
// GESTIONA OPERACIONS DE CERCA SOBRE RESERVES I CLIENTS
/****************************************************************************************/
/****************************************************************************************/
class GestorCercador extends Gestor
{
	public function GestorCercador()
	{
		parent::__construct(DB_CONNECTION_FILE,$usuari_minim);
	}
}