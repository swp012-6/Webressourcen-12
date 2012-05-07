<?php

require_once TESTS_PATH .'/application/ControllerTestCase.php';
require_once APPLICATION_PATH .'/controllers/FriendController.php';

class FriendControllerTest extends ControllerTestCase
{
	public function testIndexAction()
	{
		$this->dispatch('/');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
	public function testCallWithoutActionShouldPullFromIndexAction()  
    {  
        $this->dispatch('/friend');  
        $this->assertController('friend');  
        $this->assertAction('friend');  
    }  
	

}

