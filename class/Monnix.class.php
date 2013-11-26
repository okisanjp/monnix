<?php
/**
 * @file    Monnix.class.php
 * @brief   Class file for the monnix
 * @author  okisanjp <okisan.jp@gmail.com>
 */

/**
 * PhpZabbixApi
 * @link http://zabbixapi.confirm.ch/
 */
require_once APP_ROOT . '/class/ZabbixApiAbstract.class.php';
require_once APP_ROOT . '/class/ZabbixApi.class.php';

class Monnix{
  public function getAlert(){
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
      $desc .= '</table>';
      return array($count_1,$count_2,$count_3,$count_4,$count_5,$desc);
    } catch ( Exception $e ) {
      // Exception in ZabbixApi catched
      echo $e->getMessage ();
    }
  }
}