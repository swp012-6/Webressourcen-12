<?php

require_once TESTS_PATH .'/application/ControllerTestCase.php';
require_once APPLICATION_PATH .'/controllers/IndexController.php';

class IndexControllerTest extends ControllerTestCase
{

	public function testInit()
	{
		
	}
	
	
	public function testIndexAction()
	{
		$this->dispatch('/');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
	
	public function testCallWithoutActionShouldPullFromIndexAction()  
    {  
        $this->dispatch('/user');  
        $this->assertController('user');  
        $this->assertAction('index');  
    }  
  
    public function testIndexActionShouldContainLoginForm()  
    {  
        $this->dispatch('/user');  
        $this->assertAction('index');  
        $this->assertQueryCount('form#loginForm', 1);  
    }  
  
    public function testValidLoginShouldGoToProfilePage()  
    {  
        $this->request->setMethod('POST')  
              ->setPost(array(  
                  'username' => 'foobar',  
                  'password' => 'foobar'  
              ));  
        $this->dispatch('/user/login');  
        $this->assertRedirectTo('/user/view');  
  
        $this->resetRequest()  
             ->resetResponse();  
  
        $this->request->setMethod('GET')  
             ->setPost(array());  
        $this->dispatch('/user/view');  
        $this->assertRoute('default');  
        $this->assertModule('default');  
        $this->assertController('user');  
        $this->assertAction('view');  
        $this->assertNotRedirect();  
        $this->assertQuery('dl');  
        $this->assertQueryContentContains('h2', 'User: foobar');  
    }  
	
	 public function testLoginDisplaysAForm()
    {
        $this->dispatch('/auth/index');
        $this->assertResponseCode(200);
        $this->assertQueryContentContains('h1', 'Login');
        $this->assertQuery('form#login'); // id of form
    }

	
	

}