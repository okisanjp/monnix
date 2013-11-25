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
<meta http-equiv="Refresh" content="30">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="/css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<script src="/js/bootstrap.min.js" type="text/javascript"
	charset="utf-8"></script>
<title>monnix</title>
</head>
<div class="container">
	<h1>
		monnix <small>the monitoring display</small>
	</h1>
	<hr />
<?php
require_once '../config.php';
try {
	// connect to Zabbix API
	$api = new ZabbixApi ( $zabbix_server_urlbase.'/zabbix/api_jsonrpc.php', $username, $password );
	// get trigger
	$trigger = $api->triggerGet ( array (
			"monitored" => 1,
			'filter' => array (
					'status' => 0,
					'value' => 1 
			) 
	) );
	$count_red = 0;
	$count_orange = 0;
	$count_blue = 0;
	foreach ( $trigger as $t ) {
		$triggerObj = $api->triggerGetobjects ( array (
				'triggerid' => $t->triggerid 
		) );
		switch ($triggerObj [0]->priority) {
			case "3" :
				$count_red ++;
				break;
			case "2" :
				$count_orange ++;
				break;
			case "1" :
				$count_blue ++;
				break;
			default :
		}
	}
	// var_dump ( $trigger );
} catch ( Exception $e ) {
	// Exception in ZabbixApi catched
	echo $e->getMessage ();
}
?>

<div class="col-md-4">
		<h3>
			<span class="label label-danger">EMERG</span>
		</h3>
		<p class="count<?php if($count_red <> 0){ echo " count_red";}?>"><?php echo $count_red;?></p>
	</div>
	<div class="col-md-4">
		<h3>
			<span class="label label-warning">WARN</span>
		</h3>
		<p class="count<?php if($count_orange <> 0){ echo " count_orange";}?>"><?php echo $count_orange;?></p>
	</div>
	<div class="col-md-4">
		<h3>
			<span class="label label-info">INFO</span>
		</h3>
		<p class="count<?php if($count_blue <> 0){ echo " count_blue";}?>"><?php echo $count_blue;?></p>
	</div>
</div>
<
<hr />
</body>
</html>
