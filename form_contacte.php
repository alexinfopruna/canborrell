<div id="caixa_contacte" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="width:100%;max-width:500px">
    
    <p class="petita"> <?php  l("INFO_CONTACTE_HOME");?></p>
    
	<form id="form_contactar" name="form_contactar" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="r-petita" accept-charset="utf-8" style="">
		
		
				<table class="contacte" width="0" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr height="20px">
				  <td class="etinput" ><div align="right"><?php  l('Nom');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td><input type="text" name="client_nom" class="required"/></td>
				</tr>
				<tr height="20px">
				  <td class="etinput" ><div align="right"><?php  l('Correu electrònic');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td><input type="text" name="client_email"  class="required email"/></td>
				</tr>
				<tr height="20px">
				  <td class="etinput" style="vertical-align: top"><div align="right"><?php  l('Consulta');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td><textarea name="reserva_consulta_online" style="width:100%;height:120px" class="required"></textarea></td>
				</tr>
				<tr height="20px">
				  <td class="etinput" style="vertical-align: top"></td>
				  <td width="7">&nbsp;</td>
				  <td >		<input type="text" name="control_rob" class="ui-helper-hidden" style="float:right"/>
		<button id="bt_reserva_consulta_online" name="incidencia" value="">Enviar</button>
</td>
				</tr>
        	
			
                                
				  </table>
                

	</form>
    <p class="petita"><?php l('INFO_TEL'); ?></p>
</div>

<div style="clear:both"></div>
