var zoom=false;

$(function(){    
	$('#form_missatge_dia').dialog({
		autoOpen: false,
		modal:true,
		width: 600,
		buttons: {
			"Actualitza": function() { 
				$(this).dialog("close"); 
				refresh();
				timer(true);
				guarda_missatge_dia();
			}, 
			"Tanca": function() { 
				$(this).dialog("close"); 
				timer(true);
			} 
		}
	});
	
	
	$("#menu_missatge_dia a").click(function(){
		//$("#ta_missatge_dia").val("");
		timer(false);
		$('#form_missatge_dia').dialog("open");
		return false;
	});
	
	$(".calendari",CALEND_ZOOM).hide();
	$("#radio",CALEND_ZOOM).hide();
	$("#radio_hores_calend",CALEND_ZOOM).hide();
	$("#totals-torn",CALEND_ZOOM).hide();
	
	
// ZOOM CALENDARI
            CALEND_ZOOM.mouseenter(zoomon);
	$("#radio_hores_calend",CALEND_ZOOM).mouseup(zoomoff);
        ZOOM_COMENSALS=$("#selectorComensals",CALEND_ZOOM);
        ZOOM_COTXETS=$("#selectorCotxets",CALEND_ZOOM);
    	return false;
});

function guarda_missatge_dia()
{
	var desti=$("#menu_missatge_dia a").attr("href");
	$.post(desti, { p: $("#ta_missatge_dia").val() },
	   function(data) {
		 	$('.missatge_dia').html(data);
	   });
	return false;
}

function zoomon()
{		
	CALEND_ZOOM.unbind();
	CALEND_ZOOM.mouseleave(zoomoff);
	var currentMonth=new Date().getMonth()+1;	
	var comprovaMes= !$("#zoom .calendari").is(':visible');
	//avui(); // ANULAT RECULA AVUI
	
	
	CALEND_ZOOM.removeClass("zoompetit");
	CALEND_ZOOM.addClass("zoom");
	$("img",CALEND_ZOOM).hide();
	$(".comensals",CALEND_ZOOM).hide();
	$(".calendari",CALEND_ZOOM).show();
	$("#totals-torn",CALEND_ZOOM).show();
	ZOOM_COTXETS.show();
	$("#radio").show();
        RADIO.show();
        
	ZOOM_COMENSALS.show();
	$("input[name='hora']:checked",CALEND_ZOOM).attr('checked', false);
	$("#radio_hores_calend input[name='hora']",CALEND_ZOOM).button("refresh");
	$("td.ui-datepicker-today a.ui-state-highlight",CALEND_ZOOM).removeClass("ui-state-highlight");
	
	//ALEX ANULAT MES CORRENT if (comprovaMes && currentMonth != $("#calendari").val().split("/")[1]) alert("ATENCIO: NO ÉS EL MES CORRENT");
	return false;
}

function zoomoff()
{
	CALEND_ZOOM.unbind();
	CALEND_ZOOM.mouseenter(zoomon);
	CALEND_ZOOM.removeClass("zoom");
	CALEND_ZOOM.addClass("zoompetit");
	$("img",CALEND_ZOOM).show();
	$(".comensals",CALEND_ZOOM).show();
	$(".calendari",CALEND_ZOOM).hide();
	$("#totals-torn",CALEND_ZOOM).hide();
	RADIO.hide();
	$("#radio_hores_calend",CALEND_ZOOM).hide();
	$("#radio_hores_calend",CALEND_ZOOM).css("display","none");
	$("input:checked",ZOOM_COMENSALS).css("font-size","3em");
	$("input:checked",ZOOM_COMENSALS).attr("checked",false);
	$("input",ZOOM_COMENSALS).button("refresh");
	$("input:checked",ZOOM_COTXETS).css("font-size","3em");
	$("input:checked",ZOOM_COTXETS).attr("checked",false);
	$("input[value=0]:checked",ZOOM_COTXETS).attr("checked",true);
	$("input",ZOOM_COTXETS).button("refresh");
	ZOOM_COMENSALS.hide();
	ZOOM_COTXETS.hide();
	$("#cercaTaulaResult",CALEND_ZOOM).html("Quants coberts?");
	
	return false;

}

function avui()
{
		var d=new Date();
		while ((d.getDay()==1 || d.getDay()==2 || llistanegra(d)) && (!llistablanca(d))) d.setDate(d.getDate()+1);
		var avui=d.getFullYear()+"-"+d.getMonth()+"-"+d.getDay();
		var c=$("#calendari").datepicker("getDate");
		c=c.getFullYear()+"-"+c.getMonth()+"-"+c.getDay();
		if(avui==c) return;
		
		$("#calendari").datepicker("setDate",d);
			$( "#reservesAc" ).accordion('destroy');
			
			var cs=controlaSopars();
			$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+$("#calendari").val()+"&q="+cs,success:recargaAccordioReserves});
			$.get("gestor_reserves.php?a=recupera_missatge_dia",function(data) {$(".missatge_dia").html(data);});
			canvia_data_confirma=true;	
			
			return false;
}


function llistanegra(date)
{

var y = date.getFullYear();
var m = date.getMonth();     // integer, 0..11
var d = date.getDate();      // integer, 1..31

var t = LLISTA_NEGRA[m];

if (!t) return false;
for (var i in t) if (t[i] == d) return true;


	return false;
}

function llistablanca(date)
{

var y = date.getFullYear();
var m = date.getMonth();     // integer, 0..11
var d = date.getDate();      // integer, 1..31

var t = LLISTA_BLANCA[m];

if (!t) return false;
for (var i in t) if (t[i] == d) return true;


	return false;
}


function monta_calendari(selector)
{
	var limit_passat=(arxiu=="del" || historic)?-10000:0;
	//limit_passat=-50000;
	$(selector).datepicker({
		defaultDate:date_session,
		beforeShowDay:function(date){		
			var r=new Array(3);
			if ((date.getDay()==1 || date.getDay()==2 || llistanegra(date)) && (!llistablanca(date)))
			{
				r[0]=false;
				r[1]="maldia";
				r[2]="Tancat";
			}
			else		
			{
				r[0]=true;
				r[1]="bondia";
				r[2]="Obert";			
			}
			return r;
		},

		minDate: limit_passat,
		onSelect: function(dateText, inst) { 
			if (ONLOAD_BLOC_TORN) $( "#radio input" ).button( "disable");	
			if (ONLOAD_BLOC_CALEND) $("#calendari").datepicker("disable");
			date_session=$(this).val();
						
			RESERVES_AC.accordion('destroy');
			RESERVES_AC.html('<img src="css/loading_llarg.gif" class="loading_llarg"/>');
			RESERVES_AC.show("fade");
			
			var cs=controlaSopars();
			FLASH.canviData($(this).val());
			$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+$(this).val()+"&q="+cs,success:procesaResposta});
			canvia_data_confirma=true;
			dtb=$.datepicker.formatDate("DD, d 'de' MM 'del' yy", $(this).datepicker("getDate"), {dayNamesShort: $.datepicker.regional['ca'].dayNamesShort, dayNames: $.datepicker.regional['ca'].dayNames, monthNamesShort: $.datepicker.regional['ca'].monthNamesShort, monthNAmes: $.datepicker.regional['ca'].monthNames});		
			cercaTaula();
		}
	});
        
        CALEND=$(selector);
        CALEND_ZOOM=$("#zoom");
        
        return false;
}