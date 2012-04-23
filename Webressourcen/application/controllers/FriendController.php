<?php

class FriendController extends Zend_Controller_Action
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
		//init-------------------------------
		$view = $this->initView();
		$request = $this->getRequest();
		
		//Init the Database TopicModel
		$dbTopic = new TopicModel();
		$dbComment = new CommentModel();
		
		//Topic select--------------------
		$topicID = 1;
		$topicVersion = 1;
		
		//DeleteComment-------------------------
		if(($request->isPost())&&(0 < ($request->getPost("CommentID"))))
		{
			$dbComment->deleteComment($request->getPost("CommentID"));
		}
		
        //head Title----------------------------
		$view->headTitle($dbTopic->getTopicName($topicID));
		
		
		//title (id = FriendShowTopicTitel)-----------------
		$view->friendTopicTitel = $dbTopic->getTopicName($topicID);
		
		//topic view----------------------------------------

		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false);
		$view->friendComment = $dbComment->getComment($commentOption);
			
    }

    public function showcommentAction()
    {
        //init-------------------------------
		$view = $this->initView();
		$request = $this->getRequest();
		
		//Init the Database TopicModel
		$dbTopic = new TopicModel();
		$dbComment = new CommentModel();
		
		//Topic select--------------------
		$topicID = 1;
		$topicVersion = 1;
		
		//DeleteComment-------------------------
		if(($request->isPost())&&(0 < ($request->getPost("CommentID"))))
		{
			$dbComment->deleteComment($request->getPost("CommentID"));
		}
		
        //head Title----------------------------
		$view->headTitle("All Comment - ".$dbTopic->getTopicName($topicID));
		
		
		//title (id = FriendShowTopicTitel)-----------------
		$view->friendTopicTitel = "All Comment - ".$dbTopic->getTopicName($topicID);
		
		//topic view----------------------------------------

		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false);
		$view->friendComment = $dbComment->getComment($commentOption);
    }


}









