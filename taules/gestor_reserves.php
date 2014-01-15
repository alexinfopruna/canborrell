<?php
if (!defined('ROOT')) define('ROOT', "");

require_once(ROOT."Gestor.php");

if (!defined('LLISTA_DIES_NEGRA')) define("LLISTA_DIES_NEGRA",INC_FILE_PATH."llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA')) define("LLISTA_NITS_NEGRA",INC_FILE_PATH."llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA')) define("LLISTA_DIES_BLANCA",INC_FILE_PATH."llista_dies_blanca.txt");

require_once(ROOT."Menjador.php");
require_once(ROOT."TaulesDisponibles.php");

if (!defined('HEADERS')) header('Content-Type: text/html; charset=utf-8');
header('Content-Encoding: bzip');
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['data'])) $_SESSION['data']=date("Y-m-d");
if (!isset($_SESSION['torn'])) $_SESSION['torn'] = 1;

setlocale(LC_ALL, 'ca_CA');


class gestor_reserves extends Gestor
//class gestor_reserves 
{ 
  protected $ordre;
  protected $database_name;
  protected $connexioDB;

  protected $qry_result;
  protected $last_row;
  protected $total_rows;
  protected $error;
  
  // paginacio
  protected $currentPage;
  protected $maxRows_reserva;
  protected $pageNum_reserva;
  protected $startRow_reserva;
  
  protected $taulesDisponibles;
  protected $menjadors; 
  
  protected $data_BASE="2011-01-01";
  /****************************************/
  /****************************************/
  /********      CONSTRUCTOR     ************/
  /****************************************/
  /****************************************/
  public function __construct($db_connection_file=DB_CONNECTION_FILE,$usuari_minim=16)  
  {
    parent::__construct($db_connection_file,$usuari_minim);
    //COORDENADES MENJADORS
    include(ROOT."coord_menjadors.php");
    $this->menjadors=$menjadors;
    $this->taulesDisponibles=new TaulesDisponibles();
    $this->taulesDisponibles->data=$_SESSION['data'];
    $this->taulesDisponibles->torn=$_SESSION['torn'];
 
  }
  
/****************************************/
/****************************************/
/********      BLOQUEJOS       *********/
/****************************************/
/****************************************/
  public function taula_bloquejada($taula_id)
  {
    $deleteSQL="UPDATE ".ESTAT_TAULES." SET estat_taula_blok = NULL,estat_taula_blok_sess = NULL WHERE estat_taula_blok < NOW() AND estat_taula_blok IS NOT NULL";
    $this->qry_result = mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
  
    $sess=session_id();
    $sql = "SELECT estat_taula_blok FROM ".ESTAT_TAULES."
    WHERE estat_taula_torn='".$_SESSION['torn']."'
    AND estat_taula_data = '".$_SESSION['data']."'
    AND estat_taula_taula_id = '$taula_id'
    AND (estat_taula_blok_sess <> '$sess') 
    AND (estat_taula_blok > NOW())";
    
    $this->qry_result = mysql_query($sql, $this->connexioDB) or die(mysql_error());
    
    $nr=mysql_num_rows($this->qry_result);
    $this->reg_log("taula_bloquejada $taula_id = $nr");
    
    return $nr;
  }
  //UNLOCK_AFTER
  
  public function bloqueig_taula($taula_id,$data,$torn,$unlock=false)
  {
    //$torn=$_SESSION['torn'];
    //$mydata=cambiaf_a_mysql($_SESSION['data']);
    $mydata=$this->cambiaf_a_mysql($data);
    
    $deleteSQL="UPDATE ".ESTAT_TAULES." SET estat_taula_blok = NULL,estat_taula_blok_sess = NULL WHERE estat_taula_blok < NOW() AND estat_taula_blok IS NOT NULL";
    $this->qry_result = mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());


    if (!$taula_id || $taula_id=="null" || $taula_id=="undefined") return "ko";
    if ($unlock) $sess=$lock=" NULL ";
    //else $lock=" DATE_ADD (NOW(), INTERVAL ".UNLOCK_AFTER.")";
    else 
    {
      $lock=" NOW() + INTERVAL ".UNLOCK_AFTER;
      $sess="'".session_id()."'";
    }

  
    $sql = "SELECT * FROM ".ESTAT_TAULES."
    WHERE estat_taula_torn='".$torn."'
    AND (estat_taula_data = '".$mydata."' OR estat_taula_data = '".$this->data_BASE."')
    AND estat_taula_taula_id = '$taula_id'
    ORDER BY estat_taula_data DESC";
    
    $this->qry_result = mysql_query($sql, $this->connexioDB) or die(mysql_error());
    $row=$this->last_row = mysql_fetch_assoc($this->qry_result);
      
    $rsql="SELECT NOW() + INTERVAL ".UNLOCK_AFTER." AS loc";  
    $rs = mysql_query($rsql, $this->connexioDB) or die(mysql_error());
    $r=$this->last_row = mysql_fetch_assoc($rs);
    $r=$r['loc'];
    
     $sessid=session_id();
    if ($row['estat_taula_data']>$this->data_BASE)
      $sql = "UPDATE  ".ESTAT_TAULES." 
      SET estat_taula_blok = $lock,
      estat_taula_blok_sess = $sess
      WHERE estat_taula_taula_id = $taula_id
      AND (estat_taula_blok_sess='$sessid' OR estat_taula_blok_sess IS NULL)
      AND estat_taula_data= '$mydata'
      AND estat_taula_torn= '$torn'";
    else
      $sql = sprintf("INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_blok, estat_taula_blok_sess) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                 $this->SQLVal($mydata, text),
                 $this->SQLVal($row['estat_taula_nom'], "text"),
                 $this->SQLVal($torn, "text"),
                 $this->SQLVal($taula_id, "text"),
                 $this->SQLVal($row['reserva_id'], "text"),
                 $this->SQLVal($row['estat_taula_x'], "text"),
                 $this->SQLVal($row['estat_taula_y'], "zero"),
                 $this->SQLVal($row['estat_taula_persones'], "zero"),
                 $this->SQLVal($row['estat_taula_cotxets'], "zero"),
                 $this->SQLVal($row['estat_taula_grup'], "text"),
                 $this->SQLVal($row['estat_taula_plena'], "text"),
                 $lock,
                $sess);
      
      $this->qry_result = mysql_query($sql, $this->connexioDB) or die(mysql_error());
      return mysql_affected_rows($this->connexioDB)?"ok$unlock":"ko$unlock";
  }
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/********   RESERVES  *********/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/

  
/****************************************/
/****************************************/
/********      ESBORRA_RESERVA     ******/
/****************************************/
/****************************************/
  public function esborra_reserva($id_reserva,$permuta=false)
  {
    if ($_SESSION['permisos']<16) return "error:sin permisos";
  
    $persones_default=PERSONES_DEFAULT;
    if ($id_reserva <= 1) return false;
    $query = "SELECT * FROM ".T_RESERVES." WHERE id_reserva=$id_reserva";
    $this->qry_result =mysql_query($query, $this->connexioDB) or die(mysql_error());
    $row = $this->last_row = mysql_fetch_assoc($this->qry_result);
    if ($row['data']<"2011") return "DATA ANOMALA esborra_reserva";

    
    $dataSMS=$dataSMS=$this->cambiaf_a_normal($row['data']);
    $hora=$row['hora'];
    $mensa = "Restaurant Can Borrell: Su reserva para el $dataSMS a las $hora HA SIDO ANULADA. Si desea contactar con nosotros: 936929723 - 936910605. Gracias.(ID$id_reserva)";
    if (!$permuta)  
    {
      $this->enviaSMS($id_reserva, $mensa);
      $this->paperera_reserves($id_reserva);
    //ENVIA MAIL
      $mail=$this->enviaMail($id_reserva,"cancelada_");
    }   
    
      $deleteSQL = "DELETE FROM ".T_RESERVES." WHERE id_reserva=$id_reserva";
      $res=$this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
      
      //$usr=$_SESSION['admin_id'];
      $usr=$_SESSION['uSer']->id;
      
      $deleteSQL = "UPDATE ".ESTAT_TAULES." SET reserva_id=0, estat_taula_usuari_modificacio=$usr WHERE reserva_id=$id_reserva";
      $res=$this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
    
      ///if ($permuta){return $res;}
      //if (!isset($_REQUEST['a'])) header("Location: ".$_SERVER['PHP_SELF']);
      //return $this->accordion_reserves();
      
    $resposta['resposta']="ok";
    $resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
    $resposta['missatge_dia'] = $this->recupera_missatge_dia();
    //$resposta['ac_reserves']=$this->accordion_reserves();
    $resposta['del_reserva']=$id_reserva;
	
    return $this->jsonResposta($resposta);
  }
  
  
/****************************************/
/****************************************/
/********      PEPEREREA_RESERVA     *********/
/****************************************/
/****************************************/
  public function paperera_reserves($id_reserva)
  {
    if ($_SESSION['permisos'] < 16) return "error:sin permisos";
    /**/
    if (!defined("DB_CONNECTION_FILE_DEL")) return;
    
    $reserva = $this->load_reserva($id_reserva);
    
    //connectem a la bbdd d'ESBORRADES
    
    include(ROOT.DB_CONNECTION_FILE_DEL); 
    mysql_select_db($database_canborrell, $canborrell);

    $insertSQL = sprintf("REPLACE INTO ".T_RESERVES." ( id_reserva, client_id, data, hora, adults, 
      nens4_9, nens10_14, cotxets, observacions, resposta, estat) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                 $this->SQLVal($reserva['id_reserva'], "text"),
                $this->SQLVal($reserva['client_id'], "text"),
                 $this->SQLVal($reserva['data'], "datePHP"),
                 $this->SQLVal($reserva['hora'], "text"),
                 $this->SQLVal($reserva['adults'], "zero"),
                 $this->SQLVal($reserva['nens4_9'], "zero"),
                 $this->SQLVal($reserva['nens10_14'], "zero"),
                 $this->SQLVal($reserva['cotxets'], "zero"),
                 $this->SQLVal($reserva['observacions'], "text"),
                 $this->SQLVal($reserva['resposta'], "text"),
                 $this->SQLVal($reserva['estat'], "text"));

      $this->qry_result = $this->log_mysql_query($insertSQL, $canborrell) or die(mysql_error());
    $insertSQL = sprintf("REPLACE INTO ".ESTAT_TAULES." ( estat_taula_id,estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                 $this->SQLVal($reserva['estat_taula_id'], "text"),
                 $this->SQLVal($reserva['estat_taula_data'], "text"),
                 $this->SQLVal($reserva['estat_taula_nom'], "text"),
                 $this->SQLVal($reserva['estat_taula_torn'], "text"),
                 $this->SQLVal($reserva['estat_taula_taula_id'], "text"),
                 $this->SQLVal($reserva['id_reserva'], "text"),
                 $this->SQLVal($reserva['estat_taula_x'], "text"),
                 $this->SQLVal($reserva['estat_taula_y'], "text"),
                 $this->SQLVal($reserva['estat_taula_persones'], "zero"),
                 $this->SQLVal($reserva['estat_taula_cotxets'], "zero"),
                 $this->SQLVal($reserva['estat_taula_grup'], "text"),
                 $this->SQLVal($reserva['estat_taula_plena'], "text"));
      
    $this->qry_result = $this->log_mysql_query($insertSQL, $canborrell) or die(mysql_error());
      
    $insertSQL = sprintf("REPLACE INTO client ( client_id, client_nom, client_cognoms, client_adresa, 
      client_localitat, client_cp, client_dni, client_telefon, client_mobil, client_email, client_conflictes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                 $this->SQLVal($reserva['client_id'], "text"),
                $this->SQLVal($reserva['client_nom'], "text"),
                 $this->SQLVal($reserva['client_cognoms'], "text"),
                 $this->SQLVal($reserva['client_adresa'], "text"),
                 $this->SQLVal($reserva['client_localitat'], "text"),
                 $this->SQLVal($reserva['client_cp'], "text"),
                 $this->SQLVal($reserva['client_dni'], "text"),
                 $this->SQLVal($reserva['client_telefon'], "text"),
                 $this->SQLVal($reserva['client_mobil'], "text"),
                 $this->SQLVal($reserva['client_email'], "text"),
                 $this->SQLVal($reserva['client_conflictes'], "text"));
                 
    $this->qry_result = $this->log_mysql_query($insertSQL, $canborrell);
    
    // ESBORREM INFO CADUCADA
    /**/
    if (CLEAR_DELETED_BEFORE)
    {
      $deleteSQL = "DELETE FROM ".T_RESERVES." WHERE data>'".$this->data_BASE."' AND data< NOW() - INTERVAL ".CLEAR_DELETED_BEFORE;
      $this->qry_result = $this->log_mysql_query($deleteSQL, $canborrell) or die(mysql_error());
      $deleteSQL = "DELETE FROM ".ESTAT_TAULES." WHERE estat_taula_data>'".$this->data_BASE."' AND estat_taula_data< NOW() - INTERVAL ".CLEAR_DELETED_BEFORE;
      $this->qry_result = $this->log_mysql_query($deleteSQL, $canborrell) or die(mysql_error());
    }
    
    mysql_close($canborrell);
    mysql_select_db($this->database_name, $this->connexioDB);
    
    //PASSO SMS
    $insertSQL = sprintf("REPLACE INTO `$database_canborrell`.sms ( sms_id, sms_data, sms_reserva_id, sms_numero, sms_missatge) 
    SELECT sms_id, sms_data, sms_reserva_id, sms_numero, sms_missatge FROM sms 
    WHERE sms_reserva_id=$id_reserva");
    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
    //DELETE
    $deleteSQL = "DELETE FROM sms WHERE sms_reserva_id=$id_reserva";
    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
  
    //PASSO COMANDES
    $insertSQL = sprintf("REPLACE INTO `$database_canborrell`.comanda ( comanda_id, comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
    SELECT comanda_id, comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat 
    FROM comanda 
    WHERE comanda_reserva_id=$id_reserva");
    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
    //DELETE
    $deleteSQL = "DELETE FROM comanda WHERE comanda_reserva_id=$id_reserva";
    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
    
    return true;
  }
  
/****************************************/
/****************************************/
/********      INSERTA_RESERVA     *********/
/****************************************/
/****************************************/
  public function inserta_reserva()
  {
    if ($_SESSION['permisos'] < 16) return "error:sin permisos";
    
    if (!$this->valida_reserva($_POST['estat_taula_taula_id'],$this->cambiaf_a_mysql($_POST['data']))) return "DATA ANOMALA inserta_reserva"; 

    $this->reg_log("CREANT RESERVA: ".$_POST['data']." - ".$_POST['hora']." - ".$_POST['adults']);
    
    $_POST['client_id']=$this->controlClient($_POST['client_id'],$_POST['client_mobil']);
    
    /*
     * reserva_info
     */
    $online=$this->flagBit($_POST['reserva_info'],1);
   $_POST['reserva_info']=$this->encodeInfo($_POST['amplaCotxets'],0,$online);
        $selectorCadiraRodes= (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes']=='on');//cadira
    $_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],8,$selectorCadiraRodes);
    $selectorAccesible= (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible']=='on');
    $_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],9,$selectorAccesible);
    
    $insertSQL = sprintf("INSERT INTO ".T_RESERVES." ( id_reserva, client_id, data, hora, adults, 
      nens4_9, nens10_14, cotxets, observacions, resposta, estat, usuari_creacio, reserva_navegador, reserva_info) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                 $this->SQLVal($_POST['id_reserva'], "text"),
                $this->SQLVal($_POST['client_id'], "text"),
                 $this->SQLVal($_POST['data'], "datePHP"),
                 $this->SQLVal($_POST['hora'], "text"),
                 $this->SQLVal($_POST['adults'], "zero"),
                 $this->SQLVal($_POST['nens4_9'], "zero"),
                 $this->SQLVal($_POST['nens10_14'], "zero"),
                 $this->SQLVal($_POST['cotxets'], "zero"),
                 $this->SQLVal($_POST['observacions'], "text"),
                 $this->SQLVal($_POST['resposta'], "text"),
                 $this->SQLVal(100, "text"),
                 $this->SQLVal($_SESSION['admin_id'], "text"),
                 $this->SQLVal($_SERVER['HTTP_USER_AGENT'], "text"),
                 $this->SQLVal($_POST['reserva_info'], "zero"));
      $a=$this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
      $idr=mysql_insert_id($this->connexioDB);
      
/**************/
      $data=$this->cambiaf_a_mysql($_POST['data']);
      $torn=$this->torn($data,$_POST['hora']);
      $estatSQL = "SELECT * FROM ".ESTAT_TAULES." 
      
      WHERE (estat_taula_data<'$data 23:59:59' 
      AND estat_taula_data>='$data' 
      AND estat_taula_torn=$torn      
      AND estat_taula_taula_id = ".$_POST['estat_taula_taula_id'].")
      OR (estat_taula_data='".$this->data_BASE."' AND estat_taula_taula_id = ".$_POST['estat_taula_taula_id'].")
      
      ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";
      
      $this->qry_result = mysql_query($estatSQL, $this->connexioDB) or die(mysql_error());
      $row = mysql_fetch_assoc($this->qry_result);
      if (!$row['estat_taula_nom']) $row['estat_taula_nom']=$_POST['estat_taula_taula_id'];
    $insertSQL = sprintf("INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                 $this->SQLVal($_POST['data'], "datePHP"),
                 $this->SQLVal($row['estat_taula_nom'], "text"),
                 $this->SQLVal($torn, "text"),
                $this->SQLVal($_POST['estat_taula_taula_id'], "text"),
                 $this->SQLVal($idr, "text"),
                 $this->SQLVal($row['estat_taula_x'], "text"),
                 $this->SQLVal($row['estat_taula_y'], "text"),
                 $this->SQLVal($row['estat_taula_persones'], "zero"),
                 $this->SQLVal($row['estat_taula_cotxets'], "zero"),
                 $this->SQLVal($row['estat_taula_grup'], "text"),
                 $this->SQLVal($row['estat_taula_plena'], "text"),
                 $this->SQLVal($_SESSION['admin_id'], "text"));
      
      $b=$this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
      $id = mysql_insert_id();
      //$_SESSION['torn']=$torn;
      
    //DELETE REDUNDANTS
      $deleteSQL=sprintf("DELETE FROM ".ESTAT_TAULES."
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s",
       $this->SQLVal($_POST['estat_taula_taula_id'], "text"),
       $this->SQLVal($_POST['data'], "datePHP"),
       $this->SQLVal($torn, "text"),
       $this->SQLVal($id, "text"));
      
      $c=$this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
      
      // ENVIA SMS
      if (isset($_POST['cb_sms']))
      {
        $_REQUEST['res'] = $idr;
        $dataSMS=$this->cambiaf_a_normal($data);
        $hora=$_POST['hora'];
        $coberts=($_POST['adults']+$_POST['nens4_9']+$_POST['nens10_14'])."p";
        if ($_POST['cotxets']) $coberts.="+".$_POST['cotxets']."cochecito";
        if ($_POST['cotxets']>1) $coberts.="s";
        $mensa = "Recuerde: reserva en Restaurant Can Borrell. $dataSMS $hora ($coberts).Rogamos comunique cualquier cambio: 936929723/936910605.Gracias.(ID$idr)";
        
        $this->enviaSMS($idr, $mensa);          
        //ENVIA MAIL
        $mail=$this->enviaMail($idr);
      }
      
      $_POST['id_reserva']=$idr;
      
      $this->qry_result=($a && $b && $c);
  
    $resposta['resposta']="ok";
    $resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
    $resposta['missatge_dia'] = $this->recupera_missatge_dia();
    //$resposta['add_reserva']=$this->accordion_reserves("id_reserva=".$idr);
    $resposta['ac_reserves']=$this->accordion_reserves();
	
    return $this->jsonResposta($resposta);
  }

  
/****************************************/
/****************************************/
/********      UPDATE_RESERVA     ************/
/****************************************/
/****************************************/
  public function update_reserva()
  {
    if ($_SESSION['permisos']<16) return "error:sin permisos";

    if (!$this->valida_reserva($_POST['estat_taula_taula_id'],$this->cambiaf_a_mysql($_POST['data']))) return "DATA ANOMALA update_reserva"; 
    
    
    $torn=$this->torn($this->cambiaf_a_mysql($_POST['data']),$_POST['hora']);
      
      $updateSQL = "UPDATE ".ESTAT_TAULES." SET estat_taula_usuari_modificacio=".$_SESSION['admin_id'].", reserva_id='".$_POST['id_reserva']."',estat_taula_data=".$this->SQLVal($_POST['data'], 'datePHP').", estat_taula_torn='".$torn."', estat_taules_timestamp=CURRENT_TIMESTAMP WHERE reserva_id=".$_POST['id_reserva'];
      $result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(mysql_error());

      /*
       * reserva_info
       */
    
    
    $online=$this->flagBit($_POST['reserva_info'],1);  
    $encode = $this->encodeInfo($_POST['amplaCotxets'], 0, $online);
    $_POST['reserva_info']=$_POST['reserva_info'] | $encode;
    $selectorCadiraRodes= (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes']=='on');//cadira
    $_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],8,$selectorCadiraRodes);
    $selectorAccesible= (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible']=='on');//cadira
    $_POST['reserva_info']=$this->flagBit($_POST['reserva_info'],9,$selectorAccesible);
            /*
         * 
         */
      $updateSQL = sprintf("UPDATE ".T_RESERVES." SET  id_reserva=%s, client_id=%s, data=%s, hora=%s, adults=%s,nens4_9=%s, 
      nens10_14 = %s, cotxets = % s, observacions = %s, resposta = %s, estat=%s, reserva_info=%s WHERE id_reserva=%s",
                 $this->SQLVal($_POST['id_reserva'], "text"),
                $this->SQLVal($_POST['client_id'], "text"),
                 $this->SQLVal($_POST['data'], "datePHP"),
                 $this->SQLVal($_POST['hora'], "text"),
                 $this->SQLVal($_POST['adults'], "text"),
                 $this->SQLVal($_POST['nens4_9'], "text"),
                 $this->SQLVal($_POST['nens10_14'], "text"),
                 $this->SQLVal($_POST['cotxets'], "text"),
                 $this->SQLVal($_POST['observacions'], "text"),
                 $this->SQLVal($_POST['resposta'], "text"),
                 $this->SQLVal(100, "text"),
                 $this->SQLVal($_POST['reserva_info'], "int"),
                 $this->SQLVal($_POST['id_reserva'], "text"));

                 $result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(mysql_error());
    

    
    if (isset($_POST['cb_sms']))  {$this->enviaSMS($id_reserva, $mensa);}
             
    if (!isset($_REQUEST['a'])) header("Location: ".$_SERVER['PHP_SELF']);
     
    $resposta['resposta']="ok";
    $resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
    $resposta['missatge_dia'] = $this->recupera_missatge_dia();
    $resposta['ac_reserves']=$this->accordion_reserves();
    
    return $this->jsonResposta($resposta);
     //return $query
     //return $this->accordion_reserves();
  
  }
  
/****************************************/
/****************************************/
/********   PERMUTA_RESERVA    *********/
/****************************************/
/****************************************/
/**/
  public function permuta_reserva()
  {   
    if ($_SESSION['permisos']<16) return "error:sin permisos";
    if ($_POST['extendre'] == 1) {
      return $this->extendreReserva();
    }
     $resposta['resposta']="ko";
    $reserva=$_POST['id_reserva'];
    $data=$this->cambiaf_a_mysql($_POST['data']);
    $torn=$this->torn($data,$_POST['hora']);
    
    $this->reg_log("
    ***********************************************************************************
    INICIEM PERMUTA $reserva >> TAULA DESTI >> {$_POST['estat_taula_taula_id']}
    ***********************************************************************************");
    
    $_POST['id_reserva']="";
    
    /**
     * START TRANSACTION
     */
     try{
      ////////////////////////////////
      mysql_query("START TRANSACTION");    
  
      //ELIMINA LA RESERVA DE LA TAULA VELLA
      $query="UPDATE ".T_RESERVES." 
      SET data='$data',
      hora='{$_POST['hora']}',
      adults={$_POST['adults']},
      nens10_14={$_POST['nens10_14']},
      nens4_9={$_POST['nens4_9']},
      cotxets={$_POST['cotxets']},

      observacions='{$_POST['observacions']}',      
      resposta='{$_POST['resposta']}'      
      WHERE id_reserva=$reserva"; 
    
      $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
       $this->reg_log("PERMUTA ($reserva): ACTUALITZO RESERVA (data,hora) >> ".($this->qry_result?"OK":"KO"));
      if (!$result)  return mysql_query("ROLLBACK");     
              
      //ACTUALITZA DADES DE LA RESERVA
      $query="UPDATE ".ESTAT_TAULES." SET reserva_id=0
      WHERE reserva_id=$reserva"; 
      $result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
       $this->reg_log("PERMUTA ($reserva): ELIMINO LA RESERVA DE L'ESTAT ORIGEN >> ".($this->qry_result?"OK":"KO"));
      if (!$result)  return mysql_query("ROLLBACK");     
              
      ////////////////////////////////
      //COMPROVA SI LA TAULA JA TE ESTAT
      $query="SELECT estat_taula_id from estat_taules 
      WHERE estat_taula_data='{$data}' AND estat_taula_torn=$torn 
      AND estat_taula_taula_id={$_POST['estat_taula_taula_id']}"; 
      $result = $this->log_mysql_query($query, $this->connexioDB) or mysql_query("ROLLBACK");
      
       if ($num=mysql_num_rows($result)) {
        ////////////////////////////////
        //SI EL TE, CANVIA LA RESERVA D'UN CAP A L'ALTRE   
        $query="UPDATE ".ESTAT_TAULES." SET reserva_id=$reserva
        WHERE estat_taula_data='{$data}' AND estat_taula_torn={$torn} 
        AND estat_taula_taula_id={$_POST['estat_taula_taula_id']}"; 
        $result = $this->log_mysql_query($query, $this->connexioDB) or mysql_query("ROLLBACK");
       $this->reg_log("PERMUTA ($reserva): HI HA ESTAT EXISTENT >> LI ASSIGNO LA RESERVA".($this->qry_result?"OK":"KO"));
                
        if (!$result)  return mysql_query("ROLLBACK");
        
      }else{
      ////////////////////////////////
      //SI EL TE, CREA UN ESTAT PEL DIA, TORN, TAULA, RESERVA COPIAT DE LA BASE      
        $query="INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
        reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
        
        SELECT '{$data}', estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
        $reserva, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, 
        estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio 
        FROM estat_taules 
        WHERE estat_taula_data='2011-01-01' AND estat_taula_torn=$torn
        AND estat_taula_taula_id={$_POST['estat_taula_taula_id']}";
        
        $result = $this->log_mysql_query($query, $this->connexioDB) or mysql_query("ROLLBACK");
       $this->reg_log("PERMUTA ($reserva): SENSE ESTAT EXISTENT >> CREAT ESTAT AMN RESERVA".($this->qry_result?"OK":"KO"));
                
        if (!$result)  return mysql_query("ROLLBACK");
        }
        
        if ($this->reserves_orfanes()) {
          mysql_query("ROLLBACK");
          //return "ORFANES!!!";
          $resposta['resposta']="ko";
          $resposta['orfanes']="orfanes";
          $resposta['error']="202";
          //$resposta['orfanes']="orfanes";
          
      }
    }catch (Exception $e) {
              mysql_query("ROLLBACK"); 
             $resposta['resposta']="ko";
             $resposta['error']="203";
    }
    
   /**
   * COMMIT
   */   
    mysql_query("COMMIT");
    mysql_query("SET AUTOCOMMIT=1");
    $_POST['id_reserva']=$reserva;
    
    //return $accordion;
    $resposta['resposta']="ok";
    $resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
    $resposta['missatge_dia'] = $this->recupera_missatge_dia();
    $resposta['ac_reserves']=$this->accordion_reserves();
 
     return $this->jsonResposta($resposta);
 }
  
 /****************************************/
/****************************************/
/********   RESERVES ORFANES  *********/
/* Reservs existents a la taula reservestaules
però que no apareixen a estat_taules, és a dir, 
són reserves perdudes que perden el link amb una taula
/****************************************/
/****************************************/
  public function reserves_orfanes()
  {
      $data=date("Y-m-d");
      $query ="SELECT * FROM `reservestaules` WHERE 
       `data` >=  '$data' and
      id_reserva not in
      (
      SELECT reserva_id 
      FROM  `estat_taules` 
      WHERE  `data` >=  '$data'
      and reserva_id>0
      )";
    //echo $query;
       $result=$this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
      $num=mysql_num_rows($result);
      $this->reg_log("TROBADES $num RESERVES ORFANES!!");
      if (!$num)  return false;
      
      $html="
      <table>
        ";
        while ($row=mysql_fetch_assoc($result)){
            $row_cli=$this->load_client($row['client_id']);
            $client=$row_cli['client_nom']." ".$row_cli['client_cognoms']." - ".$row_cli['client_mobil'];
            $comensals=$row['adults']+$row['nens10_14']+$row['nens4_9'];
            $url_repara = $_SERVER['PHP_SELF'].'?a=repara_reserva_orfana&b='.$row['id_reserva'];
            
        $html .="
        <tr>
          ";
          $html.='<td> (id_reserva:'. $row['id_reserva'].') </td>';
          $html.='<td>'.  $row['data'].'</td>';
          $html.='<td> - '.  $row['hora'].'</td>';
          $html.='<td> #'.  $comensals.'</td>';
          $html.='<td> (client_id:'.  $row['client_id'].') </td>';
          $html.='<td>'.  $client.'</td>';
          $html.='<td><a href="'.$url_repara.'">Recuperar reserva</a></td>';
          $html .="
        </tr>";
      
        }
        $html.="      </table>";
        
        return $html;
        
}  


/****************************************/
/****************************************/
/********   LOAD_TAULA_PERMUTA  *********/
/****************************************/
/****************************************/
  public function repara_reserva_orfana($reserva_id)
  {
    $row=$this->load_reserva($reserva_id);
    //print_r($row);
    $time=time();
    $torn=$this->torn($row['data'],$row['hora']);
    
    $query="SELECT reserva_id FROM ".ESTAT_TAULES." 
    WHERE estat_taula_data='{$row['data']}'
    AND estat_taula_torn=$torn
    AND reserva_id=$reserva_id";
    
    
    $res=$this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
    $num=mysql_num_rows($res);
    if ($num){
      echo "Aquesta reserva està correctament vinculada";
      return;
    }

    $insertSQL = sprintf("INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                 $this->SQLVal($row['data'], "datePHP"),
                 $this->SQLVal('!!!!!', "text"),
                 $this->SQLVal($torn, "text"),
                $this->SQLVal($time, "text"),
                 $this->SQLVal($row['id_reserva'], "text"),
                 $this->SQLVal(300, "text"),
                 $this->SQLVal(390, "text"),
                 $this->SQLVal($row['adults']+$row['nens10_14']+$row['nens4_9'], "zero"),
                 $this->SQLVal($row['cotxets'], "zero"),
                 $this->SQLVal(0, "text"),
                 $this->SQLVal(0, "text"),
                 $this->SQLVal($_SESSION['uSer']->id, "text"));
      
      $b=$this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
      $id = mysql_insert_id();
      //$_SESSION['torn']=$torn;

      
    //DELETE REDUNDANTS
      $deleteSQL=sprintf("DELETE FROM ".ESTAT_TAULES."
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s",
       $this->SQLVal($time, "text"),
       $this->SQLVal($row['data'], "datePHP"),
       $this->SQLVal($row['torn'], "text"),
       $this->SQLVal($id, "text"));
      
      $c=$this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
      
      echo "S'ha recuperat la reserva $reserva_id. Ha estat creada una taula el dia {$row['data']} amb nom '!!!!!' ";
      echo $this->reserves_orfanes();
}
  
/****************************************/
/****************************************/
/********   LOAD_TAULA_PERMUTA  *********/
/****************************************/
/****************************************/
  public function load_taula_permuta($id_taula)
  {
    if ($_SESSION['permisos']<16) return "error:sin permisos";

    $filtre="(estat_taula_data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."'  OR estat_taula_data='".$this->data_BASE."') ";
  
  
    $query = "SELECT * FROM ".ESTAT_TAULES."
    WHERE estat_taula_taula_id=$id_taula
    AND $filtre 
    ORDER BY estat_taula_data DESC;
    ";

    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    
    $this->last_row = mysql_fetch_assoc($this->qry_result);
    
    if ($this->total_rows = mysql_num_rows($this->qry_result))  return $this->last_row;
    
    $this->error="Reserva no trobada";
    //$this->mostra_error();
    return false; 
  }
  
/****************************************/
/****************************************/
/********  EXTENDRE_RESERVA    *********/
/****************************************/
/****************************************/
/**/
  public function extendreReserva()
  {
    if ($_SESSION['permisos']<16) return "error:sin permisos";

    
    $torn=$_SESSION['torn'];
    $data = $_SESSION['data'];
    $resid = $_POST['id_reserva'];
    $taulaOrig=0;
    $taulaDesti=$_POST['estat_taula_taula_id'];
    $ret = $_POST['id_reserva']." * $taulaOrig";
    
    
    $query = "SELECT * FROM ".ESTAT_TAULES." 
    WHERE estat_taula_data = '$data'
    AND estat_taula_torn = $torn
    AND reserva_id = $resid
    AND (estat_taula_grup = 0 OR estat_taula_grup = estat_taula_taula_id)";
    
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error()); 
     $row = mysql_fetch_assoc($this->qry_result);
    $taulaOrig=$row['estat_taula_taula_id'];

      $estatSQL = "SELECT * FROM ".ESTAT_TAULES." 
      
      WHERE (estat_taula_data<'$data 23:59:59' 
      AND estat_taula_data>='$data' 
      AND estat_taula_torn=$torn      
      AND estat_taula_taula_id = ".$taulaDesti.")
      OR (estat_taula_data='".$this->data_BASE."' AND estat_taula_taula_id = ".$taulaDesti.")
      
      ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";
      
      
      
      $this->qry_result = mysql_query($estatSQL, $this->connexioDB) or die(mysql_error());
      $row = mysql_fetch_assoc($this->qry_result);
      if (!$row['estat_taula_nom']) $row['estat_taula_nom']=$_POST['estat_taula_taula_id'];
      
    $insertSQL = sprintf("INSERT INTO ".ESTAT_TAULES." ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                 $this->SQLVal($_POST['data'], "datePHP"),
                 $this->SQLVal($row['estat_taula_nom'], "text"),
                 $this->SQLVal($torn, "text"),
                $this->SQLVal($taulaDesti, "text"),
                 $this->SQLVal(0, "text"),
                 $this->SQLVal($row['estat_taula_x'], "text"),
                 $this->SQLVal($row['estat_taula_y'], "text"),
                 $this->SQLVal($row['estat_taula_persones'], "zero"),
                 $this->SQLVal($row['estat_taula_cotxets'], "zero"),
                 $this->SQLVal($taulaOrig, "text"),
                 $this->SQLVal($row['estat_taula_plena'], "text"),
                 $this->SQLVal($_SESSION['admin_id'], "text"));
      
      $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
      $id = mysql_insert_id($this->connexioDB);

      
    //DELETE REDUNDANTS
      $deleteSQL=sprintf("DELETE FROM ".ESTAT_TAULES."
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s",
       $this->SQLVal($taulaDesti, "text"),
       $this->SQLVal($data, "datePHP"),
       $this->SQLVal($torn, "text"),
       $this->SQLVal($id, "text"));
      
      $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
    
      $resposta['resposta']="ok";
     return $this->jsonResposta($resposta);//$query." - ".$row['estat_taula_taula_id'];
  } 
  
  
/****************************************/
/****************************************/
/********   LOAD_RESERVA  *********/
/****************************************/
/****************************************/
  public function load_reserva($id_reserva)
  {
    $query = "SELECT * FROM ".T_RESERVES." 
    LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
    LEFT JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva=".ESTAT_TAULES.".reserva_id
    WHERE ".T_RESERVES.".id_reserva='".$id_reserva."'";
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    
    $this->last_row = mysql_fetch_assoc($this->qry_result);
    
    if ($this->total_rows = mysql_num_rows($this->qry_result))  return $this->last_row;
    
    $this->error="Reserva no trobada";
    return false; 
  }
/****************************************/
/****************************************/
/********   VALIDA_RESERVA  *********/
/****************************************/
/****************************************/
  public function valida_reserva($taula,$data="NO")
  {
    if ($data=="NO") return true;
    if ($data<"2011") return false;
    
    return true;
  }
/****************************************/
/****************************************/
/********   ACCORDION_RESERVES  *********/
/****************************************/
/****************************************/
  public function accordion_reserves($filtre="TRUE",$cerca="")
  {
    if ($_SESSION['permisos'] < 16) {return "error:sin permisos";}
    
    if ($filtre=="TRUE" || empty($filtre)) 
    {
      if (!isset($_SESSION))   session_start();
      switch($_SESSION['modo'])
      {
        case 3://FUTUR
          $filtre="data>='".$_SESSION['data']."' ";
        break;
        case 4://TOT
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
        break;
        
        case 5://NOMES ESBORRADES
        case 6://ESBORRADES + TOTES
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
          $bdDel="canborrell_del.";
        break;
        
        case 2://DIA
          $filtre="data='".$_SESSION['data']."' ";
        break;
        
        default:
        case 1://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' ";
        break;
      }
    }
    

  $html="";
    $query = "SELECT 
	id_reserva,
	estat_taula_nom,
	estat_taula_taula_id,
	data,
	hora,
	nens4_9,
	nens10_14,
	adults,
	cotxets,
	observacions,
	client.client_id,
	client_nom,
	client_cognoms,
	client_email,
	
	client_mobil,
	client_conflictes,
	reserva_info,
	
	0 AS deleted FROM ".T_RESERVES." 
    LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
    INNER JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva = ".ESTAT_TAULES.".reserva_id
    WHERE $filtre ";
    
    $query.="ORDER BY client_cognoms, data , hora , data_creacio";
    
   
    if (isset($cerca) && !empty($cerca) && $cerca != "" && $cerca != "undefined" && $cerca != "null" && $cerca != "CERCA...") 
      $query=$this->qryCercaReserva($cerca, $filtre);

    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());   
    if (!$this->total_rows = mysql_num_rows($this->qry_result)) {
        $html="<h3>No hi ha reserves</h3>";
        $resposta['0']=$html;
    }
    /** TODO si en troba més d'una */
    $n = 0; 
    while ($row= $this->last_row = mysql_fetch_assoc($this->qry_result))
    {
      if ($row['estat_taula_id']>0) 
      {
        $taules='<span class="retol_info">Taula:</span> <span class="taules">'.$row['estat_taula_nom'].'</span><br/>';
      }
      
      if ($row['client_id'] <= 0) //SI FALTA CLIENT POSA "NO DEFINIT"
      {
        $row["client_id"]=1;
        $row["client_cognoms"]="Client NO DEFINIT";
      }
      
      $idr = $row['id_reserva'];
      $torn=$this->torn($row['data'],$row['hora']);
      $comensals=$row['adults']+$row['nens10_14']+$row['nens4_9'];
      if (empty($row['client_email'])) $row['client_email']="";
      if (empty($row['client_conflictes'])) $row['client_conflictes']="";
          
      $deleted = $row['deleted']?' style="background:red" ':'';
      $obs=trim($row['observacions']);
      if (!empty($obs))
      {
       $sobret=($row['reserva_info'] & 16?"ui-icon-mail-open":"ui-icon-mail-closed");
      }
      else $sobret="";
      
      $es_online=$row['reserva_info'] & 1;
      $online=$es_online?'<div class="online" title="Reserva ONLINE">'.$sobret.'</div>':'';
      
      
      if ($row['client_nom']=="SENSE_NOM") $row['client_nom']="";
      $nom="<br/>".substr($row['client_cognoms'].", ".$row['client_nom'],0,25);
      

		$row['sobret'] =$sobret;
		$row['data_es'] =$this->cambiaf_a_normal($row['data'],"%d/%m");
		$row['torn'] = $torn;
		$row['comensals'] = $comensals;
		$row['online']=$es_online;
		$row['nom']=$nom;
		$row['total_reserves']=$this->total_rows;
		
		unset($row['cognoms']);
		unset($row['reserva_info']);
		unset($row['deleted']);
		unset($row['observacions']);
		
		//$resposta[$idr] = $row;
		$resposta[$n] = $row;
		
		$n++;
    }
    
	return $resposta;
  }
 
  public function cerca_reserves($filtre="TRUE",$cerca=""){
      $resposta['ac_reserves']=$this->accordion_reserves($filtre,$cerca);
      return $this->jsonResposta($resposta);
  }
  
  public function qryCercaReserva($cerca, $filtre)
  {
      if ($_SESSION['permisos']<16) return "error:sin permisos";

      $bbdd="canborrell.";
      
      //echo $filtre." / ".$_SESSION['modo'];
      if ($filtre=="TRUE" || empty($filtre)) 
      {
        if (!isset($_SESSION))   session_start();
        switch($_SESSION['modo'])
        {
          case 1://AVUI + TORN
            $filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' ";
          break;
          case 3://FUTUR
            $filtre="data>='".$_SESSION['data']."' ";
          break;
          case 4://TOT
            $filtre="TRUE ";
          break;
    
          case 5://NOMES ESBORRADES
          case 6://ESBORRADES + TOTES
            $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
            $bdDel="canborrell_del.";
          break;
        

    
          case 2://DIA
          default:
            $filtre="data='".$_SESSION['data']."' ";
          break;
        }
      }
      
  $query = "SELECT *,0 AS deleted FROM ".T_RESERVES." 
      LEFT JOIN "."client ON ".T_RESERVES.".client_id=client.client_id
      LEFT JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva = ".ESTAT_TAULES.".reserva_id 
      
      WHERE  (
      reserva_id LIKE '%$cerca%' OR
      client_cognoms LIKE '%$cerca%' OR
      client_nom LIKE '%$cerca%' OR
      CONCAT (client_nom,' ',client_cognoms) LIKE '%$cerca%' OR
      CONCAT (client_cognoms,', ',client_nom) LIKE '%$cerca%' OR
      client_telefon LIKE '%$cerca%' OR
      client_mobil LIKE '%$cerca%' OR
      client_email LIKE '%$cerca%'
      )
      AND estat=100 AND ".T_RESERVES.".client_id>0 AND $filtre 

      ";
    $order=" ORDER BY data DESC, hora DESC, data_creacio DESC";
    //echo $query;
    return $query.$order;
    //return $this->charset($query.$order);
  }

  
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/********   PRINT LLISTA RESERVES  *********/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/****************************************/
/****************************************/
/****************************************/
/****************************************/
  public function print_llista_reserves($filtre="TRUE",$cerca="")
  {
    if ($_SESSION['permisos'] < 16) return "error:sin permisos";
   
    $class="torn";
    
    if ($filtre=="TRUE" || empty($filtre)) 
    {
      if (!isset($_SESSION))   session_start();
  //echo "**$filtre**".$_SESSION['modo'];
      //$modo=$_SESSION['modo'];
      $modo=1;
      switch($modo)
      {
        case 1://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' ";
        break;
        case 3://FUTUR
          $filtre="data>='".$_SESSION['data']."' ";
        break;
        case 4://TOT
          $filtre="TRUE ";
        break;
        
        case 2://DIA
        default:
          $filtre="data='".$_SESSION['data']."' ";
        break;
      }
    }
    else
    {
       switch($filtre)
      {
        case "DIA_TORN"://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' ";
        break;
        case "DIA_TORN1"://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn=1 AND hora<'15:00'";
          $class="torn1";
                  break;
        case "DIA_TORN2"://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn=1 AND hora>='15:00'";
          $class="torn2";
                  break;
        case "FUTUR"://FUTUR
          $filtre="data>='".$_SESSION['data']."' ";
        break;
        case "TOT"://TOT
          $filtre="TRUE ";
        break;
        
        case "SETMANA"://SETMANA
          $filtre=" data>='".$_SESSION['data']."' AND data<=DATE_ADD('".$_SESSION['data']."',INTERVAL 7 DAY)";
        break;
        
        case "MES"://MES
          $filtre="data>='".$_SESSION['data']."' AND data<=DATE_ADD('".$_SESSION['data']."',INTERVAL 1 MONTH)";
        break;
        
        case 2://DIA
        default:
          $filtre="data='".$_SESSION['data']."' ";
        break;
      }
    
    
    }
    $data=$_SESSION['data'];
    $query="SELECT * FROM missatge_dia WHERE missatge_dia_data='$data'";
    
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    $row= $this->last_row = mysql_fetch_assoc($this->qry_result);
    $html='<h5>'.$row['missatge_dia_text'].'</h5>';
    
    $query = "SELECT *, (adults + nens10_14 + nens4_9) AS sm 
    FROM ".T_RESERVES." 
    LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
    INNER JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva=".ESTAT_TAULES.".reserva_id
    WHERE ".T_RESERVES.".client_id>0 AND $filtre 
    ORDER BY data , estat_taula_torn , sm , hora , client.client_cognoms, data_creacio    ";
    
    if (isset($cerca) && !empty($cerca) && $cerca != "" && $cerca != "undefined" && $cerca != "null") 
      $query=$this->qryCercaReserva($cerca, $filtre);

    $result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    if (!$total=$this->total_rows = mysql_num_rows($result)) $html.="No hi ha reserves";
    /** TODO si en troba més d'una */
    $n=0;
    $html.='          <div class="dreta">
            <table cellspacing="0" cellpadding="0" class="'.$class.'">
              <tr class="taulaf1">
                <td><b>Total</b></td>
                <td><b>Cotxets</b></td>
                <td><b>J&uacute;nior</b></td>
                <td><b>Infantil</b></td>
                <td><b>Hora</b></td>
                <td><b>Taula</span></b></td>
                <td class="columna-nom"><b>Nom</b></td>
                <td><b>ID</b></td>
              </tr>
';

    while ($row= $this->last_row = mysql_fetch_assoc($result))
    {
      if ($row['estat_taula_id']>0)
      {
        $taules='<span class="retol_info">Taula:</span> <span class="taules">'.$row['estat_taula_taula_id'].'</span>';
      }
      
      $online=($row['reserva_info'] & 1)?"online":"in-situ";
      $hora_15=($row['hora']>="15:00")?"hora-15":"hora-mati";
      
      $torn=$this->torn($_SESSION['data'],$row['hora']);
      $torn='<span class="taules"> '.$torn.'</span>';
      $row['client_nom']= ", " . $row['client_nom'];
            if ($row['client_nom']==", SENSE_NOM") $row['client_nom']="";
            if ($row['client_nom']==",  ") $row['client_nom']="";
      $nom=strtoupper(substr($row['client_cognoms'].$row['client_nom'],0,25));
      $total=$row['nens4_9']+$row['nens10_14']+$row['adults'];
      $par=($n & 1)?"odd":"even";
      
      //$comanda=$this->plats_comanda($row['id_reserva']);
      //$amagat = empty($row['observacions'])?" amagat":" mostrat";
      $comanda=$this->plats_comanda($row['id_reserva']);
      $saltaobs = empty($row['observacions'])?"":"<br/>";
      $amagat=" amagat";
      
      if ($n==11 && false) 
      {
        $html.='
                <td><b>Total</b></td>
                <td><b>Cotxets</b></td>
                <td><b>J&uacute;nior</b></td>
                <td><b>Infantil</b></td>
                <td><b>Hora</b></td>
                <td><b>Taula</span></b></td>
                <td class="columna-nom"><b>Nom</b></td>
                <td><b>ID</b></td>
              </tr>
        
        <div class="pageBreak"> &nbsp; </div>';
        $n=0;
      }
      $n++;
      
      $html .= <<< EOHTML
                    <tr class="taulaf2 {$par}">
                <td class="contador"><b>{$total}</b></td>
                <td class="contador">{$row['cotxets']}</td>
                <td class="contador">{$row['nens10_14']}</td>
                <td class="contador">{$row['nens4_9']}</td>
                <td class="td-hora {$hora_15} {$online}"><b  class="xx-print-taula">{$row['hora']}</b></td>
                <td><span class="print-taula">{$row['estat_taula_nom']}</span></td>
                <td><b>{$nom} - {$row['client_mobil']} <span class="garjola">{$row['client_conflictes']}</span></b>
                {$saltaobs}<em>{$row['observacions']}</em><span>{$comanda}</span></td>
                <td>{$row['id_reserva']}</td>
              </tr>
              <tr  class="observacions {$par} {$amagat}"><td colspan="11">&nbsp;{$row['observacions']}</td></tr>
      
EOHTML;

    }
    $html.='</table> </div>   
<div style="clear:both;"></div> </div>';
    //print_r($row);
    return $html;
    
    
  
  }
  
  
  
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/********   CLIENTS  *********/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/


  public function autocomplete_reserves($q)
  {
      
      if (isset($_SESSION['order'])) $order="ORDER BY client_cognoms";
      $order=$_SESSION['llista_reserves_order']?("ORDER BY ".$_SESSION['llista_reserves_order']):"ORDER BY client_cognoms";
      
      
      switch($_SESSION['modo'])
      {
        case 3://FUTUR
          $filtre="data>='".$_SESSION['data']."' ";
        break;
        case 4://TOT
          $filtre="TRUE ";
        break;
        
        case 5://NOMES ESBORRADES
        case 6://ESBORRADES + TOTES
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
          $bdDel="canborrell_del.";
        break;
        
        case 2://DIA
          $filtre="data='".$_SESSION['data']."' ";
        break;
        
        default:
        case 1://AVUI + TORN
          $filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' ";
        break;
      }
      
      if (is_numeric($q) && $q>5000 && $q<99999) $q="ID".$q;
      $were="WHERE $filtre "; 

      $query = "SELECT * 
      FROM ".T_RESERVES." 
      LEFT JOIN ".ESTAT_TAULES." ON reserva_id=id_reserva
      LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
      $were 
      AND
      (
        CONCAT('ID',id_reserva) = '$q' OR
        id_reserva = '$q' OR
        client_nom LIKE '%$q%' OR
        client_cognoms LIKE '%$q%' OR
        CONCAT(client_nom,' ',client_cognoms) LIKE '%$q%' OR
        CONCAT(client_cognoms,', ',client_nom) LIKE '%$q%' OR
        CONCAT(client_cognoms,' ',client_nom) LIKE '%$q%' OR
        client_conflictes LIKE '%$q%' OR
        observacions LIKE '%$q%'        
      )
      ";
      
      $query.=$order;
      $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
      $this->total_rows = mysql_num_rows($this->qry_result);

      while ($this->last_row = $row = mysql_fetch_assoc($this->qry_result)) 
      {
      
        
        $key=$row['client_cognoms'].", ".$row['client_nom'].", ".$row['id_reserva'].", ".$row['estat_taula_taula_id']." (".$row['client_mobil']." - ".$row['client_telefon'].")";
        $key2=$row['client_cognoms'].", ".$row['client_nom'];
        $value=$row['client_id'];
          
        $reserves.= "$key2|$value\n";
      }
      return $reserves;
  }

/****************************************/
/****************************************/
/****************************************/
/****************************************/
/********   COMBO_CLIENTS  *********/
/****************************************/
/****************************************/
  public function combo_clients($client_id=-1)
  {
    if ($client_id<1) $client_id=mysql_insert_id();
      //$this->connectaBD();  
    $query = "SELECT * FROM client ORDER BY client_cognoms";
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    $this->last_row = mysql_fetch_assoc($this->qry_result);
    $this->total_rows = mysql_num_rows($this->qry_result);

    $options='<select  class="combo_clients {required:true,min:1}" name="client_id" style="width:495px"  title="Selecciona un client">
        <option value="0">---------  client  ---------</option>';
    do 
    {  
      $row_client=$this->last_row;
      
      $sel=((int)$row_client['client_id']==(int)$client_id)?' selected="selected"':"";    
      $options.='
      <option value="'. $row_client['client_id'].'" '.$sel.'>'.
        $row_client['client_cognoms'].', '.$row_client['client_nom'] .
      '</option>';
    } while ($this->last_row = mysql_fetch_assoc($this->qry_result));
    $options.='</select>';
    $options.='<div class="dades_client">';
    $options.=$this->htmlDadesClient($client_id);
    $options.='</div>';
    //$options.='<input id="autoc_client">';
    return $options;
  }
/****************************************/
/****************************************/
/********   HTML_DADES_CLIENTS  *********/
/****************************************/
/****************************************/
  public function htmlDadesClient($client_id=0)
  {
    if ($client_id<1) return '';
    if ($client_id<1) return 'Selecciona client o crea\'n un:';
    
    $query = "SELECT * FROM client 
    WHERE client_id=$client_id
    ORDER BY client_cognoms";
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    $row_client=$this->last_row = mysql_fetch_assoc($this->qry_result);
    $this->total_rows = mysql_num_rows($this->qry_result);
    
    if ($this->total_rows<1) return "No hi ha clients";
    $body=$this->mail_body();
    $options.='<a href="mailto:'.$row_client['client_email'].'?subject=Reservas Can Borrell&amp;body='.$body.'">'.$row_client['client_email'].'</a><br/>';
    $options.=$row_client['client_mobil'].' / '.$row_client['telefon'].'<br/>';
    $options.='<span class="conflicte">'.$row_client['client_conflictes'].'</span><br/>';
    $options.='<input type="hidden" id="num_mobil" value="'.$row_client['client_mobil'].'"/>';
    return $options;
  }
  
/****************************************/
/****************************************/
/********   ESBORRA_CLIENT  *********/
/****************************************/
/****************************************/
  public function esborra_client($client_id)
  {
    if ($client_id <1 ) return false;
    
    $comprovaSQL="SELECT * FROM client 
LEFT JOIN ".T_RESERVES." ON ".T_RESERVES.".client_id=client.client_id
WHERE data >= DATE_SUB(NOW(), INTERVAL 1 DAY)
AND client.client_id='$client_id'";
      $this->qry_result = mysql_query($comprovaSQL, $this->connexioDB) or die(mysql_error());  
      if (mysql_num_rows($this->qry_result)) return "NO POTS ESBORRAR UN CLIENT AMB RESERVES FUTURES";
    
      $deleteSQL = "DELETE FROM client WHERE client_id=$client_id";
      $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(mysql_error());
    
     if (!isset($_REQUEST['a']))  header("Location: ".$_SERVER['PHP_SELF']);
     return $this->accordion_clients();
  }
/****************************************/
/****************************************/
/********   INSERTA_CLIENT  *********/
/****************************************/
/****************************************/
  public function inserta_client()
  { 
    if (empty($_REQUEST['client_mobil']) || empty($_REQUEST['client_cognoms']) || empty($_REQUEST['client_nom'])) return false;
    
    $unic="SELECT client_id FROM client WHERE client_mobil<>'999999999' AND client_mobil='".$_POST['client_mobil']."'";
    $this->qry_result = mysql_query($unic, $this->connexioDB) or die(mysql_error());
    $nr = mysql_num_rows($this->qry_result);
    //die ()
    if ($nr) 
    {
      return $this->controlClient($_REQUEST['client_id'], $_REQUEST['client_mobil']); 
    }
    if ($_REQUEST['client_nom']=="SENSE_NOM") $_REQUEST['client_nom']=" ";
    $insertSQL = sprintf("INSERT INTO client (client_nom, client_cognoms, client_adresa, 
      client_localitat, client_cp, client_dni, client_telefon, client_mobil, client_email, client_conflictes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                 $this->SQLVal($_REQUEST['client_nom'], "text"),
                 $this->SQLVal($_REQUEST['client_cognoms'], "text"),
                 $this->SQLVal($_REQUEST['client_adresa'], "text"),
                 $this->SQLVal($_REQUEST['client_localitat'], "text"),
                 $this->SQLVal($_REQUEST['client_cp'], "text"),
                 $this->SQLVal($_REQUEST['client_dni'], "text"),
                 $this->SQLVal($_REQUEST['client_telefon'], "text"),
                 $this->SQLVal($_REQUEST['client_mobil'], "text"),
                 $this->SQLVal($_REQUEST['client_email'], "text"),
                 $this->SQLVal($_REQUEST['client_conflictes'], "text"));
// echo $insertSQL;
                 
      $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(mysql_error());
//if (!isset($_REQUEST['a']))  header("Location: ".$_SERVER['PHP_SELF']);
     
     $id=mysql_insert_id();
     return $id;
  }

  
/****************************************/
/****************************************/
/********      controlClient     ************/
/****************************************/
/****************************************/
  public function controlClient($client_id, $client_mobil)
  {
    // SI ES PERMUTA O EXTEN
    if (isset($client_mobil) && (!$client_id || $client_id == "#"))
    { 
      //echo "P1: ".$client_id." / ".$client_mobil.PHP_EOL;
      $query="SELECT client_id FROM client WHERE client_mobil='$client_mobil'";
      $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
      
      if (!mysql_num_rows($this->qry_result) || $client_mobil == "999999999")
      // SI NO EXISTEIX EL CREA
      {
      //echo "P2: ".$client_id." / ".$client_mobil.PHP_EOL;
        $_POST['client_id'] = $client_id = $this->inserta_client();
        $this->reg_log("CREAT CLIENT: $client_id - ".$_POST['client_cognoms']." - $client_mobil");
      }
      else
      // SI EXISTEIX, ACTUALITZA VALORS
      {
      //echo "P3: ".$client_id." / ".$client_mobil.PHP_EOL;
        $_POST['client_id'] = $client_id = mysql_result($this->qry_result, 0, client_id);
        $updateSQL = sprintf("UPDATE client SET  client_cognoms=%s, client_nom=%s,  client_telefon=%s, client_conflictes=%s, client_email=%s
                WHERE client_id=%s",
                 $this->SQLVal($_POST['client_cognoms'], "text"),
                 $this->SQLVal($_POST['client_nom'], "text"),
                 $this->SQLVal($_POST['client_telefon'], "text"),
                 $this->SQLVal($_POST['client_conflictes'], "text"),
                 $this->SQLVal($_POST['client_email'], "text"),
                 $this->SQLVal($client_id, "text"));

      $this->qry_result = $this->log_mysql_query($query, $this->connexioDB) or die(mysql_error());
        
        $this->reg_log("CLIENT EXISTENT: $client_id - ".$_POST['client_cognoms']." - $client_mobil");
      }
    }
    
    return $client_id;
  }
/****************************************/
/****************************************/
/********      UPDATE_CLIENT     ************/
/****************************************/
/****************************************/
  public function update_client()
  {
      $updateSQL = sprintf("UPDATE client SET  client_id=%s, client_nom=%s, client_cognoms=%s, client_adresa=%s, client_localitat=%s,
      client_cp=%s,   client_dni = %s, client_telefon = % s, client_mobil = %s, client_email = %s, client_conflictes=%s WHERE client_id=%s",
                 $this->SQLVal($_POST['client_id'], "text"),
                $this->SQLVal($_POST['client_nom'], "text"),
                 $this->SQLVal($_POST['client_cognoms'], "text"),
                 $this->SQLVal($_POST['client_adresa'], "text"),
                 $this->SQLVal($_POST['client_localitat'], "text"),
                 $this->SQLVal($_POST['client_cp'], "text"),
                 $this->SQLVal($_POST['client_dni'], "text"),
                 $this->SQLVal($_POST['client_telefon'], "text"),
                 $this->SQLVal($_POST['client_mobil'], "text"),
                 $this->SQLVal($_POST['client_email'], "text"),
                 $this->SQLVal($_POST['client_conflictes'], "text"),
                 $this->SQLVal($_POST['client_id'], "text"));
    $this->qry_result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(mysql_error());
     if (!isset($_REQUEST['a']))  header("Location: ".$_SERVER['PHP_SELF']);
     //return $this->accordion_clients();
     
         $resposta['resposta']="ok";
   // $resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
    //$resposta['missatge_dia'] = $this->recupera_missatge_dia();
    //$resposta['add_reserva']=$this->accordion_reserves("id_reserva=".$idr);
    $resposta['ac_reserves']=$this->accordion_reserves();
    return $this->jsonResposta($resposta);
  
  }
/****************************************/
/****************************************/
/********   LOAD_CLIENT  *********/
/****************************************/
/****************************************/
  public function load_client($client_id, $json=false)
  {
    $query = "SELECT * FROM client 
    LEFT JOIN llista_negra ON (llista_negra_mobil=client_mobil OR llista_negra_mail=client_email)
    WHERE client.client_id='".$client_id."'";
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
    
    $this->last_row = mysql_fetch_assoc($this->qry_result);   
    if ($this->total_rows = mysql_num_rows($this->qry_result) && $json) 
    {
      $this->last_row['jsonid'] = $_POST['id'];
      
      //foreach($this->last_row as $k=>$v) $this->last_row[$k]=utf8_encode($v);
      
      echo json_encode($this->last_row);
      return ;
    }
    if ($this->total_rows = mysql_num_rows($this->qry_result))  return $this->last_row;
    
    $this->error="Client no trobat";
    //$this->mostra_error();
    return false;
  }
  
  public function cadenaClient($id)
  {
    if (!$id) return "SENSE DADES";
    if ($row=$this->load_client($id)) return '('.$row['client_id'].') '.$row['client_nom'].' '.$row['client_cognom'];
    return '(ADMIN) '.$this->usuari($id);   
  }
/****************************************/
/****************************************/
/********   ACCORDION_CLIENTS  *********/
/****************************************/
/****************************************/
  public function accordion_clients($filtre=0,$cerca="")
  {
    switch ($filtre)
    {
      case 1:
       $were=" WHERE ".T_RESERVES.".id_reserva>0 AND data='".$_SESSION['data']."' AND estat_taula_torn=".$_SESSION['torn'];
      break;
      case 2:
       $were=" WHERE ".T_RESERVES.".id_reserva>0 AND data='".$_SESSION['data']."'";
      break;
      
      case 4:
      break;
      
      case 3:
      default:
       $were=" WHERE TRUE";
      

    }
    $query = "SELECT DISTINCT estat_taula_torn, estat_taula_taula_id, client.client_id AS client_client_id, 
        client_nom,client_cognoms,client_email,client_telefon,client_mobil, ".T_RESERVES.".id_reserva, ".T_RESERVES.".data, ".T_RESERVES.".hora,
        data>=NOW() AS reservat
        
FROM client 
LEFT JOIN ".T_RESERVES." ON ".T_RESERVES.".client_id = client.client_id AND ".T_RESERVES.".data >= '".$_SESSION['data']."' 
LEFT JOIN ".ESTAT_TAULES." ON ".ESTAT_TAULES.".reserva_id=".T_RESERVES.".id_reserva
$were 
ORDER BY client_cognoms, data";

    if (!empty($cerca) && $cerca != "undefined" && $cerca != "Cerca..." && $cerca != "CERCA...") 
      $query=$this->qryCercaClient($cerca, $filtre);

    $html="";
    $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());   
    if (!$this->total_rows = mysql_num_rows($this->qry_result)) $html = "<h3>No hi ha clients</h3>";
    
        $id = mysql_insert_id();
    $m=0;
    while ($row= $this->last_row = mysql_fetch_assoc($this->qry_result))
    {
      if ($row['client_mobil'] == "999999999" || $row['client_mobil'] == "000000000" || $row['client_mobil'] == "000000001")
        $row['client_mobil']="Sense n&uacute;mero";
    
      $reservat="";
      $reserva="";
      if ($row['id_reserva']) 
      {
        if ($row['reservat']) $reservat='<span class="reservat">R </span>';
        $data=$this->cambiaf_a_normal($row['data']);
        $reserva='<a href="form_reserva.php?edit='.$row['id_reserva'].'&id='.$row['id_reserva'].'" class="taules fr" taula="'.$row['estat_taula_taula_id'].'" title="detall reserva" data="'.$data.'">('.$row['id_reserva'].") | ".$data." | ".$row['hora'].' |T'.$row['estat_taula_taula_id'].'</a>';
        $delete="";
      }
      else
      {
        $delete='<div class="delete client ui-state-default ui-corner-all"><a href="taules.php?del_client='.$row['client_client_id'].'" del="'.$row['client_client_id'].'">Elimina</a></div>';
      }
      
      if ($id > 0 && $row['client_client_id'] == $id) $insert = 'insert="'.$id.'"'; 
      else $insert='we="'.$row['client_client_id'].'"';
      
      $body = $this->mail_body($row['data'], $row['hora']);
	  
      $m++;
	  
	  $row['data_es'] = $data;
	  $row['reservat'] = $reservat;
	  
	  //$resposta[$row['id_reserva']] = $row;
	  $resposta[$m] = $row;
    } 
	
	return $resposta;
   // return $html; 
  } 
  
  
/****************************************/
/****************************************/
/********   qryCercaClient  *********/
/****************************************/
/****************************************/
  
  public function qryCercaClient($cerca, $filtre=null)
  {
        $mob=explode("tel:",$cerca);
        $mob=$mob[1];
        $mob=explode("(",$mob);
        $mob=$mob[0];
        
      $query = "SELECT DISTINCT 
      client.client_id AS client_client_id, 
      client.*, 
      ".T_RESERVES.".id_reserva,
      ".T_RESERVES.".data,
      ".T_RESERVES.".hora,
      data>NOW() AS reservat, 
      estat_taula_taula_id
      
      FROM client 
      LEFT JOIN ".T_RESERVES." ON ".T_RESERVES.".client_id = client.client_id AND ".T_RESERVES.".data >='$filtre'
      LEFT JOIN ".ESTAT_TAULES." ON ".ESTAT_TAULES.".reserva_id = id_reserva AND ".T_RESERVES.".data >='$filtre'

      WHERE 
      client_mobil = '$mob' 
      ORDER BY client_cognoms, data DESC";
    return $query;
  }
  
/***************************************/
/***************************************/
/**********   AUTOCOMPLETE  ************/
  public function autocomplete_clients($q,$p)
  {
      if (is_numeric($q) && $q>2000 && $q<99999) $q="ID".$q;
      $query = "SELECT DISTINCT 
      client.client_id, 
      client_nom, 
      client_cognoms, 
      client_mobil, 
      client_conflictes  
      
      FROM client 
      LEFT JOIN ".T_RESERVES." ON client.client_id=".T_RESERVES.".client_id 
      
      WHERE 
      CONCAT('ID',id_reserva) = '$q' OR
      id_reserva LIKE '%$q%' OR
      client.client_id LIKE '%$q%' OR
      client_cognoms LIKE '%$q%' OR
      client_nom LIKE '%$q%' OR
      CONCAT(client_nom,' ',client_cognoms) LIKE '%$q%' OR
      CONCAT(client_cognoms,', ',client_nom) LIKE '%$q%' OR
      CONCAT(client_cognoms,' ',client_nom) LIKE '%$q%' OR
      client_mobil LIKE '%$q%' OR
      client_conflictes LIKE '%$q%'

      ORDER BY client_cognoms";
    
      $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
      $this->total_rows = mysql_num_rows($this->qry_result);

      $clients0="+++ Nou client (".strtoupper($q).")|$q\n";
      while ($row = mysql_fetch_assoc($this->qry_result)) 
      {
        $br = array("<br>", "<br/>","\n","\r");
        $row['client_conflictes']=str_replace($br,"",$row['client_conflictes']);
        if (!empty($row['client_conflictes'])) 
          $conflictes='***['.$row['client_conflictes'].']*** ';
        else $conflictes="";

        $key="(".$row['client_id'].") ".$conflictes.$row['client_nom']." ".$row['client_cognoms']." tel:".$row['client_mobil'];
        $value=$row['client_id'];

        $q_normal=Gestor::normalitzar($q);
        $key_normal=Gestor::normalitzar($key);
        
        $clients.= "$key|$value\n";
      }
      if (empty($clients)) $clients=$clients0;
      return $clients;
  }


/****************************************/
/****************************************/
/********   clientHistoric  *********/
/****************************************/
/****************************************/
  
  public function clientHistoric($client_id)
  { 
      if (!$client_id) return false;
      
      $query = "SELECT * FROM ".T_RESERVES." 
      INNER JOIN ".ESTAT_TAULES." ON ".T_RESERVES.".id_reserva = ".ESTAT_TAULES.".reserva_id
      WHERE client_id = $client_id 
      ORDER BY data DESC
      ";
      
      $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
      
      $s = " </td><td> ";
        $tds.= "<thead><td>id_reserva $s data $s hora $s adults $s nens10_14 $s nens4_9 $s cotxets $s conflictes</td></thead>\n\n";
      while ($row = mysql_fetch_array($Result1))
      {
        $odd = (($k++ % 2)?"odd":"");
        
        if ($row['data']>date("Y-m-d")) $odd.=" futur";
        $tds.= "<tr class='$odd'><td><a href='form_reserva.php?edit=".$row["id_reserva"]."&id=".$row["id_reserva"]."' taula='".$row['estat_taula_taula_id']."' class='fr'>".$row['id_reserva'].$s.$this->cambiaf_a_normal($row['data']).$s.$row['hora'].$s.$row['adults'].$s.$row['nens10_14'].$s.$row['nens4_9'].$s.$row['cotxets'].$s.$row['client_conflictes']."</a> </td></tr>\n\n";
      }
      return "<table>$tds</table>";
  }


/****************************************/
/****************************************/
/********   REFRESH  *********/
/****************************************/
/****************************************/
  
  public function refresh($update=false)
  {     
      session_set_cookie_params(3600 * 24 * 7);
      if (!isset($_SESSION)) session_start(); //REDUNDANT, PERO CADUCA!!!
      
      if (!isset($_SESSION['refresh'])) $_SESSION['refresh']='2010-01-01';
      $data=$_SESSION['data'];
      $data_refresh=$_SESSION['refresh'];
      //return ($data_refresh);
      
      $data_BASE = $this->data_BASE;
      $query = "SELECT * FROM ".ESTAT_TAULES."
      WHERE (
  estat_taula_data = '$data'
  AND estat_taules_timestamp > '$data_refresh'
  )
  OR (
  estat_taula_data = '$data_BASE'
  AND estat_taules_timestamp > '$data_refresh'
  )
  ORDER BY estat_taules_timestamp DESC";
      
      $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
      
      
      if (mysql_num_rows($Result1 ))  
      {
        $row = mysql_fetch_array($Result1);
        $_SESSION['refresh'] = $row['estat_taules_timestamp'];
        
        if ($update) //return "no_change$data_refresh"; 
        //return "refresh";
            {
          $resposta['ok']="ok";
          $resposta['no_change']=$data_refresh;
          return $this->jsonResposta($resposta);
         }

        return $this->canvi_data();
      }
      else //return "no_change$data_refresh";
      {
          $resposta['ok']="ok";
          $resposta['no_change']=$data_refresh;
          return $this->jsonResposta($resposta);
      }
  }
  
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/********   FUNCIONS  *********/
/*****************************************************************************************************************/
/*****************************************************************************************************************/


/*********************************************************************************************************************************/ 
/*********   guarda_missatge_dia   **********************************************************************************/  
/*********************************************************************************************************************************/ 
  public function guarda_missatge_dia($text="",$c)
  {
    if (!isset($_SESSION))   session_start();
    $data=$_SESSION['data'];
    $torn = $_SESSION['torn'];
    $text=mysql_real_escape_string($text);
    
    $query = "DELETE FROM missatge_dia 
    WHERE missatge_dia_data='$data'";
    $Result1 = $this->log_mysql_query($query,  $this->connexioDB) or die(mysql_error());


    $query = "INSERT INTO missatge_dia (missatge_dia_data, missatge_dia_torn, missatge_dia_text) VALUES ('$data','$torn','$text')";
//return $query;


    $Result1 = $this->log_mysql_query($query,  $this->connexioDB) or die(mysql_error());
return stripslashes($text);
  }
/*********************************************************************************************************************************/ 
/*********  recupera_missatge_dia   **********************************************************************************/ 
/*********************************************************************************************************************************/ 
  public function recupera_missatge_dia($data=null,$torn=null)
  {
    if (!isset($_SESSION))   session_start();
    if (!$data) $data=$_SESSION['data'];    
    $torn = $_SESSION['torn'];
  
    $query = "SELECT * FROM missatge_dia 
    WHERE missatge_dia_data='$data'
    ORDER BY missatge_dia_id DESC";
    $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
    if (!mysql_num_rows($Result1)) return;
    $row = mysql_fetch_array($Result1);
    
    return stripslashes($row['missatge_dia_text']);
return $query;
  }
   
 /*********************************************************************************************************************************/ 
  public function prepara_insert_dialog($taula_id=null , $persones=null,$cotxets=0)
  {
    if ($this->taula_bloquejada($taula_id)) {
      $resposta['resposta']='ko';
      $resposta['error']=201;
    }
    else{
      $this->bloqueig_taula($taula_id,$_SESSION['data'],$_SESSION['torn']);
      $resposta['resposta']='ok';
      $resposta['hores']=$this->recupera_hores($taula_id,$persones,$cotxets);
    }
    
    return $this->jsonResposta($resposta);
  }  
    
/*********************************************************************************************************************************/ 
  public function recupera_hores($idr_o_taula=null , $persones=null,$cotxets=0)
  {
    $torn=$_SESSION['torn'];
    $mydata=$_SESSION['data'];
  
    //$this->reset();
    $this->taulesDisponibles->tableHores="estat_hores";
    $this->taulesDisponibles->tableMenjadors="estat_menjador";
    
    $this->taulesDisponibles->data=$mydata;//echo "nem...$mydata - $torn ".BR.BR;
    $this->taulesDisponibles->torn=$torn;
    $this->taulesDisponibles->persones=$persones;
    $this->taulesDisponibles->cotxets=$cotxets;     
    
    
    
    //////////////////////////////////////////////////////////////////////////////
    // Si ens passen $idr pro no persones, vol dir que estem editant una RESERVA
    //////////////////////////////////////////////////////////////////////////////
    if(!$persones && !$cotxets && $idr_o_taula)  
    {
      $this->taulesDisponibles->loadReserva($idr_o_taula);
    }
    //////////////////////////////////////////////////////////////////////////////
    // Si ens passen $idr pro i també persones, vol dir que estem creant una 
    // reserva per una TAULA concreta.
    //////////////////////////////////////////////////////////////////////////////
    elseif ($persones && $idr_o_taula)// NOVA RESERVA, SEBEM LA TAULA I LES PERSONES
    {
      $this->taulesDisponibles->loadTaula($idr_o_taula);
    }
    

    if($torn==1 || $torn==2)
    {
      //TORN1
      $this->taulesDisponibles->torn=1;
      $dinar=$this->taulesDisponibles->recupera_hores(true);
      //$taules=$this->taulesDisponibles->taules();
      $taules=$this->taulesDisponibles->taulesDisponibles();
      $taulaT1=$taules[0]->id;
      if (!$dinar) $dinar="";
        
      //TORN2
      $this->taulesDisponibles->torn=2;
      $dinarT2=$this->taulesDisponibles->recupera_hores(true);
      //$taules=$this->taulesDisponibles->taules();
      $taules=$this->taulesDisponibles->taulesDisponibles();
      $taulaT2=$taules[0]->id;
      if (!$dinarT2) $dinarT2="";
      
      $taulaT3=0;
      $sopar="";
    }
      
    if($torn==3)
    {
      //TORN3
      $this->taulesDisponibles->torn=3;
      $sopar=$this->taulesDisponibles->recupera_hores(true);
      //$taules=$this->taulesDisponibles->taules();
      $taules=$this->taulesDisponibles->taulesDisponibles();
      $taulaT3=$taules[0]->id;
      if(!$sopar) $sopar="";
      $taulaT1=$taulaT2=0;
      $dinar=$dinarT2='';
      
    }
    $json=array('dinar'=>$dinar,'dinarT2'=>$dinarT2,'sopar'=>$sopar,'taulaT1'=>$taulaT1,'taulaT2'=>$taulaT2,'taulaT3'=>$taulaT3,'error'=>'');   
    
    if ($taulaT1 || $taulaT2 || $taulaT3) return $json;//return json_encode($json);// ARRAY AMB ELS TRES TORNS   
    
    $error='<p class="error max_comensals">Has superat el maxim de comensals per aquest torn. <br/>No es poden crear mes reserves</p>';
    
    $error=$this->taulesDisponibles->llistaErrors();
    $json=array('dinar'=>'','dinarT2'=>'','sopar'=>'','taulaT1'=>'','taulaT2'=>0,'taulaT3'=>0,'error'=>$error);
    return $json;
    //return json_encode($json);
    
    //$avis2='<input type="hidden" name="prohibit" class="{required:true,email:true}"/>';
    //return $avis;
  }
  
  public function recupera_hores_json($idr_o_taula=null , $persones=null,$cotxets=0)
  {
    return json_encode($this->recupera_hores($idr_o_taula, $persones, $cotxets));
  }
    
  
/*********************************************************************************************************************************/ 
/*********************************************************************************************************************************/ 
/*********************************************************************************************************************************/ 
/*********************************************************************************************************************************/ 
/*********************************************************************************************************************************/ 
/*********************************************************************************************************************************/ 
  public function edita_hores($base="",$torn=1,$table="estat_hores")
  {
    if (empty($table)) $table="estat_hores";

    if (!isset($_SESSION))   session_start();
    if ($base == "BASE")
    {
      $data = $this->data_BASE;   
      //$torn=1;
    }
    else
    {
      $data=$_SESSION['data'];
      $torn = $_SESSION['torn'];
    }
    
    $torn100=$torn+100;
    $maxtorn=0;
    
    
    $query = "SELECT * FROM $table
    WHERE 
    
    (estat_hores_data='$data' AND (estat_hores_torn = '$torn' OR estat_hores_torn = '$torn100' ))
    OR
    (estat_hores_data = '".$this->data_BASE."' AND (estat_hores_torn = '$torn' OR estat_hores_torn = '$torn100' ))
    
    ORDER BY estat_hores_hora, estat_hores_data DESC";
    $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
//echo $query;
    $req=' class="ckbx_hora" ';
    
    $n=0;
    
    $radio='<table id="edita_hores"><tr>';
    
    while ($row = mysql_fetch_array($Result1))
    {
      if ($horac==$row['estat_hores_hora']) continue;
      $horac=$row['estat_hores_hora'];
      if ($row['estat_hores_hora']==$hora) continue;
      if ($row['estat_hores_hora']=="00:00") 
      {
        $maxtorn=$row['estat_hores_max'];
        continue;
      }
      
      $hora=$row['estat_hores_hora'];
      $max=$row['estat_hores_max'];
      if ($row['estat_hores_actiu'] == 1) $checked = 'checked="checked"';
      else $checked = "";
      
      $radio.=$preradio;
      
      $preradio = '<td><input type="checkbox" id="'.$nom.$row['estat_hores_id'].'"  value="'.$row['estat_hores_hora'].'" '.$checked.' class="ckbx_hora"  torn="'.$torn.'"/>
      <label for="'.$nom.'h'.$row['estat_hores_id'].'">'.$row['estat_hores_hora'].'</label>';
      $preradio .='<span class="edita-hores-max"><br>Màx: <input type="text" name="'.$nom.$row['estat_hores_id'].'" class="max_hores" torn="'.$torn.'" value="'.$max.'"></span></td>';
      $req="";
    }
    
    $radio.=$preradio;
    $max="NO";
    $radio.='<td style="color:#C00;padding-left:50px;"><span class="edita-hores-max">TOTAL TORN<br/>
    <input type="text" name="max_torn" class="max_hores" value="'.$maxtorn.'"  torn="'.$torn.'"> (0 = sense límit)
    <input type="hidden" id="max_torn" class="max_hores" value="00:00" readonly="readonly"  torn="'.$torn.'"></span></td>';
    $radio.='</tr></table>';
    
    $this->taulesDisponibles->data=$_SESSION['data'];
    $this->taulesDisponibles->torn=$_SESSION['torn'];
    $checked=$this->taulesDisponibles->recupera_creaTaules()?'checked="checked"':'' ;
    $radio.='<br/><br/><input type="checkbox" id="creaTaules" '.$checked.' /> Creació automàtica de taules al formulari Online de reserves petites. <b>Només afecta el dia i torn actual!</b>';    
    return $radio;
    //return "RESULTAT: ".$query." ---- ".$torn;
  
  } 
  

/*********************************************************************************************************************************/ 
/***********   UPDATE HORES ************************************************************************************/ 
/*********************************************************************************************************************************/ 

  public function update_hora($hora,$activa,$max,$base,$torn=null,$table="estat_hores")
  {
    if (empty($table)) $table="estat_hores";
    
    if (!isset($_SESSION))   session_start();
    
    
    if ($base=="BASE") $data=$this->data_BASE;
    else $data=$_SESSION['data'];
    if (!$torn || $torn=="undefined") $torn = $_SESSION['torn'];
    
    if ($hora=="00:00") $torn+=100;
    
    $query = "DELETE FROM $table WHERE    
    (estat_hores_data='$data' AND estat_hores_hora='$hora' AND estat_hores_torn = '$torn')";
    $Result1 = $this->log_mysql_query($query,  $this->connexioDB) or die(mysql_error());
    if($activa=="0" || true) 
    {
        $insertSQL = sprintf("INSERT INTO $table 
        (estat_hores_data, estat_hores_torn, estat_hores_hora, estat_hores_actiu, estat_hores_max) 
        VALUES (%s, %s, %s, %s, %s)",
                 $this->SQLVal($data, "text"),
                $this->SQLVal($torn, "text"),
                 $this->SQLVal($hora, "text"),
                 $this->SQLVal($activa, "text"),
                 $this->SQLVal($max, "text"));

    
        $Result1 = $this->log_mysql_query($insertSQL,  $this->connexioDB) or die(mysql_error());
    }

    return $query."<br/>\n<br/>\n".$insertSQL;
    //return $Result1?"ok":"ko: $insertSQL";
  } 
  

/*********************************************************************************************************************************/ 
/***********   UPDATE CREA TAULES ************************************************************************************/ 
/*********************************************************************************************************************************/ 

  public function update_creaTaules($data,$torn,$activa)
  {
    if (!isset($_SESSION))   session_start();
    
    $mydata=$this->cambiaf_a_mysql($data);
       
    $query = "DELETE FROM estat_crea_taules WHERE    
    (estat_crea_taules_data='$mydata' AND estat_crea_taules_torn = '$torn')";
    $Result1 = $this->log_mysql_query($query,  $this->connexioDB) or die(mysql_error());
    
    $insertSQL = sprintf("INSERT INTO estat_crea_taules 
    (estat_crea_taules_data, estat_crea_taules_torn, estat_crea_taules_actiu) 
    VALUES (%s, %s, %s)",
             $this->SQLVal($mydata, "text"),
            $this->SQLVal($torn, "text"),
             $this->SQLVal($activa, "text"));

    $Result1 = $this->log_mysql_query($insertSQL,  $this->connexioDB) or die(mysql_error());
    

    return $query."<br/>\n<br/>\n".$insertSQL;
  } 
  


/*********************************************************************************************************************************/ 
/***********   PERMUTA ************************************************************************************/  
/*********************************************************************************************************************************/ 
  public function permuta($orig,$dest,$res)
  {
    return "FINS AQUI TOT BEEE";
  }


/********      CANVI_DATA     ************/
  public function canvi_data($data=null,$torn=0)
  {
    if (!empty($data)) 
    {
      if (!isset($_SESSION))   session_start();
      $_SESSION['data']=$this->cambiaf_a_mysql($data);
      if ($torn) $_SESSION['torn']=$torn;
    }

        $resposta['resposta']="ok";
	$resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
	$resposta['missatge_dia'] = $this->recupera_missatge_dia();
	$resposta['ac_reserves']=$this->accordion_reserves();
	
	return $this->jsonResposta($resposta);
}

  /********      CANVI_TORN     ************/
  public function canvi_torn($torn)
  {
    if (!isset($_SESSION))   session_start();
      $_SESSION['torn']=$torn;
    
        $resposta['resposta']="ok";
	$resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
	//$resposta['missatge_dia'] = $this->recupera_missatge_dia();
	$resposta['ac_reserves']=$this->accordion_reserves();
	
	return $this->jsonResposta($resposta);
  }


/********      CANVI_MODO     ************/
  public function canvi_modo($modo)
  {
    if (!isset($_SESSION))   session_start();
    $_SESSION['modo']=$modo;
    
        $resposta['resposta']="ok";
	//$resposta['total_coberts_torn'] = $this->total_coberts_torn(false);
	//$resposta['missatge_dia'] = $this->recupera_missatge_dia();
	$resposta['ac_reserves']=$this->accordion_reserves();
	
	return $this->jsonResposta($resposta);
  }

  
//////////////////////////////////////////////////// 
//Retorna el torn d'una hora donada
//////////////////////////////////////////////////// 
  public function torn($data,$hora)
  {
    $data_BASE=$this->data_BASE;
    
    $query="SELECT * FROM `estat_hores` 
WHERE `estat_hores_hora`='$hora'
AND (`estat_hores_data`='$data' OR `estat_hores_data`='$data_BASE')
ORDER BY `estat_hores_data` DESC";
  $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());

  $row = mysql_fetch_array($Result1);
  return $row['estat_hores_torn'];
    //return ($hora>"15")?(($hora>"19")?3:2):1;
  }
  
/********      SUMA DIAS     ************/
  public function sumaDias($fecha,$ndias)  //format yyy-mm-dd     
  {         
      if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha))
        
          list($año,$mes,$dia)=split("/", $fecha);
        
      if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha))
        
          list($año,$mes,$dia)=split("-",$fecha);
      $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
      $nuevafecha=date("Y-m-d",$nueva);
        
      return ($nuevafecha);            
  }

/********      DIA SEMANA     ************/
  public function diaSemana($fecha)  //format yyy-mm-dd     
  {         
      if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/",$fecha))
        
          list($año,$mes,$dia)=split("/", $fecha);
        
      if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha))
        
          list($año,$mes,$dia)=split("-",$fecha);
      $nueva = mktime(0,0,0, $mes,$dia,$año);
      $nuevafecha=date("N ",$nueva);
        
      return ($nuevafecha);            
  }

/****************************************/
/****************************************/
/********   mostra_error  *********/
/****************************************/
/****************************************/
  public function xxxxxxxxxxxxxxxxxxxxxmostra_error()
  {
    echo ('<div class="DBError">NO S\'HA POGUT COMPLETAR L\'ACCIÓ:<br/><br/>'.$this->error.'</div>');
  }

/****************************************/
/****************************************/
/********   MAIL BODY  *********/
/****************************************/
/****************************************/
  public function mail_body($dia=0, $hora=0)
  {
    return "";
  }

/****************************************/
/****************************************/
/********   ENVIA MAIL  *********/
/****************************************/
/****************************************/
  public function enviaMail($idr,$plantilla="confirmada_",$destinatari=null,$extres=null)
  {
    require_once("../editar/mailer.php");
    require_once(INC_FILE_PATH."template.inc");
  
    $query="SELECT * FROM ".T_RESERVES."
    LEFT JOIN client ON ".T_RESERVES.".client_id=client.client_id
      WHERE id_reserva=$idr";
  
    if (floor($idr)>SEPARADOR_ID_RESERVES)
    {
      $this->qry_result = mysql_query($query, $this->connexioDB) or die(mysql_error());
      $row = mysql_fetch_assoc($this->qry_result);
        
      if (!mysql_num_rows($this->qry_result)) return "err10";
    }
    $row['aixoesunarray']=1;
    if ($extres) $row=array_merge($row,$extres);
    //Gestor::printr($row);
  
    $avui=date("d/m/Y");
    $ara=date("H:i");
    $file=$plantilla.$this->lng.".lbi";
    $t=new Template('.','comment');
  
    if (is_array($extres))  foreach ($row as $k=>$v) $t->set_var($k,$v);
  
    $t->set_file("page", $file);
  
    $t->set_var('avui',date("l d M Y"));
    $t->set_var('id_reserva',$idr);
    $t->set_var('data',$row['data']);
    $t->set_var('hora',$row['hora']);
  
    $t->set_var('adults',$row['adults']);
    $t->set_var('nens10_14',$row['nens10_14']);
    $t->set_var('nens4_9',$row['nens4_9']);
    $t->set_var('cotxets',$row['cotxets']);
  
    $t->set_var('comanda',$this->plats_comanda($idr));
    $t->set_var('nom',$row['client_nom']." ".$row['client_cognoms']);
    $t->set_var('observacions',$row['observacions']);
  
    $altbdy='HTML NOT PROCESSED';
  
  
    $t->parse("OUT", "page");
    $html=$t->get("OUT");
    if ($destinatari) $recipient=$destinatari;
    else $recipient=$row['client_email'];
  
    if (isset($row['subject'])) $subject=$row['subject'];
    else $subject="..::Reserva Can Borrell::..";
  
    try
    {
      $r=mailer($recipient, $subject , $html, $altbdy,null,false,MAIL_CCO);
      $mail="Enviament $plantilla RESERVA PETITA ONLINE($r): $idr -- $recipient";
    }
    catch(Exception $e)
    {
      $mail="err10";
    }
  
    return $mail;
  }
  
  /****************************************/
  /****************************************/
  /********   ENVIA SMS  *********/
  /****************************************/
  /****************************************/
  public function enviaSMS($res,$missatge,$numMobil=0)
  {
    if ($_SESSION['permisos'] < 1) {
      $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: SIN PERMISOS!!!");
    }
    include_once( ROOT."../editar/SMSphp/EsendexSendService.php" );
  
    if (!isset($res) || empty($missatge)) {
      $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: FALTA RESERVA o MENSA!!!");
      return false;
    }
  
    /*******************/
    //ATENCIO, PER DIFERENCIAR SI ES RESERVA DE GRUP (ESTAN EN UNA ALTRA TAULA)
    $taula_reserves=$res>SEPARADOR_ID_RESERVES?T_RESERVES:'reserves';
    /*******************/
    
    $query="SELECT client_mobil FROM client INNER JOIN  `$taula_reserves` ON ".$taula_reserves.".client_id = client.client_id
    WHERE id_Reserva = $res";
    $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
    $row = mysql_fetch_array($Result1);
    if (!$row['client_mobil']) {
      $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: FALTA NUM MOBIL!!!");
      return false;
    }
    $numMobil=$row['client_mobil'];
    $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: ".$res." >>> ".$numMobil." >>> ".$missatge);
  
    if (strlen($numMobil)!=9 || !is_numeric($numMobil)) return true;//return $this->llistaSMS($res);
    if (substr($numMobil,0,1)!='6' && substr($numMobil,0,1)!='7') return true;//return $this->llistaSMS($res);
    $mensa = $this->SQLVal($missatge);
  
    // Test Variables - assign values accordingly:
    $recipients = $numMobil;    // The mobile number(s) to send the message to (comma-separated).
    $body = $mensa;     // The body of the message to send (must be less than 160 characters).
  
  
    $username = "restaurant@can-borrell.com";     // Your Username (normally an email address).
    //ANTIC $password = "NDX5631";      // Your Password.
    $password = "1909";     // Your Password 26/2/2013.
    $accountReference = "EX0062561";    // Your Account Reference (either your virtual mobile number, or EX account number).
    $originator = "Rest.Can Borrell";   // An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).
    $type = "Text";     // The type of the message in the body (e.g. Text, SmartMessage, Binary or Unicode).
    $validityPeriod = 0;    // The amount of time in hours until the message expires if it cannot be delivered.
    $result;      // The result of a service request.
    $messageIDs = array($idReserva);    // A single or comma-separated list of sent message IDs.
    $messageStatus;     // The status of a sent message.
  
  
    if (ENVIA_SMS == "1" &&  $recipients!='999212121')
    {
      try{
        $sendService = new EsendexSendService( $username, $password, $accountReference );
        $result = $sendService-> SendMessage( $recipients, $body, $type );
       $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: REAL" . $result);
      }catch(Exception $e){
        $this->reg_log(">>>>>>>>>>>>>>>>>>> ERROR: $result");
        $result['Result']="SMS: ERROR DE CONNEXIO AL HOST ($result)";     
      }
      
    }
    else
    {
      $this->reg_log(">>>>>>>>>>>>>>>>>>> ENVIA SMS: SIMULAT");
    }
  
  
    $r = '<span style="color:red;font-size:11px;"><em> -(tel: '.$numMobil.') RESULTAT:  '.$result['Result'].' / '.$result['Message'].'</em></span>';
    //BBDD
    $t=mysql_real_escape_string($mensa.$r);
  
    $query = "INSERT INTO sms (sms_reserva_id, sms_numero, sms_missatge) VALUES ($res, $numMobil, '$t')";
    $Result1 = $this->log_mysql_query($query,  $this->connexioDB) or die(mysql_error());
  
    ///return $this->llistaSMS($res);
    return true;
  }
  
/****************************************/
/****************************************/
/******** LLISTA SMS  *********/
/****************************************/
/****************************************/
  public function llistaSMS($reserva_id)
  {
      if (!$reserva_id) return "";
      $query = "SELECT * FROM sms WHERE sms_reserva_id=$reserva_id ORDER BY sms_data";
      $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
      $this->total_rows = mysql_num_rows($Result1);
      

      while ($row = mysql_fetch_array($Result1))
      {
        $html.= '
        <div class=" llista-sms-data">'.$this->cambiaf_a_normal($row['sms_data']).'</div>
        <div class = "llista-sms-mensa" > '.$row['sms_missatge'].' </div>';
      }
      
      return stripslashes($html);
      
}



/****************************************/
/****************************************/
/**** GUARDA VALOR MENU CALÇOTS ACTIU ***/
/****************************************/
/****************************************/
  public function guardaCalsoton($actiu)
  {
      $valor=$actiu?1:0;
  
      $query = "UPDATE comanda SET comanda_plat_quantitat=$valor WHERE comanda_reserva_id=0 AND comanda_plat_id=2010";
      $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
      return true;
}



/****************************************/
/****************************************/
/********   TOTAL COBERTS TORN  *********/
/****************************************/
/****************************************/
  public function total_coberts_torn($json=true)
  {
    $this->taulesDisponibles->data=$_SESSION['data'];
    //$this->taulesDisponibles->torn=$_SESSION['torn'];
    $this->taulesDisponibles->torn=1;
    $t['t1']=$this->taulesDisponibles->sum_comensals_torn();
    $maxtorn=$this->taulesDisponibles->max_torn();
    
    $this->taulesDisponibles->torn=2;
    $t['t2']=$this->taulesDisponibles->sum_comensals_torn();
    
    $this->taulesDisponibles->torn=3;
    $t['t3']=$this->taulesDisponibles->sum_comensals_torn();
    //return $this->taulesDisponibles->sum_comensals_torn().'  max:'.$this->taulesDisponibles->max_torn();
    $t['total']=$t['t'.$_SESSION['torn']].'  max:'.$maxtorn;
    if ($json) return json_encode($t);
    return $t;
  }


/************************************************************************************************************************/
  public function cerca_taula($persones=null, $cotxets=0,$findes=null)
  {
    $persones=$persones=="undefined"?0:$persones;
    $cotxets=$cotxets=="undefined"?0:$cotxets;
    
    $nomTorn=array("ERR-zero","Dinar torn 1","Dinar torn 2","Sopar");
    $inimsg="";
    $html=$inimsg;
    
    
    $mydata=$this->taulesDisponibles->data=$_SESSION['data'];
    $torn=$this->taulesDisponibles->torn=$_SESSION['torn'];
    $this->taulesDisponibles->persones=$persones;
    $this->taulesDisponibles->cotxets=$cotxets;
    $this->taulesDisponibles->tableHores='estat_hores';
    $this->taulesDisponibles->tableMenjadors='estat_menjador';
    $taules=$this->taulesDisponibles->taules();
    
//echo "$mydata * $torn * $persones * $cotxets ---- ".$_SESSION['data']."  --- ".$_SESSION['torn'];
    if (!$taules) 
    {
      //print_r($this->taulesDisponibles->arTxtError);    
      echo $this->taulesDisponibles->llistaErrors();
      return $html;
    
    }
    
    foreach ($taules as $k=>$v)
    {
      $data=$this->cambiaf_a_normal($mydata);
      //$torn=$this->torn($v->data, $v->hora);
      if (substr($v->nom,0,2)=="OL") continue;
      
      $ret= '<a href="'.$v->id.'" dia="'.$mydata.'" torn="'.$torn.'" n="'.$v->nom.'" p="'.$v->persones.'" c="'.$v->cotxets.'" f="'.$v->plena.'" ><table class="taulaCercador">
      <tr> 
        <td class = " f1 id-taula">'.$v->nom.'</td>       
        <td class="f12">'.$data.' </td>
      </tr>
      
      <tr>        
        <td class="f2"> '.$v->persones.'/'.$v->cotxets.'</td>    
        <td class="f22">'.$BLOC.$BLOC2.' <span class="torn'.$t.'">'.$nomTorn[$torn].'</span></td>
      </tr>
      </table></a > 
';
    
      if ($html==$inimsg) $html="";
      $html.= $ret;
      
      if (++$ntaules>12) break;
    }

    return $html;
  }
  
/************************************************************************************************************************/
  public function recupera_torn()
  {
    return $_SESSION['torn'];
  } 
  
  public function recupera_data()
  {
    return $_SESSION['data'];
  }
      //COMPROVA L'ALTRE TORN
/************************************************************************************************************************/
  public function altreTorn($taula,$persones="",$cotxets="")
  {
      $data=$_SESSION['data'];
  
      $altre_torn=$_SESSION['torn'];
      if ($_SESSION['torn']==1) $altre_torn=2;
      if ($_SESSION['torn']==2) $altre_torn=1;
      if ($_SESSION['torn']==3) return 3;
      
      //EXISTEIX?
      //NO TE RESERVA // reserva_id=0
      $query="SELECT * FROM ".ESTAT_TAULES." 
      WHERE 
      (estat_taula_taula_id=$taula AND estat_taula_torn=$altre_torn AND estat_taula_data='$data' AND estat_taula_x>0 AND estat_taula_y>0)
      OR
      (estat_taula_taula_id=$taula  AND estat_taula_torn=$altre_torn AND estat_taula_data='".$this->data_BASE."' AND estat_taula_x>0)
      ORDER BY estat_taula_id DESC";
      
      $this->qry_result = $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
      $row=$this->last_row = mysql_fetch_assoc($this->qry_result);
      /* SI EXISTEIX I NO TE RESERVA SEGUIM */
      //MENJADOR BLOQ? AND // QUADREN PERSONES AND COBERTS????
      if ($row['reserva_id']==0 && $row['estat_taula_persones']==$persones && $row['estat_taula_cotxets']==$cotxets) 
      {
        //$row=$this->last_row = mysql_fetch_assoc($this->qry_result);
        $x=$row['estat_taula_x'];
        $y=$row['estat_taula_y'];
        $taulesDisponibles->data=$taulesDisponibles->data=$data;
        $taulesDisponibles->torn=$altre_torn;
        $bloquejats=$this->taulesDisponibles->menjadorsBloquejats($this->menjadors);
        if (!$this->taulaBloquejada($x,$y,$bloquejats)) 
          return $altre_torn; // SI ARRIBA FINS AKI, EL TORN ES OK      
      }
      
      
      
    /* SI ARRIBA FINS AQUI, NO VAL, RETORNA EL TORN ACTIU*/
    return $_SESSION['torn'];
  }
  
/************************************************************************************************************************/
  public function plats_comanda($idr)
  {
    if (!$idr) return "No s'ha rebut ID";
    
    $query="SELECT carta_plats_nom_es,comanda_plat_quantitat 
    FROM comanda 
    LEFT JOIN carta_plats ON carta_plats_id=comanda_plat_id
    WHERE comanda_reserva_id=$idr";
    $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
    //echo set_error_handler();
    //restore_error_handler();
    $comanda="";
     while ($row = mysql_fetch_array($Result1))
    {
      $comanda.=$row['comanda_plat_quantitat']." x ".$row['carta_plats_nom_es']."<br/>";
    }
    
    return $comanda;
  }
  
  
/************************************************************************************************************************/
  public function garjola($tel,$email,$valor=null)
  {
    if ($valor=='true') $query="INSERT INTO llista_negra SET llista_negra_mobil='$tel',llista_negra_mail='$email'";
    elseif($valor=='false') $query="DELETE FROM llista_negra WHERE llista_negra_mobil='$tel' OR llista_negra_mail='$email'";
    else $query="SELECT * FROM llista_negra WHERE llista_negra_mobil='$tel' OR llista_negra_mail='$email'";
    $this->qry_result = $Result1 = mysql_query($query,  $this->connexioDB) or die(mysql_error());
    return (mysql_num_rows($this->qry_result));
  }
/************************************************************************************************************************/
  public function taulaBloquejada($x, $y, $bloquejats)
  {
    $solapa=false;
    foreach ($bloquejats as $key => $menjador)
    {
    //echo "\n\n".$x." $y --- ".$menjador->name." --- ".($menjador->solapa($x, $y)?"Sii":"Noo");
      if ($menjador) $solapa = $solapa || $menjador->solapa($x, $y);
    }
    
    return $solapa;
  }
  
/************************************************************************************************************************/
/************************************************************************************************************************/
  public function updateMenjador($id, $data,$torn, $bloquejat=0,$table="estat_menjador")
  {
    if (empty($table)) $table="estat_menjador";
    
    $query = "DELETE FROM $table WHERE estat_menjador_menjador_id=$id AND estat_menjador_data='$data' AND estat_menjador_torn='$torn'";

    $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
    $query = "INSERT INTO $table SET estat_menjador_menjador_id=$id, estat_menjador_data='$data',estat_menjador_torn='$torn',estat_menjador_bloquejat=$bloquejat";

    $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
    
    
  }


/*********************************************************************************************************************/
public function missatgeLlegit($idr)
{
  $query="UPDATE ".T_RESERVES." SET reserva_info=(reserva_info|16) WHERE id_reserva=$idr";
  $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
  
  return $idr;
}

/*********************************************************************************************************************/
public function taulaEntrada($idr,$val)
{
  $query="UPDATE ".T_RESERVES." SET reserva_info=$val WHERE id_reserva=$idr";
  $Result1 = mysql_query($query, $this->connexioDB) or die(mysql_error());
  
  return $idr;
}

/*********************************************************************************************************************/
/*
BIT FLAGS: 
1(1)=reserva online 
2(2)=reserva per grups
3(4)=cotxet 
4(8)=cotxet > 00=1cotxet normal,01=2cotxets normals,10=1 cotxet doble ample,11=1 cotxet doble llarg
5(16)=misstge llegit (16)
6(32)=reserva entrada=clients ja són a taula
7(64)=esborrar dades client passada la data de reserva
8(128)=CADIRA RODES 
*/
public function encodeInfo($ampla, $grups, $online)
{
  $info=0;
  $info|=$online?1:0;//1er bit  
  
  $grups=$grups << 1;
  $info|=$grups;// GRUP = FALSE 
  
  $ampla=$ampla << 2;
  $info|=$ampla;// AMPLA/LLARG 
  

  return $info;
}

/*********************************************************************************************************************/
/*
BIT FLAGS: 
1(1)=reserva online 
2(2)=reserva per grups
3(4)=cotxet 
4(8)=cotxet > 00=1cotxet normal,01=2cotxets normals,10=1 cotxet doble ample,11=1 cotxet doble llarg
5(16)=misstge llegit (16)
6(32)=reserva entrada=clients ja són a taula
7(64)=esborrar dades client passada la data de reserva
8(128)=CADIRA RODES 
*/
public function decodeInfo($info)
{
  $ar['online']=($info & 1)?true:false;//1
  $ar['grups']=($info & 2)?true:false;//2
  $ar['ampla']=($info >> 2 ) & 3;//3,4
  $ar['llegit']=$this->flagBit($info,5);//5
  $ar['entrada']=$this->flagBit($info,6);//6
  $ar['esborra_cli']=$this->flagBit($info,7);//7
  $ar['cadiraRodes']=$this->flagBit($info,8);//8
  $ar['accesible']=$this->flagBit($info,9);//9
  //$ar['bit10']=$this->flagBit($info,10);//10
    
  return $ar;
}
  

/************************************************************************************************************************/
  public function reg_log($txt,$request=true)
  {
    
    parent::greg_log($txt,null,$request);
  }

/******************************************************************************************************/
  public function init($data)
  {
      $this->canvi_modo('1');
      
      return $this->canvi_data($data);
      
  }
 /******************************************************************************************************/
  protected function jsonResposta($resposta)
  {
    $resposta['data']=$_SESSION['data'];
    $resposta['torn']=$_SESSION['torn'];
    $resposta['modo']=$_SESSION['modo'];
    //$resposta['request']=$_SERVER['REQUEST_URI'];
    //$resposta['query']=$_SERVER['QUERY_STRING'];
    $resposta['action']=$_REQUEST['a'];
    if ($resposta['resposta']=="ko") return $this->jsonErr($resposta['error'],$resposta);
    else return $this->jsonOK("ok",$resposta); 
  
  }

/************************************************************************************************************************/
}
//$_REQUEST['a']="print_llista_reserves";
//$_SESSION['permisos']=255;

include(ROOT."peticions_ajax.php");
 
//$g=new gestor_reserves();echo $g->recupera_hores(1964);

?>