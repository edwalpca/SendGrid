<?php
if( !defined('SENDGRID_API_USER') || !defined('SENDGRID_API_KEY') ){
?>
<div class="row">
  <div class="space-6"></div>
  <div class="col-xs-12">
    <div class="alert alert-danger">
      Debe definir las constantes <strong>SENDGRID_API_USER</strong> y <strong>SENDGRID_API_KEY</strong> en el archivo config o dentro de la tabla par&aacute;metros.
    </div>
  </div>
</div>
<?php
	unset($_POST['consultar']);
}

if($_POST['consultar']=='si'){
	$response = file_get_contents("https://sendgrid.com/api/invalidemails.get.json?api_user=".SENDGRID_API_USER."&api_key=".SENDGRID_API_KEY."&date=1&start_date=".$_POST['start_date']."&end_date".$_POST['end_date']."&email=".$_POST['email']);
	echo $response;
	exit;
}


include(CONFIG_PATH_TPL_ADMIN.$_GET['action'].".tpl.php");
?>