
$(function(){

	$('#confirma_data').dialog({
		autoOpen: false,
		modal:true,
		width: 500,
		height: 500,
		buttons: {
			"Confirma": function() { 
				$(this).dialog("close"); 
				$("#calendari").datepicker("destroy");
				monta_calendari("#calendari");
				if (!canvia_data_confirma) fromDialog_novaReserva(TAULA,N,P,C,F);
				else alert("Has canviat la data!, Comprova el menjador i el torn");
				//refresh();
				//timer(true);


			}
		}
	});

	
	
	
	
	
});


function fromAS3_novaReserva(taula,n,p,c,f)
{
	
fromDialog_novaReserva(taula,n,p,c,f);	
	
	TAULA=taula;
	N=n;
	P=p;
	C=c;
	F=f;
	
	var dta=$("#calendari").datepicker("getDate");
	
	dtb=$.datepicker.formatDate("DD, d 'de' MM 'del' yy", dta, {dayNamesShort: $.datepicker.regional['ca'].dayNamesShort, dayNames: $.datepicker.regional['ca'].dayNames, monthNamesShort: $.datepicker.regional['ca'].monthNamesShort, monthNAmes: $.datepicker.regional['ca'].monthNames});
	
	var torn=$("input[name='radio']:checked").val();
	$("#confirma_data_dia").html(dtb);
	$("#confirma_data_torn").html(torn);
	$('#confirma_data').dialog("open");
	
	$("#calendari_confirma").datepicker("destroy");
	canvia_data_confirma=false;
	monta_calendari("#calendari_confirma");
	
	
}

/*
		
		if ($(this).attr("id")=="calendari") 
		{
			alert("1111 "+$("#calendari").val());
			//$("#calendari_confirma").val($("#calendari").val());
			$("#calendari_confirma").val("25/06/2011");
			$("#calendari_confirma").refresh();
		}
		
		if ($(this).attr("id")=="calendari_confirma") 
		{
			alert("2222 "+$("#calendari_confirma").val());
			//$("#calendari").val($("#calendari_confirma").val());
//			var myDate = new Date();
//var prettyDate = myDate.getDate()+ '/' + (myDate.getMonth()+1) + '/' + myDate.getFullYear();
//$("#calendari").val("20/06/2011");
$("#calendari").val("20/06/2011");
			//$( "#calendari" ).datepicker( "option", "defaultDate", new Date() );
			//$("#calendari").val("25/06/2011");
			alert("bbb "+$("#calendari").val());
			
			$("#calendari").refresh();
		}


*/