<?php
/**
 * Monnix 
 * @file    Monnix.class.php
 * @brief   Class file for the monnix
 * @author  okisanjp <okisan.jp@gmail.com>
 */

/**
 * PhpZabbixApi
 * 
 * @link http://zabbixapi.confirm.ch/
 */
require_once APP_ROOT . '/class/ZabbixApiAbstract.class.php';
require_once APP_ROOT . '/class/ZabbixApi.class.php';
class Monnix {
	public function getAlert() {
		try {
			// connect to Zabbix API
			$api = new ZabbixApi ( ZABBBIX_SERVER_URLBASE . '/api_jsonrpc.php', USERNAME, PASSWORD );
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
			$desc = '';
			foreach ( $trigger as $t ) {
				$prioryty = $t->priority;
				switch ($prioryty) {
					case '5' :
						$count_5 ++;
						$level = "Disaster";
						$facility = 'danger';
						break;
					case '4' :
						$count_4 ++;
						$level = "High";
						$facility = 'danger';
						break;
					case '3' :
						$count_3 ++;
						$level = "Average";
						$facility = 'warning';
						break;
					case '2' :
						$count_2 ++;
						$level = "Warning";
						$facility = 'warning';
						break;
					case '1' :
						$count_1 ++;
						$level = "Information";
						$facility = 'info';
						break;
					default :
				}
				$desc .= '<tr><td><span class="label label-' . $facility . '">' . $level . '</span></td><td><strong>' . $t->hostname . '</strong></td><td>' . $t->description . '</td></tr>';
			}
			if(($count_1 + $count_2 + $count_3 + $count_4 + $count_5) == 0){
				$desc = '<tr><td></td><td></td><td>No alerts occurred.</td></tr>';
			}
			return array (
					$count_1,
					$count_2,
					$count_3,
					$count_4,
					$count_5,
					$desc 
			);
		} catch ( Exception $e ) {
			// Exception in ZabbixApi catched
			echo $e->getMessage ();
		}
	}
	
}