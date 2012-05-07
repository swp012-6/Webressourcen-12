<?php
//require_once 'PHPUnit/Framework/TestCase.php';
//require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
	public $application;
	
	public function setUp()
	{
		$this->bootstrap = new Zend_Application(
							APPLICATION_ENV,
							APPLICATION_PATH ."/configs/application.ini"
							);
		parent::setUp();
	}
	
	public function tearDown()
	{
		Zend_Controller_Front::getInstance()->resetInstance();
		$this->resetRequest();
		$this->resetResponse();
		
		$this->request->setPost(array());
		$this->request->setQuery(array());
		
	}
	
	
}