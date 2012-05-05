<?php

require_once 'PHPUnit/Framework/TestCase.php';

class FriendControllerTest extends PHPUnit_Framework_TestCase
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
	
	

}

