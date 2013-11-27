<?php
/**
 * monnix for zabbix
 * @link      https://github.com/okisanjp/monnix
 * @author    okisanjp <okisan.jp@gmail.com>
 * @copyright GNU General Public License
 */

/**
 * Intialize
 */
define ( 'APP_ROOT', @str_replace ( '/webroot', '', $_SERVER ['DOCUMENT_ROOT'] ) );
require_once APP_ROOT . '/config.php';
require_once APP_ROOT . '/class/Monnix.class.php';
$monnix = new Monnix ();

/**
 * get alert status
 */
list ( $alert, $desc, $status ) = $monnix->getAlert ();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<script src="./js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="./js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script src="./js/autoreload.js" type="text/javascript" charset="utf-8"></script>
<title>monnix</title>
</head>
<body class="<?php echo $status;?>">
	<div class="container">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<a class="navbar-brand" href="#">monnix</a>
			<p class="navbar-text">the monitoring display</p>
		</nav>
		<div class="well well-sm well-panel">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<h3 class="head head-danger">Disaster</h3>
							<p class="text-center count-danger <?php if($alert['disaster'] == 0){ echo " count-zero";}?>"><?php echo $alert['disaster'];?></p>
						</div>
						<div class="col-md-6">
							<h3 class="head head-danger">High</h3>
							<p class="text-center count-danger <?php if($alert['high'] == 0){ echo " count-zero";}?>"><?php echo $alert['high'];?></p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4">
							<h3 class="head head-warning">Average</h3>
							<p class="text-center count-warning <?php if($alert['average'] == 0){ echo " count-zero";}?>"><?php echo $alert['average'];?></p>
						</div>
						<div class="col-md-4">
							<h3 class="head head-warning">Warning</h3>
							<p class="text-center count-warning <?php if($alert['warning'] == 0){ echo " count-zero";}?>"><?php echo $alert['warning'];?></p>
						</div>
						<div class="col-md-4">
							<h3 class="head head-info">Information</h3>
							<p class="text-center count-info <?php if($alert['information'] == 0){ echo " count-zero";}?>"><?php echo $alert['information'];?></p>
						</div>
					</div>
					<hr />
					<h4><span class="glyphicon glyphicon-refresh"></span> Until the next update</h4>
					<div class="progress progress-striped">
						<div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%" data-rate="0"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="well well-sm well-panel">
			<table class="table">
				<thead>
					<tr>
						<th>Priority</th>
						<th>Host</th>
						<th>Desc</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ( $desc as $d ) {
					echo '<tr><td><span class="label label-' . $d ['facility'] . '">';
					echo $d ['level'] . '</span></td><td>';
					echo '<strong>' . $d ['hostname'] . '</strong></td>';
					echo '<td>' . $d ['description'] . '</td></tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
