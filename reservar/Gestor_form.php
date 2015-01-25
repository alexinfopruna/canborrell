<?php
header('Content-Type: text/html; charset=utf-8');
defined('ROOT') or define('ROOT', '../taules/');

if(isset($_REQUEST['a'])) $accio=$_REQUEST['a'];$_REQUEST['a']=null;
require_once(ROOT."Gestor.php");


if (!defined('LLISTA_DIES_NEGRA')) define("LLISTA_DIES_NEGRA",INC_FILE_PATH."bloq.txt");
if (!defined('LLISTA_DIES_NEGRA_RES_PETITES')) define("LLISTA_DIES_NEGRA_RES_PETITES",INC_FILE_PATH."llista_dies_negra_online.txt");
if (!defined('LLISTA_NITS_NEGRA')) define("LLISTA_NITS_NEGRA",INC_FILE_PATH."bloq_nit.txt");
if (!defined('LLISTA_DIES_BLANCA')) define("LLISTA_DIES_BLANCA",INC_FILE_PATH."llista_dies_blanca.txt");


require_once(ROOT."gestor_reserves.php");
require_once(ROOT."Menjador.php");
require_once(ROOT."EstatTaula.php");

require_once(ROOT."TaulesDisponibles.php");
/**********************************************************************************************************/	
class Gestor_form extends gestor_reserves
{
	var $data_BASE="2011-01-01";
	var $menjadorsBloquejatsOnline;


	/**********************************************************************************************************/	
	public function __construct($usuari_minim=1) 	
	{
		parent::__construct(DB_CONNECTION_FILE,$usuari_minim);
		// Sobre quina taule fem les consultes
		$this->taulesDisponibles->tableMenjadors="estat_menjador_form";
	}
	
/**********************************************************************************************************/	
/**********************************************************************************************************/
// FUNCIONS	LOGIN UPDATE RESERVA
/**********************************************************************************************************/	
/**********************************************************************************************************/	
	
	/**********************************************************************************************************/	
	public function recuperaReserva($mob,$id_reserva)
	{
		if (strtolower(substr($id_reserva,0,2)=="id")) $id_reserva=substr($id_reserva,2,15);

		$query = "SELECT * FROM ".T_RESERVES." 
		LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
		LEFT JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva=".ESTAT_TAULES.".reserva_id
		WHERE data>= NOW() + INTERVAL 24 HOUR
		AND ".T_RESERVES.".id_reserva='".$id_reserva."' AND client_mobil='".$mob."'";

		$this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());

                if ($this->total_rows = mysql_num_rows($this->qry_result))	
		{
			$this->last_row = mysql_fetch_assoc($this->qry_result);
			$usr=new Usuari($this->last_row['client_id'],$this->last_row['client_nom'],1);
			$_SESSION['uSer']=$usr;

                       
                        
			return $this->last_row;
		}
		
		$this->error="Reserva no trobada";
		return false;	
	}
	/**********************************************************************************************************/
	/**
	 * 
	 * @param unknown_type $mob
	 * @param unknown_type $id_reserva
	 * @return multitype:|boolean
	 */	
	public function recuperaReservaGrup($mob,$id_reserva)
	{
		if (strtolower(substr($id_reserva,0,2)=="id")) $id_reserva=substr($id_reserva,2,15);

		$query = "SELECT * FROM reserves 
		LEFT JOIN client ON reserves.client_id=client.client_id
		WHERE data>= NOW() + INTERVAL 24 HOUR
		AND reserves.id_reserva='".$id_reserva."' AND client_mobil='".$mob."'";

		$this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
		if ($this->total_rows = mysql_num_rows($this->qry_result))	return $this->last_row = mysql_fetch_assoc($this->qry_result);
		
		$this->error="Reserva no trobada";
		return false;	
	}
/**********************************************************************************************************/	
/**********************************************************************************************************/
// FUNCIONS	HORES
/**********************************************************************************************************/	
/**********************************************************************************************************/	
/**********************************************************************************************************/	
	// Llistat hores form GRUPS. 
	public function totesHores($data)
	{
		$mydata=$this->cambiaf_a_mysql($data);
		$ds=date("w",strtotime($mydata));
		$coberts=0;
		$cotxets=0;
		
		$this->taulesDisponibles->data=$mydata;
		$this->taulesDisponibles->persones=$coberts;
		$this->taulesDisponibles->cotxets=$cotxets;	
		$this->taulesDisponibles->tableHores="estat_hores";
		
		$this->taulesDisponibles->llista_dies_negra=LLISTA_DIES_NEGRA;
		$this->taulesDisponibles->llista_nits_negra=LLISTA_NITS_NEGRA;
		$this->taulesDisponibles->llista_dies_blanca=LLISTA_DIES_BLANCA;
		//TORN1
		$taulaT1='';
		$this->taulesDisponibles->torn=1;
		$dinar=$this->taulesDisponibles->recupera_hores_grups();
		if (!$dinar) $dinar="";

		//TORN2
		$taulaT2='';
		$this->taulesDisponibles->torn=2;
		$dinarT2=$this->taulesDisponibles->recupera_hores_grups();
		if (!$dinarT2) $dinarT2="";

		//TORN3
		$taulaT3='';
		$sopar='';
		$this->taulesDisponibles->torn=3;
		if ($ds>4) $sopar=$this->taulesDisponibles->recupera_hores_grups();
		if (!$sopar) $sopar="";

		$json=array('dinar'=>$dinar,'dinarT2'=>$dinarT2,'sopar'=>$sopar,'taulaT1'=>$taulaT1,'taulaT2'=>$taulaT2,'taulaT3'=>$taulaT3);
		return json_encode($json);	
	}
	
	/**********************************************************************************************************/	
	public function horesDisponibles($data,$coberts,$cotxets=0,$accesible=0,$idr=0)
	{		

		$mydata=$this->cambiaf_a_mysql($data);
	
		//$this->taulesDisponibles->tableHores="estat_hores_form";
    $this->taulesDisponibles->tableHores="estat_hores";   //ANULAT GESTOR HORES FORM. Toto es gestiona igual, des de estat hores
		if ($idr) 
		{
			if (!$this->taulesDisponibles->loadReserva($idr)) 
			{
				$json=array('dinar'=>'','dinarT2'=>'','sopar'=>'','taulaT1'=>0,'taulaT2'=>0,'taulaT3'=>0,'error'=>3);		
				return json_encode($json);	
			}
		}
		
		$this->taulesDisponibles->data=$mydata;
		$this->taulesDisponibles->persones=$coberts;
		$this->taulesDisponibles->cotxets=$cotxets;		
		$this->taulesDisponibles->accesible=$accesible;		
		//$this->taulesDisponibles->tableHores="estat_hores_form";		
		$this->taulesDisponibles->tableHores="estat_hores";		//ANULAT GESTOR HORES FORM. Toto es gestiona igual, des de estat hores
		
		$this->taulesDisponibles->llista_dies_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_nits_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_dies_blanca=LLISTA_DIES_BLANCA;

/*	*/	
		//TORN1
		$this->taulesDisponibles->torn=1;
		$dinar=$this->taulesDisponibles->recupera_hores();
		$taules=$this->taulesDisponibles->taulesDisponibles();
		$taulaT1=$taules[0]->id;
		if (!$dinar) $dinar="";
		//TORN2
		$this->taulesDisponibles->torn=2;
		$dinarT2=$this->taulesDisponibles->recupera_hores();
		$taules=$this->taulesDisponibles->taulesDisponibles();
		//$this->printr($taules);
		$taulaT2=$taules[0]->id;
		if (!$dinarT2) $dinarT2="";
			
		//TORN3
		$this->taulesDisponibles->torn=3;
		$sopar=$this->taulesDisponibles->recupera_hores();
		$taules=$this->taulesDisponibles->taulesDisponibles();
		if ($taules[0]) $taulaT3=$taules[0]->id;
		else $taulaT3=null;
		if (!$sopar) $sopar="";
		
		$json=array('dinar'=>$dinar,'dinarT2'=>$dinarT2,'sopar'=>$sopar,'taulaT1'=>$taulaT1,'taulaT2'=>$taulaT2,'taulaT3'=>$taulaT3);		
		return json_encode($json);	
		//////////////////////////////////					
	}
	
/**********************************************************************************************************/	
/**********************************************************************************************************/
// FUNCIONS	CARTA
/**********************************************************************************************************/	
/**********************************************************************************************************/	
	public function recuperaCarta($idr,$es_menu=false)
	{
		$lng= $this->lng;
		if ($idr<1) $idr=-1;
		//CONTROL DIES NOMES CARTA
		
		
    if ($es_menu) $were=' carta_plats.carta_plats_subfamilia_id=20 ';
    else $were=' (carta_plats.carta_plats_subfamilia_id<>20) ';
    
				$were.=' AND carta_publicat = TRUE ';
		
		$CONTROLA_ARTICLES_ACTIUS="";		

		$query="select `carta_plats_id`,`carta_plats_nom_es`,`carta_plats_nom_ca`,`carta_plats_preu`,carta_subfamilia.carta_subfamilia_id AS subfamilia_id,`carta_subfamilia_nom_$lng`, comanda_client.comanda_plat_quantitat 
FROM carta_plats 
LEFT JOIN carta_publicat ON carta_plats_id=carta_publicat_plat_id
LEFT JOIN carta_subfamilia ON carta_subfamilia.carta_subfamilia_id=carta_plats_subfamilia_id
LEFT JOIN comanda as comanda_client ON carta_plats_id=comanda_plat_id AND comanda_reserva_id='$idr'
LEFT JOIN carta_subfamilia_order ON carta_subfamilia.carta_subfamilia_id=carta_subfamilia_order.carta_subfamilia_id

$CONTROLA_ARTICLES_ACTIUS

WHERE $were
ORDER BY carta_subfamilia_order,carta_plats_nom_es , carta_plats_nom_ca";
//ORDER BY (carta_subfamilia_id=2),carta_subfamilia_id";
//echo $query;
	$Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
	
		while ($row = mysql_fetch_array($Result1))
		{
			if (empty($row['carta_plats_nom_ca'])) $row['carta_plats_nom_ca']=$row['carta_plats_nom_es'];
			$plat=array('id'=>$row['carta_plats_id'],'nom'=>$row['carta_plats_nom_'.$lng],'preu'=>$row['carta_plats_preu'],'quantitat'=>$row['comanda_plat_quantitat']);
			$arCarta[$row['carta_subfamilia_nom_'.$lng]][]=$plat;
		}
	
/**********************************************************************************************************/	
	
		$class=$es_menu?"cmenu":"ccarta";
		$obreLlista='<ul id="carta-seccions" class="'.$class.'">'.PHP_EOL;
		$llista="";
		foreach ($arCarta as $key => $val)
		{
			$k=$this->normalitzar($key);
			$llista.='<li><a href="#carta_'.$k.'">'.$key.'</a></li>'.PHP_EOL;
		}
		$tancaLlista='</ul>'.PHP_EOL;
		$carta=$obreLlista.$llista.$tancaLlista;
		
		foreach ($arCarta as $key => $val)
		{
			$k=$this->normalitzar($key);
			$obreSeccio='<div id="carta_'.$k.'" class="'.$class.'">'.PHP_EOL;
			$seccio=$this->seccioCarta($arCarta,$key, $class);
			$tancaSeccio='</div>'.PHP_EOL.PHP_EOL;
			
			$carta.=$obreSeccio.PHP_EOL.$seccio.PHP_EOL.$tancaSeccio;
		}
		
		//print_r($arCarta);
		return $carta;

	}
	
/**********************************************************************************************************/	
	public function  seccioCarta($ar,$k, $class)
	{
		$obreTaula='<table id="c1" class="col_dere">'.PHP_EOL;
		$l=$c=0;
		$tr='';
		foreach ($ar[$k] as $key => $val)
		{
			$menuEspecial=$this->menuEspecial($val['id'])?" menu-especial":"";
			if (!calsoton && ($val['id']==2010 || $val['nom']=="MENU CALÇOTADA" || $val['nom']=="MENÚ CALÇOTADA")) continue;
			$l++;
			
			if ($val['quantitat']) $value=' value="'.$val['quantitat'].'" ';
			else $value="0";
			
			/**  IVA  **/
			//$val['preu']*=IVA/100;
			$preu=round($val['preu']+$val['preu']*IVA/100,2);
			$preu=number_format($preu,2,'.','');
			
			$odd=($l%2)?"odd":"pair";
			$tr.='<tr producte_id="'.$val['id'].'" class="item-carta '.$odd.$menuEspecial.'">
				<td  class="mes"><div  class="d-mes ui-corner-all" ><a href"#">+</a></div></td>
				<td class="contador">
                                <div  class="mes"><div  class="m-mes ui-corner-all"> + </div></div>
                                <input id="carta_contador'.$val['id'].'" nid="'.$val['id'].'" type="text" name="carta_contador'.$c++.'" class="contador '.$class.'" '.$value.' preu="'.$preu.'" nom="'.$val['nom'].'"/>
                                 <div  class="menys"><div  class="m-menys ui-corner-all"> - </div></div>   

</td>
				<td class="menys"><div  class="d-menys ui-corner-all" ><a href"#">-</a></div></td>
				<td class="borra" style="display:none"></td>
				<td><a class="resum-carta-nom" href="Gestor_form.php?a=TTmenu&b='.$val['id'].'" >'.$val['nom'].'</a></td>
				<td class="td-carta-preu"><span class="carta-preu">'.$preu.'</span>&euro; </td>
				<!--<td class="carta-subtotal"><em>(subtotal: <span class="carta-preu-subtotal">0</span>&euro; )</em></td></tr>-->
                                           

'.PHP_EOL;
             
		}
		
		$tancaTaula='
		<tr><td></td><td></td><td></td><td></td><td>IVA incl.</td><td></td></tr>
		</table>'.PHP_EOL.PHP_EOL;
		
		return $obreTaula.$tr.$tancaTaula;
	}
	
	private function menuEspecial($id)
	{
		return ($id==2001 || $id==2003);
	}	
	
/**********************************************************************************************************/	
/**********************************************************************************************************/
// FUNCIONS	CLIENT
/**********************************************************************************************************/	
/**********************************************************************************************************/	
public function recuperaClient($num,$mail=null)
{
	//$num="999";
	
	if (empty($mail)) $mail="nuul@nuul".time();
	$mail=strtolower($mail);
	
	$query="
SELECT client.`client_id`,`client_nom`,`client_conflictes`,`client_email`,`client_mobil`,`client_telefon`,`client_dni`,`client_cp`,`client_localitat`,`client_adresa`,`client_cognoms`,reserves.id_reserva AS id_reserva_grup,".T_RESERVES.".id_reserva AS id_reserva, reserves.data as data_grup, ".T_RESERVES.".data AS data,
(reserves.id_reserva OR reservestaules.id_reserva) as reservat

FROM client 
		LEFT JOIN reserves ON client.client_id=reserves.client_id AND reserves.data>=NOW()AND (reserves.estat=1 OR reserves.estat=2 OR reserves.estat=3 OR reserves.estat=7 OR reserves.estat=100)
		LEFT JOIN ".T_RESERVES." ON client.client_id=".T_RESERVES.".client_id AND ".T_RESERVES.".data>=NOW()

	WHERE client_mobil='$num' 
	OR LOWER(client_email)='$mail'
	
	ORDER BY id_reserva_grup DESC , id_reserva DESC , client.client_id DESC";

	//echo $query;
	$Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
	
	if (mysql_num_rows($Result1)==0) return 'false';
	
	
	$row = mysql_fetch_array($Result1);	
	if ($row['reservat']) 
	{
		if ($row['id_reserva_grup']) $row['data']=$row['data_grup'];
		$row['data']=$this->cambiaf_a_normal($row['data']);
		$row['err']="20";
	}
	
	//GARJOLA
	if ($this->garjola($num,$mail)){
		if ($row['id_reserva_grup']) $row['data']=$row['data_grup'];
		$row['data']=$this->cambiaf_a_normal($row['data']);
		//$row['err']="21"." $num $mail";
		$row['err']="21";
	}
/* TRAMPA PER FER PROVES!!!!	*/
	if ($num=="999212121")
	{
		$row['reservat']=$row['id_reserva_grup']=$row['id_reserva']=0;
		$row['err']=null;
	}
	return json_encode($row);	
}



/**********************************************************************************************************/	
/**********************************************************************************************************/
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
/**********************************************************************************************************/	
/**********************************************************************************************************/	
public function submit()
{
	$resposta['mail']=null;
	
	// MIREM SI ESTÀ EDITANT UNA RESERVA EXISTENT
	if (isset($_POST['id_reserva']) && !empty($_POST['id_reserva']))
	{
		if (strtolower(substr($_POST['id_reserva'],0,2))=='id') $_POST['id_reserva']=substr($_POST['id_reserva'],2,20);
		if ($_POST['id_reserva']>3000) return $this->salvaUpdate(); // GUARDA UPDATE
		else 
		{
			$resposta['request']="update";
			return $this->jsonErr(1,$resposta); //RESERVA DESCONEGUDA
		}
	}
	
	//echo $_SESSION['last_submit'];
	//die();
	
	$resposta['request']="create";
	if (isset($_SESSION['last_submit'])) $_REQUEST['last_submit']=$_SESSION['last_submit'];
	else $_SESSION['last_submit']=0;
	if (time()-$_SESSION['last_submit']<5) return $this->jsonErr(10,$resposta);//PARTXE DOBLE SUBMIT
	
	//MIRA SI ENS VOLEM FER UNA DUPLICADA
	if (!isset($_POST['client_mail'])) $_POST['client_mail']=null;
	$result=json_decode($this->recuperaClient($_POST['client_mobil'],$_POST['client_mail']));
	if ($result->{'err'}) {
		$this->reg_log("ERROR SUBMIT->CLIENT REPETIT".$result->{'err'});
		return $this->jsonErr($result->{'err'},$resposta);
	}

	$_POST['lang']=$_SESSION["lang"];
	$_POST['observacions']=$_POST['observacions'];//????
	$_POST['reserva_info']=1;
	//TODO COTXETS
	//comensals
            
	if (!$_POST['selectorComensals']) $_POST['selectorComensals']=$_POST['adults'];
	$total_coberts=$_POST['selectorComensals']+$_POST['selectorNens']+$_POST['selectorJuniors'];
        
        
        $PERSONES_GRUP=$this->configVars("persones_grup");
	if ($total_coberts<2 || $total_coberts>$PERSONES_GRUP) return $this->jsonErr(7,$resposta);// "err7 adults";
	
	//ESBRINA EL TORN	
	$data=$this->cambiaf_a_mysql($_POST['selectorData']);
	
	if (empty($_POST['hora']))  return $this->jsonErr(8,$resposta);// 
	$hora=$_POST['hora'];
	$torn=$this->torn($data,$hora);	
	
	if ($data<date("Y-m-d")) $resposta['error']= "err1 Data passada: ".$_POST['selectorData']." < ".date("d/m/Y");
	$date = strtotime(date("Y-m-d", strtotime("now")) . " +1 year");
	if ($data>$date) $resposta['error']= "err2: data futura: ".$_POST['selectorData'];
	

	//COMPROVA hora - torn - taula ok?
	$coberts=$_POST['adults']+$_POST['nens10_14']+$_POST['nens4_9'];
	$cotxets=$_POST['selectorCotxets'];

	if (!isset($_POST['selectorAccesible'])) $_POST['selectorAccesible']=false;
	if (!isset($_POST['selectorCadiraRodes'])) $_POST['selectorCadiraRodes']=false;
	$accesible=($_POST['selectorAccesible'] || $_POST['selectorCadiraRodes']);

		$this->taulesDisponibles->data=$data;
		$this->taulesDisponibles->torn=$torn;
		$this->taulesDisponibles->hora=$hora;
		$this->taulesDisponibles->persones=$coberts;
		$this->taulesDisponibles->cotxets=$cotxets;		
		$this->taulesDisponibles->accesible=$accesible;		

		$this->taulesDisponibles->llista_dies_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_nits_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_dies_blanca=LLISTA_DIES_BLANCA;

		
		//$this->taulesDisponibles->tableHores="estat_hores_form";
		$this->taulesDisponibles->tableHores="estat_hores";
		$this->taulesDisponibles->recupera_hores();
				
		// VALIDA SI HEM TROBAT TAULA
		if (!$taules=$this->taulesDisponibles->taulesDisponibles())  return $this->jsonErr(3,$resposta);
		$taula=$taules[0]->id;
                //print_r($taules);
		
		// VALIDA SI HEM TROBAT HORA
		if (!$this->taulesDisponibles->horaDisponible($hora)) return $this->jsonErr(8,$resposta);

		//SI CREA_TAULA LA GUARDA
		$taulaVirtual=false;
		if ($taules[0]->taulaVirtual) 
		{
			$taulaVirtual=true;
			$taules[0]->guardaTaula();
		}
		if ($taula<1) return $this->jsonErr(3,$resposta); 
		//dades client?
		if (empty($_POST['client_mobil'])) return $this->jsonErr(4,$resposta);// "err4 mobil";
		if (empty($_POST['client_nom'])) return $this->jsonErr(5,$resposta);// "err5 nom";
		if (empty($_POST['client_cognoms'])) return $this->jsonErr(6,$resposta);// "err6: cognoms";
		
		//comanda?		
		//FINS AQUI TOT HA ANAT BE, ANEM A GUARDAR LA RESERVA...
		////////////// TODO
		//INSERT INTO CLIENT
		$idc=$this->insertUpdateClient($_POST['client_mobil']);
		$info = $this->encodeInfo($_POST['amplaCotxets'], 0, 1);
		
		
/*	*/
	
		$esborra= (isset($_POST['esborra_dades']) && $_POST['esborra_dades']=='on');
		$info=$this->flagBit($info,7,$esborra);
		$selectorCadiraRodes= (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes']=='on');
		$info=$this->flagBit($info,8,$selectorCadiraRodes);
		$selectorAccesible= (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible']=='on');
		$info=$this->flagBit($info,9,$selectorAccesible);
		
		$_POST['observacions']=preg_replace("/Portem cadira de rodes /","",$_POST['observacions']);
		if ($selectorCadiraRodes){
			$_POST['observacions']='Portem cadira de rodes '.$_POST['observacions'];
		}
	//INSERT INTO RESERVES TAULES
		if (!isset($_POST['resposta'])) $_POST['resposta'] = '';
                if (!isset($_POST['RESERVA_PASTIS'])) $_POST['INFO_PASTIS']=NULL;
                
		$estat=$this->paga_i_senyal($coberts)?2:100;
		//$import_reserva=$this->configVars("import_paga_i_senyal");
		$import_reserva=0;
                
		$insertSQL = sprintf("INSERT INTO ".T_RESERVES." ( id_reserva, client_id, data, hora, adults, 
		  nens4_9, nens10_14, cotxets,lang,observacions, reserva_pastis, reserva_info_pastis,
                  resposta, estat, preu_reserva, usuari_creacio, 
                  reserva_navegador, reserva_info) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   $this->SQLVal($_POST['id_reserva'], "text"),
							  $this->SQLVal($idc, "text"),
							   $this->SQLVal($_POST['selectorData'], "datePHP"),
							   $this->SQLVal($_POST['hora'], "text"),
							   $this->SQLVal($_POST['selectorComensals'], "zero"),
							   $this->SQLVal($_POST['selectorNens'], "zero"),
							   $this->SQLVal($_POST['selectorJuniors'], "zero"),
							   $this->SQLVal($_POST['selectorCotxets'], "zero"),
 							   $this->SQLVal($_POST['lang'], "text"),							   
                                                            $this->SQLVal($_POST['observacions'], "text"),
							  
                                                           $this->SQLVal($_POST['RESERVA_PASTIS']=='on', "zero"),
                                                           $this->SQLVal($_POST['INFO_PASTIS'], "text"),
                        
                        
							   $this->SQLVal($_POST['resposta'], "text"),
							   $this->SQLVal($estat, "text"),
							   $this->SQLVal($import_reserva, "text"),
   							 $this->SQLVal($idc, "text"),							   
							   $this->SQLVal($_SERVER['HTTP_USER_AGENT'], "text"),
							   $this->SQLVal($info, "zero"));

							  // Gestor::printr($_POST);
 							  //echo $insertSQL;die();
            
		  $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
		  $idr=mysql_insert_id($this->connexioDB);
	
	//INSERT INTO ESTAT TAULES 
		//recupera estat
		  $estatSQL = "SELECT * FROM ".ESTAT_TAULES." 
			
			WHERE (estat_taula_data<'$data 23:59:59' 
			AND estat_taula_data>='$data' 
			AND estat_taula_torn=$torn		  
			AND estat_taula_taula_id = ".$taula.")
			OR (estat_taula_data='".$this->data_BASE."' 
			AND estat_taula_taula_id = ".$taula.")
		  
		  ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";

//echo $estatSQL;
		  $this->qry_result = mysql_query($estatSQL, $this->connexioDB) or die(mysql_error());
		  $row = mysql_fetch_assoc($this->qry_result);
		
		if (!$row['estat_taula_nom']) $row['estat_taula_nom']=$_POST['estat_taula_taula_id'];
		  
		 //INSERT ESTAT 
		$insertSQL = sprintf("INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
		reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

							   $this->SQLVal($data, "text"),
							   $this->SQLVal($row['estat_taula_nom'], "text"),
							   $this->SQLVal($torn, "text"),
							  $this->SQLVal($taula, "text"),
							   $this->SQLVal($idr, "text"),
							   $this->SQLVal($row['estat_taula_x'], "text"),
							   $this->SQLVal($row['estat_taula_y'], "text"),
							   $this->SQLVal($row['estat_taula_persones'], "zero"),
							   $this->SQLVal($row['estat_taula_cotxets'], "zero"),
							   $this->SQLVal($row['estat_taula_grup'], "text"),
							   $this->SQLVal($row['estat_taula_plena'], "text"),
							   $this->SQLVal(5, "text"));
		  
		  $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
		  $id = mysql_insert_id();

		//DELETE REDUNDANTS
			$deleteSQL=sprintf("DELETE FROM ".ESTAT_TAULES."
			WHERE estat_taula_taula_id = %s 
			AND estat_taula_data=%s 
			AND estat_taula_torn=%s 
			AND estat_taula_id<>%s",
			 $this->SQLVal($taula, "text"),
			 $this->SQLVal($data, "text"),
			 $this->SQLVal($torn, "text"),
			 $this->SQLVal($id, "text"));
			
		  $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());

	//INSERT INTO COMANDES
	if (!isset($idr)) $idr=0;
	for ($i=1;isset($_POST['plat_id_'.$i]);$i++)
	{
		$insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)",
		   $this->SQLVal($idr, "text"),
		   $this->SQLVal($_POST['plat_id_'.$i], "text"),
		   $this->SQLVal($_POST['plat_quantitat_'.$i], "text"));
		   
		 $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
	}
	
	//desbloquejem taula desp	rés de crear reserva, que si no no la vol
	$this->bloqueig_taula($taula,$data,$torn,true);
	
	
	
	//envia SMS
	$persones=$_POST['selectorComensals']+$_POST['selectorJuniors']+$_POST['selectorNens'];
	$persones.='p';
	$mensa = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$idr)";
	//$mensa = $this->l("RESERVA_CREADA");
	
	//envia MAIL
        
        $TPV=$this->paga_i_senyal($coberts);
      $extres['subject']="Can-Borrell: CONFIRMACIÓ DE RESERVA ONLINE";
	if ($_POST['client_email'] && !$TPV) $mail=$this->enviaMail($idr,"confirmada_",FALSE,$extres);
	$resposta['mail']=$mail;
	$resposta['virtual']=$taulaVirtual;
        $resposta['TPV']=$TPV?"TPV":"";
        $resposta['idr']=$idr;
        if ($TPV){
            $resposta['signature']=$this->signatureTpv('214'.$idr,import_paga_i_senyal,'http://'.$_SERVER['HTTP_HOST'].'/reservar/Gestor_form.php?a=respostaTPV');
            //$resposta['signature']=$this->signatureTpv('214'.$idr,import_paga_i_senyal,'http://'.$_SERVER['HTTP_HOST'].'/reservar/respostaTPV.php');
            //$resposta['signature']=$this->signatureTpv('214'.$idr,import_paga_i_senyal,'http://www.can-borrell.com/reservar/Gestor_form.php?a=respostaTPV');
        }
        else{
            $this->enviaSMS($idr, $mensa);	
        }
        
	$_SESSION['last_submit']=time();//PARTXE SUBMITS REPETITS
	return $this->jsonOK("Reserva creada",$resposta);		
}	


/*********************************************************************************************************************/
/*********************************************************************************************************************/
// U P D A T E
// U P D A T E
// U P D A T E
// U P D A T E
// U P D A T E
/*********************************************************************************************************************/
/*********************************************************************************************************************/

public function salvaUpdate()
{	
	$resposta['request']="update";
//TODO VALIDA 
	$_POST['lang']=$_SESSION["lang"];
	$dat=date("d/m");
	$_POST['observacions']="MODIFICADA $dat ".$_POST['observacions'];

	//VERIFICA HORA ESBRINA EL TORN	
	$data=$this->cambiaf_a_mysql($_POST['selectorData']);
	if (empty($_POST['hora']))  return $this->jsonErr(8,$resposta);// 
	$hora=$_POST['hora'];
	$torn=$this->torn($data,$hora);	
	if (!$torn) return $this->jsonErr(8,$resposta); // COMPROVA torn
	//VALIDA DADES	
		//dia ok
		
	$date='';
	if ($data<date("Y-m-d")) $resposta['error']= "err1 Data passada: ".$_POST['selectorData']." < ".date("d/m/Y");
	$date = strtotime(date("Y-m-d", strtotime($date)) . " +1 year");
	if ($data>$date) $resposta['error']= "err2: data futura: ".$_POST['selectorData'];
	
	//hora - torn - taula ok?
	$coberts=$_POST['adults']+$_POST['nens10_14']+$_POST['nens4_9'];
        $PERSONES_GRUP=$this->configVars("persones_grup");
        
        if ($coberts<2 || $coberts>$PERSONES_GRUP) return $this->jsonErr(7,$resposta);;

	$cotxets=$_POST['selectorCotxets'];
	
	if (!isset($_POST['selectorAccesible'])) $_POST['selectorAccesible']=false;
	if (!isset($_POST['selectorCadiraRodes'])) $_POST['selectorCadiraRodes']=false;
	$accesible=($_POST['selectorAccesible'] || $_POST['selectorCadiraRodes']);
	
	
		// CARREGA RESERVA I COMPROVA EXISTEIX
		if (!$this->taulesDisponibles->loadReserva($_POST['id_reserva'])) return $this->jsonErr(3,$resposta);
		
		$this->taulesDisponibles->data=$data;
		$this->taulesDisponibles->torn=$torn;
		$this->taulesDisponibles->hora=$hora;
		$this->taulesDisponibles->persones=$coberts;
		$this->taulesDisponibles->cotxets=$cotxets;		
		$this->taulesDisponibles->accesible=$accesible;		
		//$this->taulesDisponibles->tableHores="estat_hores_form";
		$this->taulesDisponibles->tableHores="estat_hores";
		$this->taulesDisponibles->tableMenjadors="estat_menjador_form";
		
		$this->taulesDisponibles->llista_dies_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_nits_negra=LLISTA_DIES_NEGRA_RES_PETITES;
		$this->taulesDisponibles->llista_dies_blanca=LLISTA_DIES_BLANCA;

		//echo($this->taulesDisponibles->dump());
		// VALIDA SI HEM TROBAT TAULA
		if (!$taules=$this->taulesDisponibles->taules())  return $this->jsonErr(3,$resposta);
	
	
		$taula=$taules[0]->id;
		// VALIDA SI HEM TROBAT HORA
		if (!$this->taulesDisponibles->horaDisponible($hora)) return $this->jsonErr(8,$resposta);
		
		//SI CREA_TAULA LA GUARDA
		if ($taules[0]->taulaVirtual) $taules[0]->guardaTaula();
		
	//dades client?
	if (empty($_POST['client_mobil'])) return $this->jsonErr(4,$resposta); //"err4 mobil";
	if (empty($_POST['client_nom'])) return $this->jsonErr(5,$resposta); //"err5 nom";
	if (empty($_POST['client_cognoms'])) return $this->jsonErr(6,$resposta);//"err6: cognoms";

	/*********************************************************************************************************************/
	// PREPAREM PERMUTA
	/*********************************************************************************************************************/
	$_POST['estat_taula_taula_id']=$taula;
	$_POST['data']=$_POST['selectorData'];	
	$_POST['cotxets']=$_POST['selectorCotxets'];

	//RESERVA INFO
	$_POST['reserva_info']=$this->encodeInfo($_POST['amplaCotxets'],0,1);
	$esborra= (isset($_POST['esborra_dades']) && $_POST['esborra_dades']=='on');
	$_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],7,$esborra);
	
	$selectorCadiraRodes= (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes']=='on');
	$_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],8,$selectorCadiraRodes);
	$selectorAccesible= (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible']=='on');
	$_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],9,$selectorAccesible);
	//echo $selectorAccesible;die();
	$_POST['observacions']=preg_replace("/Portem cadira de rodes /","",$_POST['observacions']);
	if ($selectorCadiraRodes){
		$_POST['observacions']='Portem cadira de rodes '.$_POST['observacions'];
	}
	
	$perm=$_SESSION['permisos'];
	$_SESSION['permisos']=Gestor::$PERMISOS;//LI DONO PERMISOS PER FER LA PERMUTA	
	$this->permuta_reserva();
	$_SESSION['permisos']=$perm;//LI RETIRO ELS PERMISOS

	$extra=	'INFO: '.$_POST['reserva_info'];
	/*********************************************************************************************************************/
//INSERT INTO COMANDES
	$deleteSQL="DELETE FROM comanda WHERE comanda_reserva_id=".$_POST['id_reserva'];
	$this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
	for ($i=1;isset($_POST['plat_id_'.$i]);$i++)
	{
		$insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)",
		   $this->SQLVal($_POST['id_reserva'], "text"),
		   $this->SQLVal($_POST['plat_id_'.$i], "text"),
		   $this->SQLVal($_POST['plat_quantitat_'.$i], "text"));
		 $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
	}
	
	
	
//desbloquejem taula després de crear reserva, que si no no la vol
	$this->bloqueig_taula($taula,$data,$torn,true);


	
//GUARDA O UPDATA CLIENT
	$this->insertUpdateClient($_POST['client_mobil']);	


//envia SMS
	$idr=$_POST['id_reserva'];
	$mensa = "Restaurant Can Borrell, reserva MODIFICADA: Le esperamos el $data a las $hora. Rogamos comunique cualquier cambio en la web o tels.936929723 - 936910605. Gracias.(ID:$idr)";
	$this->enviaSMS($idr,$mensa);	

//envia MAIL
        $extres['subject']="Can-Borrell: MODIFICACIÓ RESERVA ONLINE ".$_POST['id_reserva'];
	if ($_POST['client_email']) $mail=$this->enviaMail($_POST['id_reserva'], "mail_res_modificada_",FALSE,$extres);


//PREPARA RESPOSTA JSON	
	$resposta['mail']=$mail;
	return $this->jsonOK("Reserva modificada: ".$extra,$resposta);		
}


public function cancelReserva($mob,$idr)
{
	if ($this->recuperaReserva($mob,$idr)) 
	{
		$perm=$_SESSION['permisos'];
		$_SESSION['permisos']=Gestor::$PERMISOS;//LI DONO PERMISOS PER FER LA PERMUTA
		$this->paperera_reserves($idr);//paperera
		$_SESSION['permisos']=$perm;	
		
		//ENVIA MAIL
                $extres['subject']="Can-Borrell: RESERVA CANCELADA ".$_POST['id_reserva'];
		$mail=$this->enviaMail($idr,"cancelada_",FALSE,$extres);
		
		$deleteSQL = "DELETE FROM ".T_RESERVES." WHERE id_reserva=$idr";
		$this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());

		$usr=$_SESSION['uSer']->id;
		
		$deleteSQL = "UPDATE ".ESTAT_TAULES." SET reserva_id=0, estat_taula_usuari_modificacio=$usr WHERE reserva_id=$idr";
		$this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
	}
	else
	{
		return false;	
	}
	
	return true;
}

public function insertUpdateClient($mobil)
{
		//VERIFICA SI EXISTEIX
		$query="SELECT * FROM client WHERE client_mobil='".$mobil."'";
		$Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
		
		if (mysql_num_rows($Result1))
		{
			// SI EL CLIENT JA EXISTIA FEM UPDATE 
			$row = mysql_fetch_array($Result1);
			$idc=$row['client_id'];	
			
			$query="UPDATE  `client` SET  
`client_nom` =  '".$_POST['client_nom']."',
`client_cognoms` =  '".$_POST['client_cognoms']."',
`client_telefon` =  '".$_POST['client_telefon']."',
`client_email` =  '".$_POST['client_email']."'
WHERE  `client`.`client_id` =$idc;
";		
			$Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
		}
		else //NO TROBAT, FEM INSERT
		{
			$query="INSERT INTO `client` (`client_id`, `client_nom`, `client_cognoms`, `client_adresa`, `client_localitat`, `client_cp`, `client_dni`, `client_telefon`, `client_mobil`, `client_email`, `client_conflictes`) VALUES (NULL, '".$_POST['client_nom']."', '".$_POST['client_cognoms']."', '".$_POST['client_adresa']."', '".$_POST['client_localitat']."', '".$_POST['client_cp']."', '".$_POST['client_dni']."', '".$_POST['client_telefon']."', '".$_POST['client_mobil']."', '".$_POST['client_email']."', NULL);";
			$Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
			$idc=mysql_insert_id($this->connexioDB);	
		}
		return $idc;
}


/*********************************************************************************************************************/
/*********************************************************************************************************************/
	public function contactar($post)
	{
		if (!empty($post['cotrol_rob'])) return false;

		$dest=MAIL_RESTAURANT;
		//$dest="alex@infopruna.net";
		$extres['reserva_consulta_online']=$_POST['reserva_consulta_online'];
		$extres['client_email']=$_POST['client_email'];
		$extres['subject']="Can-Borrell: Consulta reserves petites online";
		
		if (!empty($post['idr'])&& floor($post['idr'])<1000) return false;

		if (Gestor::validaEmail($post['client_email'])) return $this->enviaMail($post['idr'],"contactar_restaurant_",$dest,$extres);
		return false;
	}
/*********************************************************************************************************************/
	public function contactar_grups($post)
	{
		if (!empty($post['cotrol_rob'])) return false;
		if (!empty($post['idr'])&& floor($post['idr'])<500) return false;
		$idr=$post['idr'];
		
		$query="SELECT * FROM reserves 
		LEFT JOIN client ON reserves.client_id=client.client_id
		WHERE id_reserva=$idr";

		if (floor($idr)<=SEPARADOR_ID_RESERVES)
		{
			$this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
			$extres = mysql_fetch_assoc($this->qry_result);
		}
		$dest=MAIL_RESTAURANT;
		$extres['reserva_consulta_online']=$_POST['reserva_consulta_online'];
		$extres['client_email']=$_POST['client_email'];
		$extres['subject']="Can-Borrell: GRUPS Consulta reservesonline";
		
		

		if (Gestor::validaEmail($post['client_email'])) return $this->enviaMail($post['idr'],"contactar_restaurant_",$dest,$extres);
		return false;
	}
	
	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	
	public function taulaDinsMenjadors($x, $y, $menjadorsBloquejatsOnline)
	{
		foreach ($menjadorsBloquejatsOnline as $key => $menjador)
		{
			if ($menjador && $menjador->solapa($x,$y)) return $menjador->name;
		}
		return false;
	}
	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	public function TTmenu($id) //over
	{
           
		require_once(ROOT."Carta.php");
		$carta=new Carta();
		
		return $carta->TTmenu($id);
		
	}
        
        

	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
        public function paga_i_senyal($comensals){
            
                return ($comensals>=$this->configVars("persones_paga_i_senyal") && $comensals<$this->configVars("persones_grup")); 
        }
        
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
        public function estatReserva($idr){
            
               $query="SELECT estat "
                      . "FROM ".T_RESERVES." "
                      . "WHERE id_reserva=$idr";
              $result = mysql_query($query, $this->connexioDB) or die(mysql_error());
              //$row=  mysql_fetch_assoc($result);
              return mysql_result($result,0);
       }
        
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
        public function generaFormTpv($id_reserva,$import, $nom){
                include(INC_FILE_PATH.'TPV.php'); 
                $lang=$this->lang;
                  $order=substr(time(),0,3).$id_reserva;
                  $order=$id_reserva;
                    
                $name='Restaurant Can Borrell';
                $amount=$import*100;
               
                  
                //$urlMerchant='http://www.can-borrell.com/editar/TPV/respostaTPV.php';
                $urlMerchant='http://'.$_SERVER['HTTP_HOST'].'/reservar/Gestor_form.php?a=respostaTPV';
                //$urlMerchant='http://'.$_SERVER['HTTP_HOST'].'/reservar/respostaTPV.php';
                $producte="Reserva restaurant Can Borrell";
                $titular=$nom;
                $urlOK="http://www.can-borrell.com/editar/TPV/pagamentOK.php?id=$id&lang=$lang";
                $urlKO="http://www.can-borrell.com/editar/TPV/pagamentKO.php?id=$id&lang=$lang";
                $idioma=($lang=="cat")?"003":"001";
                $boto['cat']="Realitzar Pagament";
                $boto['esp']="Realizar Pago";
                //$url_tpvv="https://sis-t.redsys.es:25443/sis/realizarPago";
                
                $HTML="    <script language=JavaScript>
    function calc() { 
	
		
    document.getElementById('boto').style.display = 'none';
    vent=window.open('','frame-tpv','width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
   // vent.moveTo(eje_x,eje_y);
    document.compra.submit();}
    </script>
";
                     $hidden="hidden"; 
                $HTML .= "<form id='compra' name='compra' action='$url_tpvv' method='post' target='frame-tpv'  style='display:none'>
                          
                <input type=$hidden name=Ds_Merchant_Amount value='$amount'>
                <input type=$hidden name=Ds_Merchant_Currency value='$currency'>
                <input id=tpv_order type=$hidden name=Ds_Merchant_Order  value='$order'>
                <input type=$hidden name=Ds_Merchant_MerchantCode value='$code'>
                <input type=$hidden name=Ds_Merchant_Terminal value='$terminal'>
                <input type=$hidden name=Ds_Merchant_TransactionType value='$transactionType'>
                <input type=$hidden name=Ds_Merchant_ProductDescription value='$producte'>
                <input id=tpv_titular type=$hidden name=Ds_Merchant_Titular value='$titular'>
                <input type=$hidden name=Ds_Merchant_UrlOK value='$urlOK'>
                <input type=$hidden name=Ds_Merchant_UrlKO value='$urlKO'>
                <input type=$hidden name=Ds_Merchant_ConsumerLanguage value='$idioma'>
                <input type=$hidden name=Ds_Merchant_MerchantURL value='$urlMerchant'>";
                
               
                
                $HTML.= "<input id=tpv_signature type=$hidden name=Ds_Merchant_MerchantSignature value='------------'>
                    <input id='boto' type='submit' name='Submit' value='".$this->l('Realizar Pago',false)."' onclick='javascript:calc(); '/>
                </form>";										  
                         
                   
                 $this->greg_log("generaFormTpv:$id_reserva > $import > $nom",LOG_FILE_TPVPK);/*LOG*/
               return $HTML; 
        }
        
        private function signatureTpv($order,$import,$urlMerchant='http://www.can-borrell.com/editar/TPV/respostaTPV.php'){
                include(INC_FILE_PATH.'TPV.php'); 
                //echo $amount." / ".$order." / ".$code." / ".$currency." / ".$transactionType." / ".$urlMerchant." / ".$clave;
                $amount=$import*100;
                $message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
                return strtoupper(sha1($message));
            
        }
        
         /**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
        /***************************************************/
       //
       // CODIFICACIO ESTAT
       //
       // 1 PENDENT
       // 2 CONFIRMADA
       // 3 PAGAT TRANSF 
       // 4 DENEGADA
       // 5 ELIMINADA
       // 6 CADUCADA
       // 7 PAGAT TPV
       // 100 RES.PETITA
       /***************************************************/
       public function respostaTPV(){
           /*LOG*/
           echo "respostaTPV >> ".date(" / d-m-y H:i:s");
           
           
            $f=fopen("log_TPV.txt","a");
            fwrite($f,date("\n<br/>+++ d-m-y H:i:s >> "));
            fwrite($f,"RESPOSTA TPV >>> IDR:");
            fwrite($f,$_POST["Ds_Order"]);
            //fclose($f);
           if (!isset($_POST["Ds_Signature"])) echo " >> FALTA SIGNATURE ";
            $this->greg_log("RespostaTPV (".$_POST["Ds_Date"]." ".$_POST["Ds_Hour"]." ):".$_POST["Ds_Order"]." >> Response: ".$_POST["Ds_Response"]." >> Signture: ".$_POST["Ds_Signature"]." >> Amount: ".$_POST["Ds_Amount"],LOG_FILE_TPVPK);
            if (!isset($_POST["Ds_Amount"])) $_POST["Ds_Amount"]='';
            if (!isset($_POST["Ds_Order"])) $_POST["Ds_Order"]='';
            if (!isset($_POST["Ds_MerchantCode"])) $_POST["Ds_MerchantCode"]='';
            if (!isset($_POST["Ds_Currency"])) $_POST["Ds_Currency"]='';
            if (!isset($_POST["Ds_Response"])) $_POST["Ds_Response"]='';
            if (!isset($_POST["Ds_Hour"])) $_POST["Ds_Hour"]='';
            if (!isset($_POST["Ds_Date"])) $_POST["Ds_Date"]='';
            if (!isset($_POST["Ds_Signature"])) $_POST["Ds_Signature"]='';            
            if (!isset($_GET["sig"])) $_GET["sig"]='';
            
            
           $lang=((int)$_POST["Ds_ConsumerLanguage"])==3?$lang="cat":$lang="esp";
            include (INC_FILE_PATH."TPV.php");
            $message = $_POST["Ds_Amount"].$_POST["Ds_Order"].$_POST["Ds_MerchantCode"].$_POST["Ds_Currency"].$_POST["Ds_Response"].$clave;
            //echo $message;die();
            $signature = strtoupper(sha1($message));
            $resposta=(int)$_POST["Ds_Response"];
            
            $k=substr($_POST["Ds_Order"],3,6);
            $id=(int)$k;
                
            
            //echo "<pre>".print_r($_POST)."</pre>";
            /**
             * 
             * DOBLE PAGAMENT
             * 
             */
              $query="SELECT estat, client_email, data, hora, adults, nens10_14, nens4_9 "
                      . "FROM ".T_RESERVES." "
                      . "LEFT JOIN client ON client.client_id=".T_RESERVES.".client_id "
                      . "WHERE id_reserva=$id";
              $result = mysql_query($query, $this->connexioDB) or die(mysql_error());
              $row=  mysql_fetch_assoc($result);
              $estat=  $row['estat'];
              $mail=$row['client_email'];
              if ($estat!=2) {
                    $msg="PAGAMENT INAPROPIAT RESERVA???: ".$id." estat: $estat  $mail";
                    //echo $msg;
                    $this->greg_log($msg,LOG_FILE_TPVPK);/*LOG*/
                    $extres['subject']="Can-Borrell: !!!! $msg!!!";
                    //$mail=$this->enviaMail($id,"confirmada_",MAIL_RESTAURANT,$extres);
                    $mail=$this->enviaMail($id,"paga_i_senyal_",MAIL_RESTAURANT,$extres);
                    
              }
              
            $referer=$_SERVER['REMOTE_ADDR'];           
           
            if (($_POST["Ds_Signature"]==$signature) && ($resposta>=0) && ($resposta<=99))
            {
                /******************************************************************************/
               // echo "...........................ENVIEM...";
               $import= $_POST["Ds_Amount"]/100;
               $resposta="PAGA I SENYAL TPV: ".$import."Euros (".$_POST["Ds_Date"]." ".$_POST["Ds_Hour"].")";
               $query="UPDATE ".T_RESERVES." SET estat=100, preu_reserva='$import', resposta='$resposta' WHERE id_reserva=$id";
                $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());

                $extres['subject']=$this->l("Can-Borrell: RESERVA CONFIRMADA",false);
                
                if ($mail) echo $this->enviaMail($id,"paga_i_senyal_","",$extres);
                
                $persones=$row['adults']+$row['nens10_14']+$row['nens4_9'];
                $persones.='p';

                $data=$this->cambiaf_a_normal($row['data']);
                $hora=$row['hora'];

                $missatge = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$id)";
                $missatge.="\n***\nConserve este SMS como comprobante de la paga y señal de ".$import."€ que le será descontada. También hemos enviado un email que puede imprimir";   
                
                //echo $missatge;
                $this->enviaSMS($id, $missatge);	
    
                
               if ($result) //ACTUALITZADA BBDD
               {
                   echo "PAGAMENT OK ".$id;
                    fwrite($f,"...OK");
                   $this->greg_log("PAGAMENT+UPDATE OK ".$query." >> ".$result,LOG_FILE_TPVPK);/*LOG*/
               }
               else
               {
                   fwrite($f,"...OK !!! PAGAT OK però ERROR DDBB $id");
                   echo "OK !!!  PAGAT OK però ERROR DDBB $id";
                    $this->greg_log("PAGAMENT OK+UPDATE KO ".$query." >> ".$result,LOG_FILE_TPVPK);/*LOG*/
                }
            }
            else //ERROR
            {
                if ($_POST["Ds_Signature"]!=$signature) echo "ERROR DE SIGNATURE $id";
                fwrite($f,"...KO ERROR DE SIGNATURE $id");
                $this->greg_log("SIGNTURE KO!!!! ".$_POST["Ds_Signature"]." >> ".$signature." >> MESSAGE: ???????$xxxmessage",LOG_FILE_TPVPK);/*LOG*/
            }

        }       
        
        
        /**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
        public function testTPV($idr){
  		if (!$this->valida_sessio(63)) die("Sense permisos");
                
             $query="SELECT estat,  data, hora, adults, nens10_14, nens4_9  FROM ".T_RESERVES." WHERE id_reserva=$idr";
               $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
               $estat=  mysql_result($result, 0);
              // if ($estat!=2) die("Aquesta reserva no està pendent de pagament");
               
               $resposta="TEST!!!! PAGA TARJA ";
               $preu=11.11;
               $query="UPDATE ".T_RESERVES." SET estat=100,resposta='$resposta', preu_reserva=$preu WHERE id_reserva=$idr";
               echo $query;
               echo "<br><br>";
              $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
                echo $result;
                
                $this->greg_log("TEEEST!!!!!!! testTPV:$idr >> $query >> $result",LOG_FILE_TPVPK);
                
                
                               $import= $_POST["Ds_Amount"]/100;
              // $resposta="PAGA I SENYAL TPV: ".$import."Euros (".$_POST["Ds_Date"]." ".$_POST["Ds_Hour"].")";
              // $query="UPDATE ".T_RESERVES." SET estat=100, preu_reserva='$import', resposta='$resposta' WHERE id_reserva=$id";
               // $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());

                $extres['subject']=$this->l("Can-Borrell: RESERVA CONFIRMADA",false);
                //$extres['subject'].=$this->l("<br>REBUT PAGAMENT",false);;
                //$extres['subject']="  ".$import."€";
                
                if ($mail) echo $this->enviaMail($id,"paga_i_senyal_",MAIL_RESTAURANT,$extres);
                
        $persones=$row['adults']+$row['nens10_14']+$row['nens4_9'];
	$persones.='p';
        
        $data=$this->cambiaf_a_normal($row['data']);
        $hora=$row['hora'];
        
	$missatge = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$res)";
          $missatge.="Si lo desea conserve este SMS como comprobante de la paga y señal de $import€ que debe ser descontada. También hemos enviado un email que puede imprimir";   
                
                $this->enviaSMS($id, $missatge);	

        }
        
        
        
        /**********************************************************************************************************/	
	/**********************************************************************************************************/	
	/**********************************************************************************************************/	
	public function test($t) //over
	{
		$this->valida_sessio(1);
		echo "Gestor_form: ".$t;
	}
} //END CLASS





/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
// AJAX



if (isset($accio) && !empty($accio))
{
  	if (!isset($_REQUEST['b'])) $_REQUEST['b']=null;
  	if (!isset($_REQUEST['c'])) $_REQUEST['c']=null;
  	if (!isset($_REQUEST['d'])) $_REQUEST['d']=null;
  	if (!isset($_REQUEST['e'])) $_REQUEST['e']=null;
  	if (!isset($_REQUEST['f'])) $_REQUEST['f']=null;
  	if (!isset($_REQUEST['g'])) $_REQUEST['g']=null;
  	if (!isset($_REQUEST['p'])) $_REQUEST['p']=null;
  	if (!isset($_REQUEST['q'])) $_REQUEST['q']=null;
  	if (!isset($_REQUEST['r'])) $_REQUEST['r']=null;

  $gestor=new Gestor_form(1);
  
  if (method_exists($gestor,$accio)){ 

  	$logables=array('cancelReserva','insertUpdateClient','salvaUpdate','submit','update_client','esborra_client','inserta_reserva','update_reserva','esborra_reserva','enviaSMS','permuta','permuta_reserva','','','','','','','','','','','');
  	$log=in_array($accio, $logables);
	$ip=isset($ips[$_SERVER['REMOTE_ADDR']])?$ips[$_SERVER['REMOTE_ADDR']]:$_SERVER['REMOTE_ADDR'];
	$sessuser=$_SESSION['uSer'];

	if (isset($sessuser)) $user=$sessuser->id;
  	
  	if ($log)	{
  		$req='<pre>'.print_r($_REQUEST,true).'</pre>';
  		$gestor->reg_log("Petició Gestor FORM: ".$accio."  user:$user ($ip) (b=".$_REQUEST['b'].", c=".$_REQUEST['c'].", d=".$_REQUEST['d']." ---- p=".$_REQUEST['p'].", q=".$_REQUEST['q'].", r=".$_REQUEST['r'].", c=".$_REQUEST['c'].", d=".$_REQUEST['d'].", e=".$_REQUEST['e'].") > ".$req.EOL);
  	}
  	
  	
  	if (!$gestor->valida_sessio(1) && $accio!='respostaTPV') {echo "err100";	die();}
  	$gestor->out(call_user_func(array($gestor, $accio),$_REQUEST['b'],$_REQUEST['c'],$_REQUEST['d'],$_REQUEST['e'],$_REQUEST['f'],$_REQUEST['g']));
  }	
}
//update estat_hores set estat_hores_torn=1 where estat_hores_data>="2013-12-13" and estat_hores_torn=2
?>