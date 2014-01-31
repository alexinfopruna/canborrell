//PENDENT CONFIG
var HOST="DEV";

var refreshIntervalId;
var client=0;
var timeractiu=false;
var FILTRE_RES=1;
var FILTRE_CLI=1;

var taulaSel;
var TAULA, N, P,C,F,CERCA;
var ONLOAD_BLOC_CALEND=false;
var ONLOAD_BLOC_TORN=false;
var canvia_data_confirma=false;
var clk=0;

var reserva=0;
var acop={collapsible:false,active:false,autoHeight:false,change:function(event,ui){	client=$(ui.newHeader).find("a").attr("href").split("&id=")[1];	}};

var popup;
var guardat=false;

var permuta=0;


var acopres={collapsible:true,active:false,autoHeight:false,change:
	function(event,ui)
	{	
		taulaSel=$(ui.newHeader).find("a").attr("taula");
		FLASH.seleccionaTaula(taulaSel);

	}
};


jQuery.expr[':'].focus = function( elem ) {
  return elem === document.activeElement && ( elem.type || elem.href );
};

/////////////////////////////////////////////////////////////////////////////////////////
// PROTOTYPE STRING TRIM
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
};

//CACHE ELEMENTS

var FLASH;
var CALEND_ZOOM;
var CALENDARI;
var FORMULARI_INSERTA_RES;
var FORM_EDIT;
var RESERVES_AC;
var CLIENTS_AC;
var RADIO_TORN;
var INSERT_CLIENT;
var REFRESH;
var TABS;
var LOADING;
var CECADOR;

/////////////////////////////////////////////////////////////////////////////////////////
// READY
$(function(){
//REFRESH_INTERVAL=1000000;
//REFRESH_INTERVAL=1000;

//ELEMENTS
FLASH=getFlashMovie("flash");
//FORMULARI_INSERTA_RES=$("#frm_edit_modal_inserta_res");
FORMULARI_INSERTA_RES=$("#insertReserva");
//CLIENTS_AC=$("#clientsAc");
INSERT_CLIENT=$("#insertClient");
REFRESH=$("#refresh");
FORM_EDIT=$("#edit");
LOADING=$("#loading");
CALEND_ZOOM=$("#zoom");
CERCADOR=$("#cercador");
// CALENDARI
monta_calendari("#calendari");
CALENDARI=$("#calendari");
RADIO_TORN=$("input[name='radio']");
/***********************************************************************************/
// ACCORDIONS

$("#loading").dialog({	
autoOpen: true,
width:248,
height:38,
modal:true,
resizable:false,
dialogClass: 'noTitleStuff'
}); 



$.ajax({url: "gestor_reserves.php?a=init&b="+CALENDARI.val(),success:function(resposta){
	RESERVES_AC=$("#reservesAc",TABS); 
	CLIENTS_AC=$( "#clientsAc",TABS);
        RESERVES_AC.accordion(acopres);
        procesaResposta(resposta);
        RESERVES_AC.show('fade');
        return false;
} });
	
comprova_backup();
$(document).everyTime(BACKUP_INTERVAL,'backup' ,comprova_backup);
$("input[name='confirma_data']","#frm_edit_modal_inserta_res").button();

controlNumMobil();
if (permisos<64) $(".sense-numero").hide();

$("#resetCercaRes").click(function(){
	$("#autoc_reserves_accordion",CERCADOR).removeClass("cercador-actiu");
	$("#autoc_reserves_accordion",CERCADOR).val("");
       
        $.ajax({url: "gestor_reserves.php?a=canvi_data&p="+CALENDARI.val()+"&q=0",success:procesaResposta});
        LOADING.dialog("open");
	//cercaReserves("");
	return false;
});



/***********************************************************************************/
// MONTA FLASH

var flashvars={};
flashvars['DEBUG']=DEBUG;
flashvars['URL']=url_base;
flashvars['DATA']=0;// NO S'UTILITZA
flashvars['TORN']=0;// NO S'UTILITZA

var params = {
  wmode: "opaque"
};
var so = swfobject.embedSWF('MenjadorEditor.swf', 'flash', '760', '740', '9.0', '#FFFFFF',flashvars,params);

/***********************************************************************************/
// FILTRE RES

$("#filtreRes").change(function(e){
    /*
		$("#autoc_reserves_accordion",CERCADOR).autocomplete("gestor_reserves.php?a=autocomplete_reserves",{cacheLength:1,minChars:4});
		$("#autoc_reserves_accordion",CERCADOR).setOptions({extraParams:{t:new Date()}});
		$("#autoc_reserves_accordion",CERCADOR).flushCache();
		*/

			if ($("#filtreRes").val()==4) 
			{
				$("#filtreRes").val(FILTRE_RES);
				var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=900, height=650, top=85, left=50";				
				popup=window.open("DBTable/LlistatClient.php","",opciones );
				if (window.focus) {popup.focus();}				
				e.preventDefault();
				return false;
			}
			if ($("#filtreRes").val()==3)
			{
				$("#filtreRes").val(FILTRE_RES);
				var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=900, height=650, top=85, left=50";				
				data=CALENDARI.val();
				popup=window.open( "cercador.php?data1="+data+"&data2=31/12/2050&torn1=1&torn2=1&torn3=1&del=0&act=0","",opciones );
				//else popup.open();
				if (window.focus) {popup.focus();}				
				e.preventDefault();
				return false;			
			}
			else 
			{
				$.ajax({url: "gestor_reserves.php?a=canvi_modo&p="+$("#filtreRes").val(),success:procesaResposta});
				FILTRE_RES=$("#filtreRes").val();
			}
			
		return false;	
	});

// FILTRE CLI
$("#filtreCli").change(function(e){
			if ($("#filtreCli").val()==3) 
			{
				$("#filtreCli").val(FILTRE_CLI);
				var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=900, height=650, top=85, left=50";				
				popup=window.open("DBTable/LlistatClient.php","",opciones );
				if (window.focus) {popup.focus();}				
				e.preventDefault();
				return false;
			}
			else 
			{
				FILTRE_CLI=$("#filtreCli").val();
                                $.ajax({url: "gestor_reserves.php?a=canvi_modo&p="+FILTRE_CLI,success:procesaResposta});				
			}
                        
                        return false;
	});

	
/***********************************************************************************/
// REFRESH
	
timer(true);
$("#bt_refresh").click(function(e){
       e.preventDefault();
        $.ajax({url: "gestor_reserves.php?a=canvi_data&p="+CALENDARI.val()+"&q=0",success:procesaResposta});
        LOADING.dialog("open");        e.preventDefault();
        FLASH.canviData(CALENDARI.val());
	return false;
});


/***********************************************************************************/
// AMAGA BT NOVA RESERVA
$("#novaReserva").hide();

/***********************************************************************************/

$("#selectorComensals").buttonset();
$("#selectorDinarSopar").buttonset();
$("#selectorCotxets").buttonset();
$("#selectorCotxets","#frm_edit_modal_inserta_res").buttonset();
$("#selectorCadiraRodes").buttonset();
$("#selectorNens4_9").buttonset();
$("#selectorNens10_14").buttonset();
$("#selectorAdults").buttonset();
$("#finde").button();

$("#selectorComensals").change(cercaTaula);
$("#selectorDinarSopar").change(cercaTaula);
$("#selectorCotxets").change(cercaTaula);
$("#finde").change(cercaTaula);
/**/
$("#selectorNens4_9").change(botonera_nens4_9);
$("#selectorNens10_14").change(botonera_nens10_14);
$("#selectorAdults").change(botonera_adults);

$("#frm_edit_modal_inserta_res #selectorCotxets").change(function(){
	if(!$(this).val()) $("input[name=cotxets]").val(1);
	
});



/***********************************************************************************/
// TORNS
$( "#torn"+torn_session ).prop("checked","true");

$( "#radio" ).buttonset();
RADIO=$( "#radio" );


RADIO.change(function(e){ 
    FLASH.canviData(CALENDARI.val());
    $("#loading").dialog('open');
    $.ajax({url: "gestor_reserves.php?a=canvi_torn&p="+$("input[name='radio']:checked").val(), success:procesaResposta});
    cercaTaula();
    
    return false;
});


/***********************************************************************************/
// TABS CLIENTS / RESERVES 
$("#tabs").tabs();
TABS=$("#tabs");    
/***********************************************************************************/
//DIALOG INSERT reserva
	$('#insertReserva').dialog({
		autoOpen: false,
		modal:true,
		width: 1000,
		height:700,
		open:function(){guardat=false;},
		close:function(){
			timer(true);
			if (guardat) return;
			$.post("gestor_reserves.php?a=bloqueig_taula&p="+TAULA+"&q=1");
                },
		buttons: {
			"Guarda": function() { 
				guardat=true;
				if (!$("form.inserta_res").validate().form()) return;
				//RESERVES_AC.accordion('destroy');
				$('form.inserta_res').ajaxSubmit({success:procesaResposta});			
                                LOADING.dialog("open");
				$(this).dialog("close"); 
				timer(true);
                                //FLASH.canviData(CALENDARI.val());
				return false;
			}
		}
	});
        
        FORMULARI_INSERTA_RES=$('#insertReserva');
/***********************************************************************************/
// DIALOG EDIT CLI / RES
$('#edit').dialog({
	autoOpen: false,
	width: 1000,
	height:700,
	modal:true,
	close:function(){timer(true);},
	buttons: {
		"Guarda": function() { 
			if ($('#edit form').hasClass("updata_res",FORM_EDIT))
			{
				if (permuta && $("#extendre input:checked",FORM_EDIT).val()==1) permuta=permuta;
				else if (!$("form.updata_res",FORM_EDIT).validate().form()) return ;
		
                                $('form',FORM_EDIT).ajaxSubmit({success:procesaResposta});
                                //FLASH.canviData(CALENDARI.val());
				if (permuta) 	
				{
					FLASH.buidaSafata();	
				}
			}
			else
			{
				if (!$("form.updata_cli",FORM_EDIT).validate().form()) return;
				$("form.updata_cli",FORM_EDIT).ajaxSubmit({success:procesaResposta});					
			}
			LOADING.dialog("open");
			$(this).dialog("close"); 
			timer(true);
		}, 
		"Elimina": function() { 
			if ($('#edit form').hasClass("updata_res",FORM_EDIT))
			{
				var id=$("form.updata_res input[name=id_reserva]",FORM_EDIT).val();		
				deleteReserva(id);
			}
			else
			{
				//var id=$("form.updata_cli input[name=client_id]",FORM_EDIT).val();
				//eliminaClient(id);
                                alert("No pots eliminar un client que té resrves vinculades");
			}

			
			
			
			LOADING.dialog("open");
			$(this).dialog("close"); 
			timer(true);
		
		}, 
	}
});
FORM_EDIT=$('#edit');

$("#dlg_cercador").dialog({	
autoOpen: false,
width:900,
height:650,
////
close:function(){alert("CERCADOR");timer(true);},
modal:true
}); 

if (permisos<31)
{
	var buttons = FORM_EDIT.dialog( "option", "buttons" );
	delete buttons.Elimina;
	FORM_EDIT.dialog( "option", "buttons", buttons );
}
/***********************************************************************************/
/***********************************************************************************/
// NOU CLI CLICK
$('#nouClient').click(function(){
    alert("NOU CLIIII");////
	timer(false);
	$('#insertClient').dialog('open');
	$("form.inserta_cli").validate().resetForm();	
});

/**********************************************************************************
// VALIDATORS INSERT RES / CLI
jQuery.validator.setDefaults({ 
    messages: {required:'Has d´omplir aquest camp'} 
});
     */
var validator_inserta_cli=$("form.inserta_cli").validate();
var validator_inserta_res=$("form.inserta_res").validate();
	
	
/***********************************************************************************/


/***********************************************************************************/
// combo cli a INSERT RESERVA
$(".combo_clients",FORMULARI_INSERTA_RES).change(function(e){
    alert("COMBOOOOO");////
        var id=$(this).val();
        var desti="gestor_reserves.php?a=htmlDadesClient&p="+ id;
});


/***********************************************************************************/
// NOU CLIENT
$('.nouClient').click(function(){
	timer(false);

	$('#insertClient').dialog('open');
	$("form.inserta_cli").validate().resetForm();
});
	
jQuery.validator.addMethod("client", function(value, element) { 
	var re = new RegExp("\([0-9]+ - [0-9]*\)");
	return value.match(re);
});

jQuery.validator.addMethod("personesInsert", function(value, element) {
	var total=0;
	
	if ($("form.updata_res").html())
	{
		total=0+Number($("input[name=adults]",FORM_EDIT).val())+Number($(".updata_res input[name=nens4_9]").val())+Number($(".updata_res input[name=nens10_14]").val());
		if (Number($("input[name=cotxets]",FORM_EDIT).val()) > C) return false;
		
	}
	else
	{
		total=0+Number($(".inserta_res input[name=adults]",FORMULARI_INSERTA_RES).val())+Number($(".inserta_res input[name=nens4_9]").val())+Number($(".inserta_res input[name=nens10_14]").val());
		if (Number($(".inserta_res input[name=cotxets]",FORMULARI_INSERTA_RES).val()) > C) return false;
	}
	
	if(total==0) return false;
	
	var valid=false;
	if (F==1 || F=="1")
	{
		valid = (total==P);
	}
	else
	{
		valid = (total<=P);
	}
	if (!valid)
	{	
			alert("El nombre de comensals no s'adapta a la taula seleccionada. Pots seleccionar una altra taula o modificar el nombre de comansals per solucionar-ho");
			return false;
	}

	
	return valid;
},"El nombre de persones / cotxets no és adequat per aquesta taula");



	$("#frm_edit_modal_inserta_res input[persones]").change(calcula_adults);	

	upercase("body ");
	$("#flash").hide();

	$("#bt_print").click(function(e)
	{
		FLASH.print();	
                e.preventDefault();
	});
	
	
	$("#dreta").fadeIn("slow");
	//if (controlaSopars()) $.ajax({url: "gestor_reserves.php?a=canvi_torn&p="+$("input[name='radio']:checked").val(),success:procesaResposta});
         //$(document).everyTime(REFRESH_INTERVAL,'refresh2' ,function(){alert("TAAS")});
cb_autocompletes();

addHandlersEditCli();
}); // FINAL READY


































	
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/

function deleteReserva(id)
{
	if (confirm("Segur que vols eliminar aquesta reserva?"))
	{
		var desti="gestor_reserves.php?a=esborra_reserva&p="+id;
                $.ajax({url: desti,	success: procesaResposta});
                    //FLASH.canviData(date_session);
	}	
}

function addHandlersEditCli()
{
        FORM_UPDATA_CLI=$(".form_edit.updata_cli");
	var validator_edit=FORM_UPDATA_CLI.validate();
	upercase(".updata_cli");
        
	$(".fr",FORM_UPDATA_CLI).click(obreDetallReserva);	

	$(".garjola",FORM_UPDATA_CLI).click(function(){
		var t=/GARJOLA/i;
                var TXT_GARJOLA=$(".updata_cli .txtGarjola");
                
		var str=TXT_GARJOLA.val();
		var garjola=t.test(str);
		if (garjola)
			{
				str=str.replace('GARJOLA!!!!','');
				TXT_GARJOLA.val(str);
				TXT_GARJOLA.html(str);
			}
		else{
			TXT_GARJOLA.val('GARJOLA!!!! '+str);
			TXT_GARJOLA.html('GARJOLA!!!! '+str);
			
		}
		
		var desti="gestor_reserves.php?a=garjola&b="+$(".updata_cli input[name='client_mobil']",FORM_UPDATA_CLI).val()+"&c="+$(".updata_cli input[name='client_email']").val()+"&d="+ !garjola;
		$.post(desti);
		
		});
	$(".inserta_res .garjola").click(function(){
		var t=/GARJOLA/i;
                var TXT_GARJOLA=$(".inserta_res .txtGarjola");
		var str=TXT_GARJOLA.val();
		var garjola=t.test(str);
		if (garjola)
		{
			str=str.replace('GARJOLA!!!!','');
			TXT_GARJOLA.val(str);
			TXT_GARJOLA.html(str);
		}
		else{
			TXT_GARJOLA.val('GARJOLA!!!! '+str);
			TXT_GARJOLA.html('GARJOLA!!!! '+str);
			
		}
		
		var desti="gestor_reserves.php?a=garjola&b="+$("#autoc_client_inserta_res",FORMULARI_INSERTA_RES).val()+"&c="+$(".inserta_res input[name='client_email']").val()+"&d="+ !garjola;
		$.post(desti);
	});
}


function addHandlersEditReserva()
{
	var validator_edit=$(".form_edit .updata_res").validate();
	upercase(".updata_res");
	$("#autoc_client_updata_res",FORM_EDIT).attr("readonly","readonly");
	
	/***********************************************************************************/
	// RADIO HORE
	$( "#updata_res_radio",FORM_EDIT ).buttonset();
	$(".combo_clients",FORM_EDIT).change(function(e){
		var id=$(this).val();
		var desti="gestor_reserves.php?a=htmlDadesClient&p="+ id;
		
	});
	
	//SMS
	$(".form_sms",FORM_EDIT).hide();
	$(".sms",FORM_EDIT).click(function(){$(".form_sms").toggle();});
	$("#enviaSMS",FORM_EDIT).click(function(){
		var desti=$("#enviaSMS",FORM_EDIT).attr("href");
		var mob=$("#num_mobil",FORM_EDIT).val();
		var msg=$("#sms_mensa",FORM_EDIT).val();
		var rsv=$("input[name=id_reserva]",FORM_EDIT).val();
		$.post(desti,{p:rsv,r:mob,c:msg},function(datos){$("#llista_sms",FORM_EDIT).html(datos);alert("S'ha enviat l'SMS");});
		}
	);
	
	$("#extendre",FORM_EDIT).buttonset();
	$("input[name='confirma_data']",FORM_EDIT).button();
	$("input[name='reserva_entrada']",FORM_EDIT).button();
	$("input[name='reserva_entrada']",FORM_EDIT).click(reservaEntrada); // boto reserva entrada

	$("#selectorCotxets",FORM_EDIT).buttonset();
	$("#selectorCadiraRodes",FORM_EDIT).buttonset();
	$("#selectorCotxets",FORM_EDIT).change(function(){if(!$(this).val()) $("input[name=cotxets]").val(1);});

	$(document).oneTime(3000,'missatgeLlegit' ,missatgeLlegit);
}

function reservaEntrada()
{
	// POSA EL 5e bit de reserves_info
	// 0 no han entrat
	// 1 reserva entrada
	// ho passa al gestor per ajax (taulaEntrada(idr,estat))
	
	var actiu=false;
	var val=false;
	var des=false;
	
	actiu=$("input[name='reserva_entrada']",FORM_EDIT).prop('checked');
	actiu=actiu?1:0;
	
	val=$("input[name=reserva_info]",FORM_EDIT).val();
	des = (val & ~(1 << 5)) | ((!!actiu) << 5);
	$("input[name=reserva_info]",FORM_EDIT).val(des);

	// AJAX
	var idRes=$("input[name=id_reserva]",FORM_EDIT).val();
	var desti="gestor_reserves.php?a=taulaEntrada&b="+idRes;
	$.post(desti,{b:idRes,c:des});
}

function missatgeLlegit()
{
		if (timeractiu) return false;
		
		var idRes=$("input[name=id_reserva]",FORM_EDIT).val();
 		var desti="gestor_reserves.php?a=missatgeLlegit&b="+idRes;
		$.post(desti,{b:idRes},function(datos){
                    $("#rnode_"+idRes+" div.ui-icon-mail-closed",RESERVES_AC).addClass("ui-icon-mail-open");
                    $("#rnode_"+idRes+" div.ui-icon-mail-closed",RESERVES_AC).removeClass("ui-icon-mail-closed");
                });
}

function obreDetallReserva(e)
{
		var desti=$(this).attr("href");
		var data=$(this).attr("data");
		FORM_EDIT.html('<div class="bg-loading"></div>');
		timer(false);
		LOADING.dialog('open');

		if (data)	CALEND.datepicker("setDate",data );
		$.ajax({url: desti,	success: function(datos){
			FORM_EDIT.html(decodeURIComponent(datos));
                        FORM_EDIT=$("#edit");
                        addHandlersEditReserva();
                        var trn=$("form.updata_res input[name=torn_session]").val();
                        $("#torn"+trn).prop("checked",true);
                        $("#torn"+trn).button("refresh");
                        LOADING.dialog('close');
                        FORM_EDIT.dialog('open');
                    }		
		});
		
		e.preventDefault();
}

function FROM_CERCADOR_obreDetallReserva(id,data,torn)////FALTAAAAA
{
		popup.close();
		CALEND.datepicker("setDate",data );
		if (CALEND.val()!=data) return alert("Aquesta reserva és d'una data passada.\nNo és possible editar-la perquè estàs treballant amb calendari futur.\n\nUtilitza l'històric per consultar-la");
		timer(false);
		FORM_EDIT.dialog('open');
		FORM_EDIT.html('<div class="bg-loading"></div>');
                $("#torn"+torn).prop("checked",true);
                $("#torn"+torn).button("refresh");
                FLASH.canviData(CALEND.val());
		$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+CALEND.val()+"&q="+torn,success:function(resposta){
					procesaResposta(resposta);
					var desti="form_reserva.php?edit="+id+"&id="+id;
					$.ajax({url: desti,	success: function(datos){
                                                                FORM_EDIT.html(decodeURIComponent(datos));
                                                                FORM_EDIT=$("#edit");
								//recargaAccordioReserves();					
								addHandlersEditReserva();						
							 }		
					})
                                    }});
}

function onNovaReserva()
{
	$(".sense-numero").html("Sense número");
	timer(false);
	max_comensals=0;
	FORM_EDIT.html("");
	$(".updata_res",FORM_EDIT).html("");
        
	//$("input[name=client_mobil]",FORMULARI_INSERTA_RES).focus();
        //alert("dddd");
        $("form.inserta_res",FORMULARI_INSERTA_RES).validate().resetForm();
	$("form.inserta_res_radio input[name='client_id']",FORMULARI_INSERTA_RES).val("");
	$("form.inserta_res_radio input[name='client_id']",FORMULARI_INSERTA_RES).attr("class","{required:true}");
	
	$("#inserta_res_radio",FORMULARI_INSERTA_RES).html("");
	$("form.inserta_res",FORMULARI_INSERTA_RES).validate().resetForm();
	$("input[name=adults]",FORMULARI_INSERTA_RES).val("");
	$("input[name=nen4_9]",FORMULARI_INSERTA_RES).val("");
	$("input[name=nen10_14]",FORMULARI_INSERTA_RES).val("");
	$("input[name=total]",FORMULARI_INSERTA_RES).val("");
	$("input[name=cotxets]",FORMULARI_INSERTA_RES).val("");
	$("input[name=observacions]",FORMULARI_INSERTA_RES).val("");
	$("input[name=resposta]",FORMULARI_INSERTA_RES).val("");
	$("input[name='data']",FORMULARI_INSERTA_RES).val(CALEND.val());
	var stDate="--";
	stDate=$.datepicker.parseDate('dd/mm/yy',CALEND.val());
	stDate=$.datepicker.formatDate("DD d 'de' MM 'de' yy", stDate);
	$("span.data-llarga",FORMULARI_INSERTA_RES).html(stDate);
	$(".combo_clients",FORMULARI_INSERTA_RES).val(client);
	$(".combo_clients",FORMULARI_INSERTA_RES).trigger('change');
	
	
	$("input[name=total]",FORMULARI_INSERTA_RES).rules("add",{personesInsert:true});
	$("#confirma_data_inserta_res",FORMULARI_INSERTA_RES).rules("add",{required:true});
	
	var hora=$("input[name='hora']:checked",CALEND_ZOOM  ).val();
	if (hora==null)
	{
		hora=0;
                $("#loading").dialog('open');
		$.ajax({url: "gestor_reserves.php?a=prepara_insert_dialog&b="+TAULA+"&c="+P+"&d="+C,	success: procesaResposta});
	}	
	else
	{
		alert("HORAAAAAAAAA");
		var input='<input type="text" name="hora"  value="'+hora+'" size="3" readonly="readonly" class="{required:true}" title=""/>';
		$("#inserta_res_radio",FORMULARI_INSERTA_RES).html(input);
	}
};

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function fromDialog_novaReserva(taula,n,p,c,f)
{
	if (!validaData()) return;
	CERCA=0;
	$("#selectorAdults",FORMULARI_INSERTA_RES).show();
	onNovaReserva();
	
	P=p;
	C=c;
	F=f;
	TAULA=taula;
	$(".taulaid",FORMULARI_INSERTA_RES).val(taula);
	$(".taulanom",FORMULARI_INSERTA_RES).val(n);
	$(".places",FORMULARI_INSERTA_RES).html(p);
	$(".cotxets",FORMULARI_INSERTA_RES).html(c);
	$(".plena",FORMULARI_INSERTA_RES).html((f?"si":"no"));
	$("input[name='hora']:checked",CALEND_ZOOM).prop('checked', false);
}


function upercase(selector)
{
	/** UPPERCASE **/
	$(selector+'  input').not('input[readonly]').bestupper(); 
	$(selector+'  textarea').bestupper(); 
}

function comprova_backup()
{ 
	var desti="gestor_reserves.php?a=reserves_orfanes";
	$.post(desti,{r:rand},function(datos){
		if (datos) alert("ATENCIO!!!\nS'han detectat reserves perdudes: Per més detalls, ves al Panel de control > Eines avançades > Reserves perdudes"); 
	});
        
	if (!BACKUP_INTERVAL) return false;
        
        var d = new Date();
        var rand = d.getTime();
	var desti="dumpBD.php?drop&file";
	$.post(desti,{r:rand},function(datos){
		if (datos=="backup" && permisos>64) alert("S'ha realitzat una còpia de la base de dades");
                //return false;
	});

	var desti="esborra_clients_llei.php";
	$.post(desti,function(datos){return false;});
}

function comprova_refresh()
{  
    var d = new Date();
    var rand = d.getTime();
    var desti="gestor_reserves.php?a=refresh&r="+rand;
    $.post(desti,{r:rand},procesaResposta);
    var img=$("#imgCalendari",CALEND_ZOOM).attr("src").split("?")[0];
    $("#imgCalendari",CALEND_ZOOM).attr("src", img+"?" + rand);	
    REFRESH.slideDown().delay(500).slideUp();
    timer(true);
};

function timer(activa)
{
	debug(activa?"ON":"OFF");
	
	$(document).stopTime('refresh');
       // alert("ACTIVA: "+activa+REFRESH_INTERVAL);
	if (activa) $(document).everyTime(REFRESH_INTERVAL,'refresh' ,comprova_refresh);
	
	timeractiu=activa;
}

function validaData()
{
	var d=CALENDARI.datepicker("getDate");
	d.setHours(23);
	d.setMinutes(59);
	d.setSeconds(59);
	if (d< new Date())
	{
		alert("Estàs intentant editar un dia del passat");
		if (permisos<64) return false;
	}
	return true;
}

/** AUTOCOMPLETE */
function actualitza_combo_clients(id)
{
		$(".autoc_id_client",FORM_EDIT).val(id);
}	


function controlaSopars()
{
		var dia=CALENDARI.datepicker("getDate").getDay();
		var torn=$("input[name='radio']:checked",CALEND_ZOOM).val();

		if ( !AR__NITS_OBERT[dia] && !excepcions_nits(CALENDARI.datepicker("getDate"))) 
		{
			$("#lblTorn3",CALEND_ZOOM).hide();	
			if (torn==3)
			{
				torn=1;
				RADIO_TORN.prop("checked",false);
				$("#torn1",CALEND_ZOOM).prop("checked",true);
				RADIO_TORN.button("refresh");
				if (FLASH) FLASH.canviData(CALENDARI.val());
				return 1;
			}
		}
		else  $("#lblTorn3").show();
		
		return 0;
}

function excepcions_nits(date){
	/*
	var dia=date.getDate();
	var mes=date.getMonth();
	
	if (dia==14 && mes==11) return true;
	if (dia==21 && mes==11) return true;
	*/
	return false;
}

function cercaReserves(s)////FALTAAA
{
	RESERVES_AC.hide();
	try{RESERVES_AC.accordion('destroy');}catch(err){};
	RESERVES_AC.html('<img src="css/loading_llarg.gif" class="loading_llarg"/>');
        
	if (s && s!="" && s!="Cerca..." ) s="&c="+s;
	
	$.ajax({url: "gestor_reserves.php?a=cerca_reserves"+s,success: procesaResposta});	
}


function cercaTaula()
{
	var p=$("#selectorComensals input:checked",CALEND_ZOOM).val();
	if (!p) return;
        
	var q=$("#selectorCotxets input:checked",CALEND_ZOOM).val();
	var r=$("#selectorFinde input:checked",CALEND_ZOOM).val()=="on"?"1":"0";
	$("#cercaTaulaResult",CALEND_ZOOM).html('<img class="loading" src="css/loading.gif" />');
	$.ajax({url:"gestor_reserves.php?a=cerca_taula&p="+p+"&q="+q+"&r="+r,success:function(dades){
			$("#cercaTaulaResult",CALEND_ZOOM).html(dades);
			$("#cercaTaulaResult a",CALEND_ZOOM).click(function(e){
				
					TAULA=$(this).attr("href");
					N=$(this).attr("n");
					P=$(this).attr("p");
					C=$(this).attr("c");
					F=$(this).attr("f");
					fromDialog_novaReserva(TAULA,N,P,C,F);
					$("input[name=adults]",FORMULARI_INSERTA_RES).val(P);
					$("input[name=total]",FORMULARI_INSERTA_RES).val(P);
					CERCA=P;
					$("#selectorAdults",CALEND_ZOOM).hide();
                                        e.preventDefault();
				});	
		}});
}
/**/
function botonera_adults(e)
{
        $("#debug_out").html(++clk);
        $("input[name=adults]",FORMULARI_INSERTA_RES).val(++clk);
        
	if ($("#selectorAdults input:checked",FORMULARI_INSERTA_RES).val()) $("input[name=adults]",FORMULARI_INSERTA_RES).val($("#selectorAdults input:checked",FORMULARI_INSERTA_RES).val());	
	$("#selectorAdults input:checked",FORMULARI_INSERTA_RES).prop("checked",false);
	$("#selectorAdults input",FORMULARI_INSERTA_RES).button("refresh");
	calcula_adults(e);
}
function botonera_nens4_9(e)
{
	if ($("#selectorNens4_9 input:checked",FORMULARI_INSERTA_RES).val()) $("input[name=nens4_9]",FORMULARI_INSERTA_RES).val($("#selectorNens4_9 input:checked",FORMULARI_INSERTA_RES).val());	
	$("#selectorNens4_9 input:checked",FORMULARI_INSERTA_RES).prop("checked",false);
	$("#selectorNens4_9 input",FORMULARI_INSERTA_RES).button("refresh");
	calcula_adults(e);
}
function botonera_nens10_14(e)
{
	if ($("#selectorNens10_14 input:checked",FORMULARI_INSERTA_RES).val()) $("input[name=nens10_14]",FORMULARI_INSERTA_RES).val($("#selectorNens10_14 input:checked",FORMULARI_INSERTA_RES).val());	
	$("#selectorNens10_14 input:checked",FORMULARI_INSERTA_RES).prop("checked",false);
	$("#selectorNens10_14 input",FORMULARI_INSERTA_RES).button("refresh");
	calcula_adults(e);
}
function calcula_adults(e){		
		$("input[persones]",FORMULARI_INSERTA_RES).unbind("change");
		var total=0+Number($("input[name=adults]",FORMULARI_INSERTA_RES).val())+Number($("input[name=nens4_9]",FORMULARI_INSERTA_RES).val())+Number($("input[name=nens10_14]",FORMULARI_INSERTA_RES).val());
		
		if (CERCA) 
		{
			var aux=CERCA-$("input[name=nens4_9]",FORMULARI_INSERTA_RES).val();
			aux-=$("input[name=nens10_14]",FORMULARI_INSERTA_RES).val();		
			$("input[name=adults]",FORMULARI_INSERTA_RES).val(aux);
			
			$("input[name=total]",FORMULARI_INSERTA_RES).val(total);				
		}
		else
		{
			if (total>P) 
			{
				var N=Number($("input[name=adults]",FORMULARI_INSERTA_RES).val());
				var N4=Number($("input[name=nens4_9]",FORMULARI_INSERTA_RES).val());
				var N10=Number($("input[name=nens10_14]",FORMULARI_INSERTA_RES).val());
				var Q=N+N4+N10;
				
				var aux=P-N4;
				aux-=N10;		
				$("input[name=total]",FORMULARI_INSERTA_RES).val(total);				
				alert("El nombre de persones ("+Q+") és massa gran per aquesta taula ("+P+").\n\nES REDUIRÀ AUTOMÀTICAMENT EL NOMBRE D'ADULTS A "+aux);
				$("input[name=adults]",FORMULARI_INSERTA_RES).val(aux);
				$("input[name=total]",FORMULARI_INSERTA_RES).val(total);				
			}
		}
		
		var total=0+Number($("input[name=adults]",FORMULARI_INSERTA_RES).val())+Number($("input[name=nens4_9]",FORMULARI_INSERTA_RES).val())+Number($("input[name=nens10_14]",FORMULARI_INSERTA_RES).val());
		$("input[name=total]",FORMULARI_INSERTA_RES).val(total);		
		$("input[persones]",FORMULARI_INSERTA_RES).bind("change",calcula_adults);
	}

function controlNumMobil()
{
	$(".sense-numero",FORMULARI_INSERTA_RES).click(function(){
		if ($("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).is(":visible")) 
		{
			$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).hide();
			$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).val("999999999");
			if ($("#campsClient input[name='client_nom']",FORMULARI_INSERTA_RES).val()=="") $("#campsClient input[name='client_nom']",FORMULARI_INSERTA_RES).val("SENSE_NOM");
			$(".sense-numero",FORMULARI_INSERTA_RES).html("Introduïr número");
			$("#campsClient input[name='client_cognoms']",FORMULARI_INSERTA_RES).focus();
			
		}
		else 
		{
			$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).val("");
			$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).show();
			$(".sense-numero",FORMULARI_INSERTA_RES).html("Sense número");	
		}
	});
}
	
function debug(text)
{
	$("#debug_out").html(text);
}