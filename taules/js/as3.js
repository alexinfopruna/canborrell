function getFlashMovie(movieName) {
	var isIE = navigator.appName.indexOf("Microsoft") != -1;
	var ret= (isIE) ? window[movieName] : document[movieName];
	return ret;
}


function fromAS3_print()
{
	window.location="print.php?p";
}

function fromAS3_flash_ready()
{
    //alert("ee");
    FLASH=getFlashMovie("flash");
    FLASH.canviData(date_session);	
    //$("#flash").show();
    LOADING.dialog("close");

}

function fromAS3_novaReserva(taula,n,p,c,f)
{
	
	//$(".dades_client").hide();
	//$(".dades_client").html("");
	TAULA=taula;
	N=n;
	P=p;
	C=c;
	F=f;
	
	var dta=CALENDARI.datepicker("getDate");
	
	dtb=$.datepicker.formatDate("DD, d 'de' MM 'del' yy", dta, {dayNamesShort: $.datepicker.regional['ca'].dayNamesShort, dayNames: $.datepicker.regional['ca'].dayNames, monthNamesShort: $.datepicker.regional['ca'].monthNamesShort, monthNAmes: $.datepicker.regional['ca'].monthNames});
	
	var torn=$("input[name='radio']:checked").val();
	$("#confirma_data_dia",FORMULARI_INSERTA_RES).html(dtb);
	$("#confirma_data_torn",FORMULARI_INSERTA_RES).html(torn);
	
	fromDialog_novaReserva(TAULA,N,P,C,F);

	
	$("#calendari_confirma",FORMULARI_INSERTA_RES).datepicker("destroy");
	canvia_data_confirma=false;
	
	
}

function fromAS3_editReserva(id,n,p,c,f)
{
	var setHora="";
	
	if (!validaData()) return;
	permuta=0;
	if (n==-1) permuta=c;
	
	var hora=$("input[name='hora']:checked",CALEND_ZOOM).val();
	$("input[name='hora']:checked",CALEND_ZOOM).prop('checked', false);
	$("input[name='hora']:checked",CALEND_ZOOM).val("");
	if (hora!="" && hora!=null) setHora="&hora="+hora;
	
	var desti="form_reserva.php?edit="+id+"&id="+id+"&permuta="+permuta+setHora;
	//$("#edit").html('<div class="loading"></div>');
	timer(false);
	//$('#edit').dialog('open');
	//FORM_EDIT.html('<div class="bg-loading"></div>');
	LOADING.dialog('open');
        
	$.ajax({url: desti,	success: function(datos){
			FORM_EDIT.html(decodeURIComponent(datos));
                        FORM_EDIT=$("#edit");
			addHandlersEditReserva();
			//addHandlersEditCli();
			$(".missatge_dia",FORM_EDIT).html($("#ta_missatge_dia",FORM_EDIT).val());
			P=$(".places",FORM_EDIT).html();
			C=$(".cotxets",FORM_EDIT).html();
			F=$(".plena",FORM_EDIT).html();
		
			$("form.updata_res",FORM_EDIT).validate();
			$("input[name=total]",FORM_EDIT).rules("add",{personesInsert:true});
			$("input[persones]",FORM_EDIT).change(function(){
				var total=0+Number($("input[name=adults]",FORM_EDIT).val())+Number($("input[name=nens4_9]",FORM_EDIT).val())+Number($(".updata_res input[name=nens10_14]").val());
				$("input[name=total]",FORM_EDIT).val(total);
	
			});
				
			if (permuta) 
			{
				$(".updata_res input[name=cb_sms]").prop("checked",false);	
			}
			
                        LOADING.dialog('close');
			FORM_EDIT.dialog('open');
		 }		
	});
	e.preventDefault();
}

function fromAS3_permuta(orig,desti,res)
{
	fromAS3_editReserva(res,-1,orig,desti,0);
}

function fromAS3_canviData_ready()
{
	$( "#radio input",CALEND_ZOOM ).button( "enable" );CALENDARI.datepicker("enable");	
	CALEND_ZOOM.removeClass("calendari-loading");    

}