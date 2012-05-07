<?php

require_once TESTS_PATH .'/application/ControllerTestCase.php';
require_once APPLICATION_PATH .'/controllers/MasterController.php';

class MasterControllerTest extends ControllerTestCase
{
	public function testIndexAction()
	{
		$this->dispatch('/master');
		$this->assertController('master');
		$this->assertAction('master');
	}
   
}

