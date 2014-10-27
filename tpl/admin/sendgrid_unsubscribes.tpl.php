<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script language="javascript">
$(document).ready(function(e) {
	$.fn.consultar = function(){
		$(this).esperando();
		
		var fecha_desde = $.trim($('#fecha_desde').val());
		var fecha_hasta = $.trim($('#fecha_hasta').val());
		var email = $.trim($('#email').val());
	
		$.post('<?php echo url_actual();?>&flw=1',{consultar:'si',start_date:fecha_desde,end_date:fecha_hasta,email:email},function(data_json){		
			//alert(data_json);
			var datos = $.parseJSON(data_json);
			//alert(datos.delivered);
			
			var tbody = '';
			$(datos).each(function(i,val){
				tbody += '<tr>';
				tbody += '<td>'+datos[i].email+'</td>';
				tbody += '<td>'+datos[i].created+'</td>';
				tbody += '</tr>';				
			});			
			
			$('#tbody').html(tbody);
			$('#tabla_contenido').dataTable();
			
			$(this).cerrar();
		});	
	}
	
	$('#fecha_desde').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	}).on('changeDate', function(selected){
		startDate = new Date(selected.date.valueOf());
		startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
		$('#fecha_hasta').datepicker('setStartDate', startDate);
	});
	
	$('#fecha_hasta').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
	}).on('changeDate', function(selected){
		startDate = new Date(selected.date.valueOf());
		startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
		$('#fecha_desde').datepicker('setEndDate', startDate);
	});	
});
</script>
<?php include(CONFIG_PATH_TPL_ADMIN."sendgrid_menu.tpl.php");?>

<div class="row">
  <div class="space-6"></div>
  <div class="col-xs-12">
    <div class="alert alert-warning">
      <div class="row">
        <div class="col-xs-12 col-sm-2">
          <div class="input-group">
            <input readonly="readonly" type="text" data-date-format="dd-mm-yyyy" id="fecha_desde" class="form-control date-picker">
            <span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span> </div>
        </div>
        <div class="col-xs-12 col-sm-2">
          <div class="input-group">
            <input readonly="readonly" type="text" data-date-format="dd-mm-yyyy" id="fecha_hasta" class="form-control date-picker">
            <span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span> </div>
        </div>
        <div class="col-xs-12 col-sm-2">
          <div class="input-group">
            <input type="text" id="email" >          
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="input-group">
            <button onclick="$(this).consultar();" class="btn btn-primary">Buscar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="sendgrid_contenedor">
  <div class="col-xs-12 col-sm-2">
  	<div class="well">
        <h5 class="green smaller lighter">Como evitar los desinscritos?</h5>
        
        <p>Tenga en cuenta que SendGrid no podr&aacute; hacer futuros env&iacute;os a cualquier correo electr&oacute;nico en esta lista.</p>
		<p>El siguiente recurso contiene informaci&oacute;n de c&oacute;mo evitar la carpeta SPAM, pero tambi&eacute;n encontrar&aacute; informaci&oacute;n &uacute;til para evitar los desinscritos.</p>
        <p><a href="http://www.sendgrid.com/blog/10-tips-to-keep-email-out-of-the-spam-folder/">Consejos para evitar desinscritos</a></p>
    </div>
  </div>
  <div class="col-xs-12 col-sm-10">
    <div class="table-responsive">
      <table id="tabla_contenido" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>Correo Electr&oacute;nico</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive --> 
  </div>
</div>
<script language="javascript">
$(document).ready(function(e) {
	$(this).consultar();
});
</script>