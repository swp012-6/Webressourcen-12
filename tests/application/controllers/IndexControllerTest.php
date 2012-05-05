<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';



class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

	
	/**
     * @var Zend_Application
    */
    protected $application;
	
    public function setUp()
    {
        /* Setup Routine */
		
		$this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }
	
	public function appBootstrap() 
	{
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
    }

    public function tearDown()
    {
        /* Tear Down Routine */
		
		
    }
	
	//--TESTFUNCTIONS---------------------------------------------------------------------------------------------------------------
	
	public function testInit()
	{
		
	}
	
	
	public function testIndexAction()
	{
	
	}
	
	public function testPreloginAction()
	{
	
	}
	
	public function testLoginAction()
	{
	
	}
	
	public function testLogoutAction()
	{
	
	}
	
	public function testUpdateformAction()
	{
	
	}
	
	public function testUpdateAction()
	{
	
	}
	
	
	

}