<?php
// load ZabbixApi
require '../class/ZabbixApiAbstract.class.php';
require '../class/ZabbixApi.class.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="/css/bootstrap-theme.min.css" />
<script src="/js/bootstrap.min.js" type="text/javascript"
	charset="utf-8"></script>
<title>monnix</title>
</head>
<div class="container">
	<h1>
		monnix <small>the monitoring display</small>
	</h1>
<?php
try {
	// connect to Zabbix API
	$api = new ZabbixApi ( 'http://192.168.11.205/zabbix/api_jsonrpc.php', 'admin', 'zabbix' );
	// get trigger
	$trigger = $api->triggerGet ( array (
			"monitored" => 1,
			'filter' => array (
					'status' => 0,
					'value' => 1 
			) 
	) );
	
	$triggerObj = $api->triggerGetobjects ( array (
			'triggerid' => 15056 
	) );
	
	var_dump ( $triggerObj );
	var_dump ( $trigger );
} catch ( Exception $e ) {
	// Exception in ZabbixApi catched
	echo $e->getMessage ();
}
?>
</div>
</body>
</html>
