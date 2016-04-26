/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    $( "#top-datepicker" ).datepicker();
    $( "#datepicker" ).datepicker();
    $( ".tooltip" ).datepicker();
    
    $(window).on('resize', function(){
        jQuery("#container").css("margin-top",jQuery(".navbar-header").height());
    }).resize();
    
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active')
  });
});



function monta_calendari(selector)
{
    //var limit_passat=(arxiu=="del" || historic)?-10000:0;
    limit_passat = MARGE_DIES_RESERVA_ONLINE;

    if (!MARGE_DIES_RESERVA_ONLINE)
    {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        hours = hours + ":00";
        var entraAvui = (hours < MAX_HORA_RESERVA_ONLINE) ? 0 : 1;
        limit_passat = entraAvui;
    }



    var defData = null;
    if (RDATA != "")
        defData = RDATA;
    $(selector).datepicker("destroy");
    $(selector).datepicker({
        beforeShowDay: function (date, inst) {
            var r = new Array(3);
            if ((date.getDay() == 1 || date.getDay() == 2 || llistanegra(date)) && (!llistablanca(date)) || !taulaDisponible(date))
            {
                r[0] = false;
                r[1] = "maldia";
                r[2] = l("Tancat");
            }
            else
            {
                r[0] = true;
                r[1] = "bondia";
                r[2] = l("Obert");
            }
            return r;
        },
        defaultDate: defData,
        minDate: limit_passat
    });

    //CARREGA IDIOMA
    var lng = lang.substring(0, 2);
    $(selector).datepicker("option",
            $.datepicker.regional[ lng ]);

    if (!RDATA)
    {
        $('.ui-datepicker-calendar .ui-state-active').removeClass('ui-state-active');
        $('.ui-datepicker-calendar .ui-state-hover').removeClass('ui-state-hover');
    }


    /* BLOQUEJA EL DIA SI ESEM EDITANT LA RESERVA PER IMPEDIR QUE ES MODIFIQUI */
    if (typeof BLOQ_DATA !== 'undefined') {
        $(selector).datepicker("option", "minDate", BLOQ_DATA);
        $(selector).datepicker("option", "maxDate", BLOQ_DATA);
    }


}
