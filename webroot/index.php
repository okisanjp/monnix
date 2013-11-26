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
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="./css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<script src="./js/jquery-1.10.2.min.js" type="text/javascript"
	charset="utf-8"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"
	charset="utf-8"></script>
<title>monnix</title>
<script>
var run = function(time) {
	return $.Deferred(function(dfd) {
	setTimeout(dfd.resolve, time)
	}).promise();
}
run(300).then(function() {
	$('.progress .progress-bar').each(function() {
		var $this = $(this)
		, rate = $this.attr('data-rate')
		, current = 100;
		var progress = setInterval(function() {
			if(current <= rate) {
				clearInterval(progress);
				location.reload();
			} else {
				current -= 1;
				$this.css('width', (current)+ '%');
			}
		}, 250);
	});
});
</script>
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
	$api = new ZabbixApi ( $zabbix_server_urlbase . '/api_jsonrpc.php', $username, $password );
	// get trigger
	$trigger = $api->triggerGet ( array (
			'monitored' => 1,
			'expandData' => 1,
			'output' => array (
					"triggerid",
					"description",
					"priority" 
			),
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
	$desc = '<table class="table">';
	foreach ( $trigger as $t ) {
		$prioryty = $t->priority;
		switch ($prioryty) {
			case '5' :
				$count_5 ++;
				$level = "DISA";
				$facility = 'danger';
				break;
			case '4' :
				$count_4 ++;
				$level = "HIGH";
				$facility = 'danger';
				break;
			case '3' :
				$count_3 ++;
				$level = "AVER";
				$facility = 'warning';
				break;
			case '2' :
				$count_2 ++;
				$level = "WARN";
				$facility = 'warning';
				break;
			case '"1' :
				$count_1 ++;
				$level = "INFO";
				$facility = 'info';
				break;
			default :
		}
		$desc .= '<tr><td><span class="label label-' . $facility . '">' . $level . '</span></td><td><strong>' . $t->hostname . '</strong></td><td>' . $t->description . '</td></tr>';
	}
	// var_dump ( $trigger );
	$desc .= '</table>';
} catch ( Exception $e ) {
	// Exception in ZabbixApi catched
	echo $e->getMessage ();
}
?>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">
				<h3>
					<span class="label label-danger">DISA</span>
				</h3>
				<p
					class="count_danger<?php if($count_5 < 1){ echo " count_zero";}?>"><?php echo $count_5;?></p>
			</div>
			<div class="col-md-6">
				<h3>
					<span class="label label-danger">HIGH</span>
				</h3>
				<p
					class="count_danger<?php if($count_4 < 1){ echo " count_zero";}?>"><?php echo $count_4;?></p>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4">
				<h3>
					<span class="label label-warning">AVER</span>
				</h3>
				<p
					class="count_warning<?php if($count_3 < 1){ echo " count_zero";}?>"><?php echo $count_3;?></p>
			</div>
			<div class="col-md-4">
				<h3>
					<span class="label label-warning">WARN</span>
				</h3>
				<p
					class="count_warning<?php if($count_2 < 1){ echo " count_zero";}?>"><?php echo $count_2;?></p>
			</div>
			<div class="col-md-4">
				<h3>
					<span class="label label-info">INFO</span>
				</h3>
				<p class="count_info<?php if($count_1 < 1){ echo " count_zero";}?>"><?php echo $count_1;?></p>
			</div>
		</div>
		<div class="progress progress-striped active">
			<div class="progress-bar progress-bar-success" role="progressbar"
				style="width: 100%" data-rate="0"></div>
		</div>
	</div>
	<hr />
	<div class="row">
	<?php echo $desc; ?>
	</div>
</div>

</body>
</html>
