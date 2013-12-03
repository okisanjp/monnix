<?php
require_once '../include/init.php';

/**
 * get graphs
 */
$monnix = new Monnix ();
list ( $result ) = $monnix->getGraph ();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include_once '../include/htmlHead.php';?>
<title>monnix - graph</title>
</head>
<body class="">
	<div class="container">
	<?php var_dump($result);?>
	</div>
</body>
</html>
