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
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="./css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<script src="./js/bootstrap.min.js" type="text/javascript"
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
	$api = new ZabbixApi ( $zabbix_server_urlbase . '/zabbix/api_jsonrpc.php', $username, $password );
	// get trigger
	$trigger = $api->triggerGet ( array (
			"monitored" => 1,
			'filter' => array (
					'status' => 0,
					'value' => 1 
			) 
	) );
	$count_1 = 0;
	$count_2 = 0;
	$count_3 = 0;
	$count_4 = 0;
	$count_5 = 0;
	foreach ( $trigger as $t ) {
		$triggerObj = $api->triggerGetobjects ( array (
				'triggerid' => $t->triggerid 
		) );
		switch ($triggerObj [0]->priority) {
			case "5" :
				$count_5 ++;
				break;
			case "4" :
				$count_4 ++;
				break;
			case "3" :
				$count_3 ++;
				break;
			case "2" :
				$count_2 ++;
				break;
			case "1" :
				$count_1 ++;
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

<div class="col-md-3">
		<h3>
			<span class="label label-danger">DISA</span>
		</h3>
		<p class="count_danger<?php if($count_5 < 1){ echo " count_zero";}?>"><?php echo $count_5;?></p>
	</div>
	<div class="col-md-3">
		<h3>
			<span class="label label-danger">HIGH</span>
		</h3>
		<p class="count_danger<?php if($count_4 < 1){ echo " count_zero";}?>"><?php echo $count_4;?></p>
	</div>
	<div class="col-md-2">
		<h3>
			<span class="label label-warning">AVER</span>
		</h3>
		<p class="count_warning<?php if($count_3 < 1){ echo " count_zero";}?>"><?php echo $count_3;?></p>
	</div>
	<div class="col-md-2">
		<h3>
			<span class="label label-warning">WARN</span>
		</h3>
		<p class="count_warning<?php if($count_2 < 1){ echo " count_zero";}?>"><?php echo $count_2;?></p>
	</div>
	<div class="col-md-2">
		<h3>
			<span class="label label-info">INFO</span>
		</h3>
		<p class="count_info<?php if($count_1 < 1){ echo " count_zero";}?>"><?php echo $count_1;?></p>
	</div>
</div>
<hr />
</body>
</html>
