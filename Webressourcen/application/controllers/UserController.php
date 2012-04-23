<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function validateAction()
    {
        // action body
    }

    public function createAction()
    {
        // action body
    }
	
	/**
		show the Topic and show some comments.
		
	*/
    public function showtopicAction()
    {
        //Title
		$view = $this->initView();
		$view->headTitle('ThemenName');
		
    }

    public function showcommentAction()
    {
        // action body
    }


}









