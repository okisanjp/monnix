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
			$alert = array (
					'disaster' => '0',
					'high' => '0',
					'average' => '0',
					'warning' => '0',
					'information' => '0' 
			);
			$desc = array ();
			foreach ( $trigger as $t ) {
				$prioryty = $t->priority;
				switch ($prioryty) {
					case '5' :
						$alert['disaster'] ++;
						$level = "Disaster";
						$facility = 'danger';
						break;
					case '4' :
						$alert['high'] ++;
						$level = "High";
						$facility = 'danger';
						break;
					case '3' :
						$alert['average'] ++;
						$level = "Average";
						$facility = 'warning';
						break;
					case '2' :
						$alert['warning'] ++;
						$level = "Warning";
						$facility = 'warning';
						break;
					case '1' :
						$alert['information'] ++;
						$level = "Information";
						$facility = 'info';
						break;
					default :
				}
				$desc [] = array (
						'facility' => $facility,
						'level' => $level,
						'hostname' => $t->hostname,
						'description' => $t->description 
				);
			}
			if (array_sum ( $alert ) == 0) {
				$desc [] = array (
						'facility' => '',
						'level' => '',
						'hostname' => '',
						'description' => 'No alert occurred' 
				);
				$status = "panel-normal";
			} elseif ($alert['disaster'] + $alert['high'] > 0) {
				$status = "panel-danger";
			} elseif ($alert['average'] + $alert['warning'] > 0) {
				$status = "panel-warning";
			} elseif ($alert['information'] > 0) {
				$status = "panel-info";
			}
			return array (
					$alert,
					$desc,
					$status 
			);
		} catch ( Exception $e ) {
			// Exception in ZabbixApi catched
			echo $e->getMessage ();
		}
	}
}