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
	/**
		with the createAction, create new comment
	*/
    public function createAction()
    {
		//init-------------------------------
		$view = $this->initView();		//combines controller with view
		$request = $this->getRequest();	//operation with datatransfer (post,get)
		
		//formula init
		$form = new Zend_Form();
		$form->setMethod('post');	//datatransfare with post
		$form->setAction('create');
		
		//Init the Database 
		$dbTopic = new TopicModel();
		$dbComment = new CommentModel();
		
		//create Option----------------
		$topicID = 1;		//topicID from session
		$topicVersion = 1; 	//topicVersion from session
		$userID = 2;
		$view->userID = $userID;
		
		//head Title----------------------------
		$view->headTitle("ADD Comment - ".$dbTopic->getTopicName($topicID));
		
		//title -----------------
		$view->friendTopicTitel = "ADD Comment - ".$dbTopic->getTopicName($topicID);
		
		
		//FORMULAR------------------------------------------------
		//Label-> Name
		$form->addElement('checkbox','name');
		$form->name->setLabel('Anonymous?');
	   
		//Comment area: 	-it's important information
		//					-max 500 symbols
		$form->addElement('textarea','comment');
		$form->comment->setLabel('Comment');
		$form->comment->setRequired(true);
		$form->comment->addValidator('stringLength', true, array(0, 500));
		//exaption for comment
		$notEmpty = new Zend_Validate_NotEmpty();
		$notEmpty->setMessage('Pleas write the Comment!');
		$form->comment->addValidator($notEmpty);
		
		//submintbutten create with name 'send'
		$form->addElement('submit','send');

		//when comment is empty ore when its the first attempt, is send the form  to the viewer
		if(!$request->isPost() || !$form->isValid($_POST))
		{
			$view->form = $form;
		}
		else// its the input correctly, then send the results to the database
		{
			$name = $form->getValue('name');
			$comment = $form->getValue('comment');
			
			//array for the database
			$conntent = array("userID" => $userID,"topicID"=>$topicID,"topicVersion" => $topicVersion,"anonymous"=> $name,"commentText"=>$comment);
			//save
			$dbComment->addComment($conntent);
			//user message
			$view->message = 'Comment successfull send';
			
		}
		
		
		
	   
    }
	
	/**
		show the Topic and show some comments.
		
	*/
    public function showtopicAction()
    {
		//init-------------------------------
		$view = $this->initView();		//combines controller with view
		$request = $this->getRequest();	//operation with datatransfer (post,get)
		
		//Init the Database 
		$dbTopic = new TopicModel();
		$dbComment = new CommentModel();
		
		//Topic select--------------------
		$topicID = 1;
		
		//version
		//if the latest version
		$option = array("topicID" => $topicID, "number" =>1,"page" => 0);
		$version = $dbTopic->getVersionNumbers($option);
		foreach($version as $v)
		{
			
			$topicVersion = $v;
		}
		//selected another version
		
		if(0 <= ($request->getQuery("Page")))
		{
			$topicVersion = $request->getQuery("Page");
		}
		$userID = 2;
		$view->userID = $userID;
		
		//versions select
		$page = 0;		//current Page
		if(0 <= ($request->getQuery("Page")))
		{
			$option = array("topicID" => $topicID,"topicVersion"=>$request->getQuery("Page"));
			$page = $dbTopic->getTheNumberFromVersion($option);
		}
		echo $page;
		$maxVersionPage = 1;
		
		//DeleteComment-------------------------
		if(($request->isPost())&&(0 < ($request->getPost("CommentID"))))
		{
			$dbComment->deleteComment($request->getPost("CommentID"));
		}
		
        //head Title----------------------------
		$view->headTitle($dbTopic->getTopicName($topicID));
		
		
		//title-----------------
		$view->friendTopicTitel = $dbTopic->getTopicName($topicID);
		
		
		
		//topic version select-------------------------------
		//compute currentPageNavigator
		$currentPageNavigator = floor($page / $maxVersionPage);
		$view->currentPageNavigator = $currentPageNavigator;

		//compute numberPageNavigator
		$numberPageNavigator = floor($dbTopic->getNumberVersion($topicID) / $maxVersionPage);
		$view->numberPageNavigator = $numberPageNavigator;
		
		//get VersionsID 
		$option = array("topicID" => $topicID, "number" =>$maxVersionPage,"page" => $currentPageNavigator);
		$version = $dbTopic->getVersionNumbers($option);
		$view->version = $version;
		
		
		
		//topic view----------------------------------------
		
		//comment view--------------------------------------
		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false,"number" => 3,"page" => 0);
		$view->friendComment = $dbComment->getComment($commentOption);
			
    }
	
	/**
		show all Comments in Page.
		Per page are 5 Comments.
	*/
    public function showcommentAction()
    {
	
        //init-------------------------------
		$view = $this->initView();
		$request = $this->getRequest();
		
		//Init the Database TopicModel
		$dbTopic = new TopicModel();
		$dbComment = new CommentModel();
		
		//schowcomment Option----------------
		$topicID = 1;	//topicID from session
		$topicVersion = 1; //topicVersion from session
		$userID = 2;
		$view->userID = $userID;
		
		$page = 0;
			$view->Page = $page;
			//comment
			//Select Page
			if(($request->isGet("Page"))&&(0 <= ($request->getQuery("Page"))))
			{
				$page = $request->getQuery("Page");
				$view->Page =$page;
			}
			
		//set the number of Comments at a Page
		$maxComment = 5; // is the max number of Comments show the Page
			
		//Page Navigator
		$maxPageNavigator = 5; //Are the Button to klick of the Page
				

		
		//DeleteComment-------------------------
		if(($request->isPost("CommentID"))&&(0 < ($request->getPost("CommentID"))))
		{
			$dbComment->deleteComment($request->getPost("CommentID"));
		}
		
        //head Title----------------------------
		$view->headTitle("All Comment - ".$dbTopic->getTopicName($topicID));
		
		
		//title -----------------
		$view->friendTopicTitel = "All Comment - ".$dbTopic->getTopicName($topicID);
		
		//topic view----------------------------------------

		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false, "number" => $maxComment,"page" => $page);
		$view->friendComment = $dbComment->getComment($commentOption);
		
		
		//Page Navigator+++++++++++++++++++++++++++++++++++++++++++++++
		
		
		//determine number of Pages
		$view->maxPageNavigator = $maxPageNavigator;
		
		$numberPage = floor($dbComment->getnumberComment() / $maxComment); //MAX Page number

		$numberPageNavigator = floor($numberPage / $maxPageNavigator);	   //MAX PageNavigator Number
		$view->numberPageNavigator = $numberPageNavigator;
		
		$currentPageNavigator = floor($page / $maxPageNavigator);			// current Position in the Navigator

		//assign the currentPageNavigator
		if((1 == $request->isGet("PageNavigator"))&&(1 <= ($request->getQuery("PageNavigator"))))
		{
			$currentPageNavigator = $request->getQuery("PageNavigator")-1;
		}
		
		$view->currentPageNavigator = $currentPageNavigator;
		
		
	
		
		//number of Button-----------------------------
		if($currentPageNavigator >= $numberPageNavigator)
		{
				$view->pageNavigatornumberButton = ($numberPage % $maxPageNavigator)+1;
			
		}
		else
		{
			$view->pageNavigatornumberButton = $maxPageNavigator;
		}
		
    }
}









