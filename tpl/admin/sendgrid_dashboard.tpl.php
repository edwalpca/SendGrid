<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<script language="javascript">
function formato_numero(numero, decimales, separador_decimal, separador_miles){ 
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}

$(document).ready(function(e) {
	$.fn.retornaMes = function(mes){
		mes = mes - 1;
		var meses = new Array(
						'Ene',
						'Feb',
						'Mar',
						'Abr',
						'May',
						'Jun',
						'Jul',
						'Ago',
						'Set',
						'Oct',
						'Nov',
						'Dic');
		return meses[mes];
	}	
	
    $.fn.esperando = function() {
		$("#modal_html_esperando").removeClass('hide').dialog({
			modal: true
		});
	}
	
	$.fn.cerrar = function() {
		$("#modal_html_esperando").addClass('hide')
		$("#modal_html_esperando").dialog( "close" );
	}
	
	$.fn.consultar = function(){
		$(this).esperando();
		
		var fecha_desde = $.trim($('#fecha_desde').val());
		var fecha_hasta = $.trim($('#fecha_hasta').val());
		
		if(fecha_desde!='' && fecha_hasta!=''){
			$.post('<?php echo url_actual();?>&flw=1',{consultar:'si',start_date:fecha_desde,end_date:fecha_hasta},function(data_json){		
				//alert(data_json);
				var datos = $.parseJSON(data_json);
				//alert(datos.delivered);
				
				var datos_delivered 		= 0;
				var datos_opens 			= 0;
				var datos_unique_opens 		= 0;
				var datos_clicks 			= 0;
				var datos_unique_clicks 	= 0;
				var datos_unsubscribes 		= 0;
				var datos_bounces 			= 0;
				var datos_spamreports 		= 0;
				var datos_requests 			= 0;
				
				
				var dias_seleccionados		= new Array();
				var delivered_por_dia 		= new Array();
				var opens_por_dia 			= new Array()
				var unique_opens_por_dia 	= new Array()
				var clicks_por_dia 			= new Array()
				var unique_clicks_por_dia 	= new Array()
				var unsubscribes_por_dia 	= new Array()
				var bounces_por_dia 		= new Array()
				var spamreports_por_dia 	= new Array()
				var requests_por_dia 		= new Array()
				
				$(datos).each(function(i,val){
					datos_delivered 	+= datos[i].delivered;
					datos_opens 		+= datos[i].opens;
					datos_unique_opens 	+= datos[i].unique_opens;
					datos_clicks 		+= datos[i].clicks;
					datos_unique_clicks += datos[i].unique_clicks;
					datos_unsubscribes 	+= datos[i].unsubscribes;
					datos_bounces 		+= datos[i].bounces;
					datos_spamreports 	+= datos[i].spamreports;
					datos_requests 		+= datos[i].requests;
					
					var fecha = datos[i].date.split('-');
					dias_seleccionados[i] 		= $(this).retornaMes(fecha[1])+' '+fecha[2];
					delivered_por_dia[i]  		= datos[i].delivered;
					opens_por_dia[i] 			= datos[i].opens;
					unique_opens_por_dia[i] 	= datos[i].unique_opens;
					clicks_por_dia[i] 			= datos[i].clicks;
					unique_clicks_por_dia[i]	= datos[i].unique_clicks;
					unsubscribes_por_dia[i] 	= datos[i].unsubscribes;
					bounces_por_dia[i] 			= datos[i].bounces;
					spamreports_por_dia[i] 		= datos[i].spamreports;
					requests_por_dia[i] 		= datos[i].requests;
				});
			
				//alert(delivered_por_dia);
				//return false;
					
				var suma_todas = parseInt(datos_delivered)+parseInt(datos_opens)+parseInt(datos_unique_opens)+parseInt(datos_clicks)+parseInt(datos_unique_clicks)+parseInt(datos_unsubscribes)+parseInt(datos_bounces)+parseInt(datos_spamreports);
				
				var porcentaje_delivered = 		parseFloat((datos_delivered*100)/suma_todas);
				var porcentaje_opens = 			parseFloat((datos_opens*100)/suma_todas);
				var porcentaje_unique_opens = 	parseFloat((datos_unique_opens*100)/suma_todas);
				var porcentaje_clicks = 		parseFloat((datos_clicks*100)/suma_todas);
				var porcentaje_unique_clicks = 	parseFloat((datos_unique_clicks*100)/suma_todas);
				var porcentaje_unsubscribes = 	parseFloat((datos_unsubscribes*100)/suma_todas);
				var porcentaje_bounces =		parseFloat((datos_bounces*100)/suma_todas);
				var porcentaje_spamreports = 	parseFloat((datos_spamreports*100)/suma_todas);
				
				$('#sendgrid_requests').html(formato_numero(datos_requests, 0, '.' ,','));
				$('#sendgrid_delivered').html(formato_numero(datos_delivered, 0, '.' ,','));
				$('#sendgrid_bounces').html(formato_numero(datos_bounces, 0, '.' ,','));
				
				$('#sendgrid_opens').html(formato_numero(datos_opens, 0, '.' ,','));
				$('#sendgrid_unique_opens').html(formato_numero(datos_unique_opens, 0, '.' ,','));
				$('#sendgrid_spam_reports').html(formato_numero(datos_spamreports, 0, '.' ,','));
				
				$('#sendgrid_clicks').html(formato_numero(datos_clicks, 0, '.' ,','));
				$('#sendgrid_unique_clicks').html(formato_numero(datos_unique_clicks, 0, '.' ,','));
				$('#sendgrid_unsubscribes').html(formato_numero(datos_unsubscribes, 0, '.' ,','));
				
				// Build the chart
				$('#container').highcharts({
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Reporte General'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'middle',
						borderWidth: 0
					},
					series: [{
						type: 'pie',
						name: 'Porcentaje',
						data: [
							['Entregados', porcentaje_delivered],
							['Abiertos', porcentaje_opens],
							['Abiertos Unicos', porcentaje_unique_opens],
							['Clicks', porcentaje_clicks],
							['Clicks Unicos', porcentaje_unique_clicks],
							['Desinscritos', porcentaje_unsubscribes],
							['Rechazados', porcentaje_bounces],
							['Reportados Spam', porcentaje_spamreports]
						]
					}]
				});
				
				$('#reporte_por_dia').highcharts({
					title: {
						text: 'Reporte por Dia',
						x: -20 //center
					},
					/*subtitle: {
						text: 'Source: WorldClimate.com',
						x: -20
					},*/
					xAxis: {
						categories: dias_seleccionados
					},
					yAxis: {
						title: {
							text: 'Cantidad Envios'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'middle',
						borderWidth: 0
					},
					series: [{
						name: 'Envios',
						data: requests_por_dia
					}, {
						name: 'Entregados',
						data: delivered_por_dia
					}, {
						name: 'Abiertos',
						data: opens_por_dia
					}, {
						name: 'Abiertos Unicos',
						data: unique_opens_por_dia
					}, {
						name: 'Clicks',
						data: clicks_por_dia
					}, {
						name: 'Clicks Unicos',
						data: unique_clicks_por_dia
					}, {
						name: 'Desinscritos',
						data: unsubscribes_por_dia
					}, {
						name: 'Rechazados',
						data: bounces_por_dia
					}, {
						name: 'Reportados Spam',
						data: spamreports_por_dia
					}]
				});
				
				$('#sendgrid_contenedor').removeClass('hide');
				
				$(this).cerrar();
			});
		}
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
        <div class="col-xs-12 col-sm-8">
          <div class="input-group">
            <button onclick="$(this).consultar();" class="btn btn-primary">Buscar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row hide" id="sendgrid_contenedor">
  <div class="space-6"></div>
  <div class="col-xs-12 col-sm-7">
    <div class="row">
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Envios</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_requests"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Entregados</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_delivered"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Rechazados</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_bounces"></strong></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Abiertos</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_opens"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Abiertos Unicos</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_unique_opens"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Reportados Spam</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_spam_reports"></strong></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Clicks</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_clicks"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Clicks Unicos</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_unique_clicks"></strong></h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="widget-box" style="opacity: 1;">
          <div class="widget-header center">
            <h5 class="smaller">Desinscritos</h5>
          </div>
          <div class="widget-body center">
            <div class="widget-main padding-6">
              <h2><strong id="sendgrid_unsubscribes"></strong></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-5">
    <div class="widget-box" style="opacity: 1;">
      <div class="widget-header center">
        <h5> <i class="icon-signal"></i> Gr&aacute;fico </h5>
      </div>
      <div class="widget-body center">
        <div class="widget-main padding-6" id="container"> </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="space-6"></div>
  <div class="col-xs-12" id="reporte_por_dia"> </div>
</div>
