/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 
 * @param resposta
 * @returns
 */
function procesaResposta(resposta_raw) {
    try {
        resposta = $.parseJSON(resposta_raw);
    } catch (err) {
        resposta = {
            'resposta': 'ko',
            'error': 2,
            'error_desc': resposta_raw
        }
    }
    //resposta = JSON.parse(resposta_raw);
    LOADING.dialog('close');
    /**
     * RESPOSTA ERROR
     */
    if (resposta.resposta == "ko") {
        return procesaError(resposta);
    }

    /**
     * MISSATGE DIA
     */
    if (resposta.missatge_dia)
        $(".missatge_dia").html(resposta.missatge_dia);

    /**
     * TOTAL COBERTS
     */
    if (resposta.total_coberts_torn) {
        $(".total_torn", CALEND_ZOOM).html(resposta.total_coberts_torn.total);
        $("#total-t1", CALEND_ZOOM).html((resposta.total_coberts_torn.t1 ? '(' + resposta.total_coberts_torn.t1 + ' coberts)' : ""));
        $("#total-t2", CALEND_ZOOM).html((resposta.total_coberts_torn.t2 ? '(' + resposta.total_coberts_torn.t2 + ' coberts)' : ""));
        $("#total-t3", CALEND_ZOOM).html((resposta.total_coberts_torn.t3 ? '(' + resposta.total_coberts_torn.t3 + ' coberts)' : ""));
    }

    /**
     * ACCORDIONS
     */
    if (resposta.ac_reserves) {
        procesaAccordions(resposta.ac_reserves);

        switch (resposta.action) {
            case "cerca_reserves":
                $("#autoc_reserves_accordion", TABS).addClass("cercador-actiu");
                $("#autoc_client_accordion", TABS).addClass("cercador-actiu");
            break;

            case  "inserta_reserva":
            case  "permuta_reserva":
            case  "update_reserva":
                FLASH.canviData(CALENDARI.val());
            default:
                $("#autoc_reserves_accordion", TABS).val("");
                $("#autoc_reserves_accordion", TABS).removeClass("cercador-actiu");
                $("#autoc_client_accordion", TABS).val("");
                $("#autoc_client_accordion", TABS).removeClass("cercador-actiu");

                break;
        }
        if (resposta.action == "cerca_reserves") {
        } else {
        }
        // if (resposta.action=='inserta_reserva') FLASH.canviData(CALENDARI.val());
    }

    /**
     * DELETE
     */
    if (resposta.del_reserva) {
        var RNODE = $("#rnode_" + resposta.del_reserva, TABS);
        RNODE.next().remove();
        RNODE.remove();
        FLASH.canviData(CALENDARI.val());
        //resposta.del_reserva
        // if (resposta.action=='inserta_reserva') FLASH.canviData(CALENDARI.val());
    }

    /**
     * INSERTA *** NO FUNCIONA BE!!!
     */
    if (resposta.add_reserva) {
        ac_inserta_reserva(resposta.add_reserva);
    }

    /**
     * HORES
     */
    if (resposta.hores) {
        FORMULARI_INSERTA_RES.dialog('open');
        if (resposta.action == "prepara_insert_dialog")
            $("input[name=client_mobil]", FORMULARI_INSERTA_RES).focus();

        $("#inserta_res_radio", FORMULARI_INSERTA_RES).html(resposta.hores.dinar + resposta.hores.dinarT2 + resposta.hores.sopar);
        $("#inserta_res_radio", FORMULARI_INSERTA_RES).buttonset();
        $("#inserta_res_radio input", FORMULARI_INSERTA_RES).change(function() {
            max_comensals = $(this).attr("maxc");
        });

    }

    /**
     * REFRESH
     */
    if (resposta.action == "refresh") {
        if (resposta.no_change) {
            refresh_time = resposta.no_change;
            //alert("REFRESH");
        } else {
            FLASH.canviData(CALEND.val());
            timer(true);
        }
    }

    if (resposta.action == "init") {
        if (!FLASH)
            LOADING.dialog("open");
    }
    ;


    /**
     * ORFANES
     */
    if (resposta.orfanes) {
        alert("ATENCIO!!!\nS'han detectat reserves perdudes: Per més detalls, ves al Panel de control > Eines avançades > Reserves perdudes");
        FLASH.canviData(CALEND.val());

    }


    return false;
}

function procesaAccordions(reserves) {
    var ac_reserves = "";
    var ac_clients = "";

    try {
        RESERVES_AC.accordion('destroy');
    } catch (err) {
    }
    ;

    RESERVES_AC.html('<img src="css/loading_llarg.gif" class="loading_llarg"/>');
    RESERVES_AC.show("fade");

    /**
     * BUCLE MONTA RESERVES/CLI
     */
    if (typeof reserves['0'].data == 'undefined') {
        RESERVES_AC.html(reserves['0']);
        CLIENTS_AC.html(reserves['0']);

        return false;
    }
    else
        for (var key in reserves) {
            ac_reserves += nodeAccordionReserves(reserves[key]);
            ac_clients += nodeAccordionClients(reserves[key]);
        }

    /**
     * HANDLERS AC RESERVES
     */
    RESERVES_AC.html(ac_reserves);
    RESERVES_AC.accordion(acopres);
    //RESERVES_AC.accordion("resize");

    //$("#autoc_reserves_accordion",TABS).val("");
    //$("#autoc_reserves_accordion",TABS).removeClass("cercador-actiu");


    $(".delete a", RESERVES_AC).click(function(e)
    {
        var id = $(this).attr("del");
        deleteReserva(id);
        return false;
    });

    /**
     * HANDLERS AC CLIENTS
     */
    CLIENTS_AC.html(ac_clients);
    $(".fc", CLIENTS_AC).click(function(e) {
        var desti = $(this).attr("href");
        FORM_EDIT.html('<div class="bg-loading"></div>');


        timer(false);
        FORM_EDIT.dialog('open');
        $.ajax({url: desti, success: function(datos) {
                FORM_EDIT.html(decodeURIComponent(datos));
                FORM_EDIT = $('#edit');
                // $("button:nth-child(2)",FORM_EDIT).remove();
                addHandlersEditCli();
                //onClickAmpliaReserva();
            }
        });

        e.preventDefault();
        return false;
    });

    //$(".delete a",CLIENTS_AC).click(function(e){	var id=$(this).attr("del");eliminaClient(id);});
    $(".fr", TABS).unbind();

    $(".fr", TABS).mouseover(function() {
        taulaSel = $(this).attr("taula");
        FLASH.seleccionaTaula(taulaSel);
    });
    $(".fr", TABS).mouseout(function() {
        taulaSel = $(this).attr("taula");
        FLASH.seleccionaTaula(0);
    });
    $(".fr", TABS).click(obreDetallReserva);

    return false;
}

function procesaError(resposta) {
    var txt = "ERROR: " + resposta.error + "\n\n" + resposta.error_desc;
    alert(txt);
}

function nodeAccordionReserves(node) {
    var html;
    var bt_delete = "";
    var online = "";
    var sobret = "";

    if (permisos > 64)
        bt_delete = '<div class="delete reserva ui-state-default ui-corner-all"> \
    <a href="taules.php?del_reserva=' + node.id_reserva + '" del="' + node.id_reserva + '">Elimina</a></div>';

    if (node.sobret)
        sobret = '<div style="position:relative;left:0" class="ui-icon ' + node.sobret + '" title="Observacions del client">00</div>';
    //online='<div></div>'
    if (node.online)
        online = '<div class="online" title="Reserva ONLINE">' + sobret + '</div>';

    html = '<h3 id="rnode_' + node.id_reserva + '" cognom="' + node.client_cognoms + '"><a n="0" href="form_reserva.php?edit=' + node.id_reserva + '&id=' + node.id_reserva + '" class="fr" taula="' + node.estat_taula_taula_id + '">' + node.id_reserva + '&rArr;' + node.data_es + ' ' + node.hora + ' | ' + node.estat_taula_nom + '&rArr;' + node.comensals + '/' + node.cotxets + ' \
	' + online + '<br/>' + node.client_cognoms + ', ' + node.client_nom + '</a></h3> \
          <div style="border:#eeeeee solid 2px;marginn:3px;padding:5px"> \
            ID:<b>' + node.id_reserva + '</b> \
            <table cellspacing="0" cellpadding="0"> \
              <tr class="taulaf1"> \
                <td>Coberts</td><td>Taula</td><td>Hora</td><td>Torn</td> \
              </tr> \
              <tr class="taulaf2"> \
                <td>' + node.comensals + '</td><td>' + node.estat_taula_nom + '</td><td>' + node.hora + '</td><td>' + node.torn + '</td> \
              </tr> \
              <tr class="taulaf1"> \
                <td>Adults</td><td>10-14</td><td>4-9</td><td>Cotxets</td> \
              </tr> \
              <tr class="taulaf2"> \
                <td>' + node.adults + '</td><td>' + node.nens10_14 + '</td><td>' + node.nens4_9 + '</td><td>' + node.cotxets + '</td> \
              </tr> \
            </table> \
            <p> \
		<b>' + node.client_cognoms + ', ' + node.client_nom + '</b><br/> \
            <a href="mailto:' + node.client_email + '?subject=Reservas Can Borrell&amp;body=">' + node.client_email + '</a> <br/> \
            <b>' + node.client_mobil + ' - </b><br/> \
            <span class="conflicte">' + node.client_conflictes + '</span> \
            </p> \
            ' + bt_delete + ' \
            </div>';

    return html;
}

function nodeAccordionClients(node) {
    var html;

    html = '<h3 id="cnode_' + node.id_reserva + '" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"> \
    <a href="form_client.php?edit=' + node.client_id + '&id=' + node.client_id + '" class="fc" title="detall client"> \
    ' + node.client_cognoms + ', ' + node.client_nom + ' - ' + node.client_mobil + ' \
    </a> \
<br/> \
<a href="form_reserva.php?edit=' + node.id_reserva + '&id=' + node.id_reserva + '" class="taules fr" taula="' + node.estat_taula_taula_id + '" title="detall reserva" data="' + node.data + '">(' + node.id_reserva + ') | ' + node.data_es + ' | ' + node.hora + ' |T' + node.estat_taula_taula_id + '</a> \
    </h3>';

    return html;
}

function ac_inserta_reserva(reserves) {
    var html = "";
    var ac_reserves = "";
    var ac_clients = "";

    ac_reserves = nodeAccordionReserves(reserves[0]);
    ac_clients = nodeAccordionClients(reserves[0]);

    try {
        RESERVES_AC.accordion('destroy');
    } catch (err) {
    }
    ;
    //CLIENTS_AC.accordion('destroy');

    //var r_items=$("h3",RESERVES_AC);
    //var c_items=$("h3",RESERVES_AC);
    var r_items = RESERVES_AC.children();//$("h3",RESERVES_AC);
    var c_items = CLIENTS_AC.children();//$("h3",CLIENTS_AC);

    /*  */
    var fet = false;
    for (var item in r_items) {
        if ($(r_items[item]).attr("cognom") > $(ac_reserves).attr("cognom")) {
            //$(r_items[item]).before(ac_reserves);
            //$(c_items[item]).before(ac_clients);
            fet = true;
            break;
        }
    }
    if (!fet) {
        RESERVES_AC.append(ac_reserves);
        CLIENTS_AC.append(ac_clients);
    }
    RESERVES_AC.accordion(acopres);
    //RESERVES_AC.accordion("resize");

    //HANDLERS ACCORDION
    $(".fr", TABS).unbind()
    $(".fr", TABS).mouseover(function() {
        taulaSel = $(this).attr("taula");
        FLASH.seleccionaTaula(taulaSel);
    });
    $(".fr", TABS).mouseout(function() {
        taulaSel = $(this).attr("taula");
        FLASH.seleccionaTaula(0);
    });
    $(".fr", TABS).click(obreDetallReserva);

}