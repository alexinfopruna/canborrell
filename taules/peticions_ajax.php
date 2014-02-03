<?php
function out($t)
{
	Gestor::out($t);
}

if (isset($_REQUEST['a']) && !empty($_REQUEST['a']))
{
	$gestor=new gestor_reserves();
	if (!$gestor->valida_sessio(1))  header("Location: index.php");

	$logables=array('update_client','esborra_client','inserta_reserva','update_reserva','esborra_reserva','enviaSMS','permuta','permuta_reserva','','','','','','','','','','','');
	$log=in_array($_REQUEST['a'], $logables);
		
	$ip=$ips[$_SERVER['REMOTE_ADDR']]?$ips[$_SERVER['REMOTE_ADDR']]:$_SERVER['REMOTE_ADDR'];
	$sessuser=$_SESSION['uSer'];
		if (isset($sessuser)) $user=$sessuser->id;
		if ($log)	$gestor->reg_log("/* >>> Petició Gestor reserves:  user: $user ($ip)".$_REQUEST['a']." (b=".$_REQUEST['b'].", c=".$_REQUEST['c'].", d=".$_REQUEST['d']." ---- p=".$_REQUEST['p'].", q=".$_REQUEST['q'].", r=".$_REQUEST['r'].", c=".$_REQUEST['c'].", d=".$_REQUEST['d'].", e=".$_REQUEST['e'].")<<< */".EOL);
	
	switch ($accio=$_REQUEST['a'])
	{
		case "accordion_clients":
			out( $gestor->accordion_clients($_REQUEST['p']));
			$gestor->refresh(true);
		break;	
		
		case "combo_clients":
			out( $gestor->combo_clients($_REQUEST['p']));
		break;	
		
		case "htmlDadesClient":
			out( $gestor->htmlDadesClient($_REQUEST['p']));
		break;
		
		case "inserta_client":
			out( $gestor->inserta_client());
			$gestor->refresh(true);
		break;
		
		case "load_client":
			out( $gestor->load_client($_REQUEST['p'],$_REQUEST['q']));
		break;
		
		case "update_client":
			out( $gestor->update_client());
			$gestor->refresh(true);
		break;	
		
		case "esborra_client":
			out( $gestor->esborra_client($_REQUEST['p']));
			$gestor->refresh(true);
		break;	
		
		case "inserta_reserva":
			out( $gestor->inserta_reserva());
			$gestor->refresh(true);
		break;
		
		case "update_reserva":
			out( $gestor->update_reserva());
			$gestor->refresh(true);
		break;	
		
		case "esborra_reserva":
			out( $gestor->esborra_reserva($_REQUEST['p'],$_REQUEST['q']));
			$gestor->refresh(true);
		break;	
		
		case "accordion_reserves":
			out( ($gestor->accordion_reserves($_REQUEST['p'])));
			$gestor->refresh(true);
		break;	
		
		case "canvi_data":
			out( $gestor->canvi_data($_REQUEST['p'],$_REQUEST['q']));
			$gestor->refresh(true);
		break;	
		
		case "canvi_modo":
			out( $gestor->canvi_modo($_REQUEST['p']));
		break;	
		
		case "recupera_hores":
			out( $gestor->recupera_hores($_REQUEST['c'],$_REQUEST['d'],$_REQUEST['e']));
		break;	
		
		case "total_coberts_torn":
			out( $gestor->total_coberts_torn($_REQUEST['p'],$_REQUEST['c']));
		break;	
		
		case "canvi_torn":
			out( $gestor->canvi_torn($_REQUEST['p']));
		break;	
		
		case "cerca_reserves":
			out( $gestor->accordion_reserves($_REQUEST['p'],$_REQUEST['c']));
		break;	
		
		case "cerca_clients":
			out( $gestor->accordion_clients($_REQUEST['p'],$_REQUEST['c']));
		break;	
		
		case "clientHistoric":
			out( $gestor->clientHistoric($_REQUEST['p']));
		break;	
		
		case "valida_reserva":
			out( $gestor->valida_reserva($_REQUEST['p']));
		break;	
		
		case "cerca_taula":
			out( $gestor->cerca_taula($_REQUEST['p'],$_REQUEST['q'],$_REQUEST['r']));
		break;	
		
		case "recupera_torn":
			out( $gestor->recupera_torn($_REQUEST['p'],$_REQUEST['q'],$_REQUEST['r']));
		break;	
		

		case "insert_id":
			out( $gestor->insert_id());
		break;

		case "refresh":
			out( $gestor->refresh());
		break;

		case "edita_hores":
			echo( $gestor->edita_hores($_REQUEST['p'],$_REQUEST['q']));
		break;

		case "update_hora":
			out( $gestor->update_hora($_REQUEST['p'],$_REQUEST['c'],$_REQUEST['d'],$_REQUEST['e'],$_REQUEST['f'],$_REQUEST['g']));
		break;

		case "guarda_missatge_dia":
			out( $gestor->guarda_missatge_dia($_REQUEST['p'],$_REQUEST['c']));
		break;
		
		case "recupera_missatge_dia":
			out( $gestor->recupera_missatge_dia($_REQUEST['p'],$_REQUEST['c']));
		break;

		case "enviaSMS":
			out( $gestor->enviaSMS($_REQUEST['p'],$_REQUEST['c']));
		break;

		case "llistaSMS":
			out( $gestor->llistaSMS($_REQUEST['p']));
		break;

		case "autocomplete_clients":
			out( $gestor->autocomplete_clients($_REQUEST['term'],$_REQUEST['p']));
		break;

		case "autocomplete_reserves":
			out( $gestor->autocomplete_reserves($_REQUEST['term']));
		break;

		case "permuta":
			out( $gestor->permuta($_REQUEST['c'],$_REQUEST['d'],$_REQUEST['r']));
			$gestor->refresh(true);
		break;

		case "permuta_reserva":
			out( $gestor->permuta_reserva($_REQUEST['c'],$_REQUEST['d'],$_REQUEST['r']));
			$gestor->refresh(true);
		break;

		case "plats_comanda":
			out( $gestor->plats_comanda($_REQUEST['p']));
		break;

		case "taula_bloquejada":
			out( $gestor->taula_bloquejada($_REQUEST['p']));
		break;

		case "bloqueig_taula":
			out( $gestor->bloqueig_taula($_REQUEST['p'],$_SESSION['data'],$_SESSION['torn'],$_REQUEST['q']));
		break;

		case "cambiaf_a_mysql":
			out( $gestor->cambiaf_a_mysql($_REQUEST['p'],$_REQUEST['q']));
		break;

		case "cambiaf_a_normal":
			out( $gestor->cambiaf_a_normal($_REQUEST['p'],$_REQUEST['q']));
		break;

		case "sql":
			out( $gestor->sql());
		break;

		case "test":
			out( "TEST (param P): ".$_REQUEST['p']);			
		break;

		
		
		case "tanca_sessio":
			out( $gestor->tanca_sessio());
			header("location: .");
		break;
		
		default:
			$gestor->out(call_user_func(array($gestor, $accio),$_REQUEST['b'],$_REQUEST['c'],$_REQUEST['d'],$_REQUEST['e'],$_REQUEST['f'],$_REQUEST['g']));	
		break;
	}
}
?>