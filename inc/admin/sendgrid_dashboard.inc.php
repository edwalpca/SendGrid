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
	//extract data from the post
	extract($_POST);
	
	//set POST variables
	$url = 'https://api.sendgrid.com/api/stats.get.json';
	$fields = array(
		'api_user' => urlencode(SENDGRID_API_USER),
		'api_key' => urlencode(SENDGRID_API_KEY),
		'start_date' => urlencode($_POST['start_date']),
		'end_date' => urlencode($_POST['end_date']),
		'aggregate' => urlencode('0')
	);
	
	//url-ify the data for the POST
	foreach($fields as $key=>$value){
		$fields_string .= $key.'='.$value.'&'; 
	}
	
	rtrim($fields_string, '&');
	
	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	
	//execute post
	$result = curl_exec($ch);
	
	//close connection
	curl_close($ch);
	exit;
}


include(CONFIG_PATH_TPL_ADMIN.$_GET['action'].".tpl.php");
?>