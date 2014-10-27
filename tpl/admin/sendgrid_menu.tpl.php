<script language="javascript">
$(document).ready(function(e) {
    $.fn.esperando = function() {
		$("#modal_html_esperando").removeClass('hide').dialog({
			modal: true
		});
	}
	
	$.fn.cerrar = function() {
		$("#modal_html_esperando").addClass('hide')
		$("#modal_html_esperando").dialog( "close" );
	}
});
</script>
<div class="row">
  <div class="col-xs-12 col-sm-12">
    <div id="modal_html_esperando" class="hide">
      <p>
      <div style="text-align:center;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="images/cargando.gif" width="150" height="150"/></td>
            <td align="center" style="font-size:18px;"><strong>Espere un momento, mientras procesamos su petici&oacute;n.</strong></td>
          </tr>
        </table>
      </div>
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="space-6"></div>
  <div class="col-xs-12">

     <div class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#">SendGrid</a> </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($_GET['action']=='sendgrid_dashboard'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_dashboard"><strong>Reporte Global</strong></a></li>
            <li <?php if($_GET['action']=='sendgrid_bounces'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_bounces"><strong>Rechazados</strong></a></li>
            <li <?php if($_GET['action']=='sendgrid_blocks'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_blocks"><strong>Bloqueados</strong></a></li>
            <li <?php if($_GET['action']=='sendgrid_spam_reports'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_spam_reports"><strong>Reportados Spam</strong></a></li>
            <li <?php if($_GET['action']=='sendgrid_invalid_emails'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_invalid_emails"><strong>Emails Inv&aacute;lidos</strong></a></li>
            <li <?php if($_GET['action']=='sendgrid_unsubscribes'){?>class="active"<?php }?>><a onclick="$(this).esperando();" href="<?php echo $_SESSION['script_name'];?>.php?action=sendgrid_unsubscribes"><strong>Desinscritos</strong></a></li>
          </ul>
        </div>
    </div>

  </div>
</div>