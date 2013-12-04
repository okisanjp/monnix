<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/../');
//var_dump(get_include_path());
require_once 'class/Monnix.class.php';
require_once 'config.php';
class MonnixTest extends PHPUnit_Framework_TestCase {
	public function setUp()
	{
		$this->monnix = new Monnix;
	}
	public function testgetAlert(){
		$result = $this->monnix->getAlert();
		var_dump($result);
		//$this->assertNotNull($result);
	}
	public function testgetGraph(){
		
	}
}