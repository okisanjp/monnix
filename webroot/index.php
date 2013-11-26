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
define('APP_ROOT',@str_replace ('/webroot', '',$_SERVER ['DOCUMENT_ROOT']));
require_once APP_ROOT.'/config.php';
require_once APP_ROOT.'/class/Monnix.class.php';
$monnix = new Monnix();

/**
 * get alert status
 */
list($count_1,$count_2,$count_3,$count_4,$count_5,$desc) = $monnix->getAlert();
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
<div class="container">
  <h1>monnix <small>the monitoring display</small>
  </h1>
  <hr />
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <h3><span class="label label-danger">DISA</span>
        </h3>
        <p class="count_danger<?php if($count_5 < 1){ echo " count_zero";}?>">
          <?php echo $count_5;?>
        </p>
      </div>
      <div class="col-md-6">
        <h3><span class="label label-danger">HIGH</span>
        </h3>
        <p class="count_danger<?php if($count_4 < 1){ echo " count_zero";}?>">
          <?php echo $count_4;?>
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-4">
        <h3><span class="label label-warning">AVER</span>
        </h3>
        <p class="count_warning<?php if($count_3 < 1){ echo " count_zero";}?>">
          <?php echo $count_3;?>
        </p>
      </div>
      <div class="col-md-4">
        <h3><span class="label label-warning">WARN</span>
        </h3>
        <p class="count_warning<?php if($count_2 < 1){ echo " count_zero";}?>">
          <?php echo $count_2;?>
        </p>
      </div>
      <div class="col-md-4">
        <h3><span class="label label-info">INFO</span>
        </h3>
        <p class="count_info<?php if($count_1 < 1){ echo " count_zero";}?>">
          <?php echo $count_1;?>
        </p>
      </div>
    </div>
    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%" data-rate="0"></div>
    </div>
  </div>
  <hr />
  <div class="row">
    <?php echo $desc; ?>
  </div>
</div>

</body>
</html>
