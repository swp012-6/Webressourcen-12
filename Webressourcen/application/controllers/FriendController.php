<?php

class FriendController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        Zend_Layout::getMvcInstance()->setLayout('friend');
        
        //init-------------------------------
		$view = $this->initView();		//combines controller with view
		$request = $this->getRequest();	//operation with datatransfer (post,get
        
        //Init the Database 
		$dbTopic = new TopicModel();
        
        //main_menue
        //title
        $view->main_menue_title = "select Topic";
        
        //get the topics
        $topics = $dbTopic->getTopicList();
        $view->main_menue_topics = $topics;
        
        if(NULL != $request->getQuery("topic"))
        {
            //save in the session the new TopicID
            $friendSession = new Zend_Session_Namespace('friendSession');
            $friendSession->topicID = $request->getQuery("topic");
        }  
    }

    /**
        with the indexAction log in the friend
    */
    public function indexAction()
    {
        
        //init-------------------------------
		$view = $this->initView();		//combines controller with view
		$request = $this->getRequest();	//operation with datatransfer (post,get
        
        //Init the Database 
		$dbTopic = new TopicModel();
        $dbUserTopic = new UserTopicModel();
        
        //read the hashcode
        if(NULL == $request->getQuery("hash"))
        {
            //if no hashcode in the URL, then go to IndexController
            $this->_redirect('/');
            
        }
    
        //get the userID an topicID about the hash
        $usertopic = $dbUserTopic->registerHash($request->getQuery("hash"));
        $userID =$usertopic['userID'];
        $topicID =$usertopic['topicID'];

        if(empty($userID) || empty($topicID))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/');          
        }
        
        //session init and pull userID and topicID inside
        $friendSession = new Zend_Session_Namespace('friendSession');
        $friendSession->userID = $userID;
        $friendSession->topicID = $topicID;
        
        //no friend can not log in as Master
        //if($usertopic[] == true)
        if($usertopic['userName'] == NULL)
        {
            //jump to createName
            $this->_redirect('/Friend/createname');
        }
        
        //jump to the topic
        $this->_redirect('/Friend/showtopic');
        
    }

    public function createnameAction()
    {
    
        //init-------------------------------
		$view = $this->initView();		//combines controller with view
		$request = $this->getRequest();	//operation with datatransfer (post,get)
		
		//formula init
		$form = new Zend_Form();
		$form->setMethod('post');	//datatransfare with post
		$form->setAction('createname');
		
		//Init the Database 
		$dbUserTopic = new UserTopicModel();
	
            
        
		//createName Option----------------
        
        //look to the global session.
        //if the session empty, then jump to the indexside 
        
        //session init and pull userID and topicID inside
        $friendSession = new Zend_Session_Namespace('friendSession');
        $userID = $friendSession->userID;
        $topicID = $friendSession->topicID;
        
        if(empty($userID) || empty($topicID))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
        }
        
		//head Title----------------------------
		$view->headTitle("ADD Name");
		
		//title -----------------
		$view->friendTopicTitel = "ADD Name";
        
		//FORMULAR------------------------------------------------
		// Name	
		$form->addElement('text','name');
		$form->name->setLabel('UserName : ');
		$form->name->setRequired(true);
        
        
		//$form->name->addValidator('stringLength', true, array(0, 20));
		//exaption for name
		$notEmpty = new Zend_Validate_NotEmpty();
		$notEmpty->setMessage('Pleas write the UserName!');
		$form->name->addValidator($notEmpty);
		
		//submintbutten create with name 'send'
		$form->addElement('submit','send');
         
		//when comment is empty ore when its the first attempt, is send the form  to the viewer
		if(!$request->isPost() || !$form->isValid($_POST))
		{
            //send form to view
			$view->form = $form;
		}
		else// its the input correctly, then send the results to the database
		{
			$name = $form->getValue('name');
            $dbUserTopic->setUserName($userID,$topicID,$name);
			//jump to the topic
            $this->_redirect('/Friend/showtopic');
			
		}   
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
        
        //look to the global session.
        //if the session empty, then jump to the indexside 
        
        //session init and pull userID and topicID inside
        $friendSession = new Zend_Session_Namespace('friendSession');
        $userID = $friendSession->userID;
        $topicID = $friendSession->topicID;
        $topicVersion = $friendSession->topicVersion;

        if(empty($userID) || empty($topicID) || empty($topicVersion))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
        }
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
		$dbRating = new TopicRatingModel();
        
		//Topic select--------------------
        //look to the global session.
        //if the session empty, then jump to the indexside 
        
        //session init and pull userID and topicID inside
        $friendSession = new Zend_Session_Namespace('friendSession');
        $userID = $friendSession->userID;
        $topicID = $friendSession->topicID;
        $topicVersion = $friendSession->topicVersion;
        if(empty($userID) || empty($topicID))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
        }
        $view->userID = $userID;
        $view->topicID = $topicID;
        
		//version
		//if the latest version
        if(empty($friendSession->topicVersion))
        {
            $option = array("topicID" => $topicID, "number" =>1,"page" => 0);
            $version = $dbTopic->getVersionNumbers($option);
            foreach($version as $v)
            {
                $topicVersion = $v;
            }
            $friendSession->topicVersion = $topicVersion;
        }
		//selected another version
		
		if(NULL != ($request->getQuery("topicVersion")))
		{
           
			$topicVersion = $request->getQuery("topicVersion");
            $friendSession->topicVersion = $topicVersion;
		}
        $view->currentTopicVersion = $topicVersion;
		
		//versions select
        //if the first side, for the first call
		$option = array("topicID" => $topicID,"topicVersion"=>$topicVersion);
		$page = $dbTopic->getTheNumberFromVersion($option);
		if(NULL != ($request->getQuery("topicVersion")))
		{
			$option = array("topicID" => $topicID,"topicVersion"=>$request->getQuery("topicVersion"));
			$page = $dbTopic->getTheNumberFromVersion($option);
		}
        
		$maxVersionPage = 5;
		
        
        
    
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
        $view->versionTitle = "Topic Version:  ";
		//compute currentPageNavigator
		$currentPageNavigator = floor(($maxVersionPage-($page-1)) / $maxVersionPage);
        if(NULL != $request->getQuery("PageNavigator"))
        {
            $currentPageNavigator = $request->getQuery("PageNavigator");
        }
		$view->currentPageNavigator = $currentPageNavigator;

		//compute numberPageNavigator
		$numberPageNavigator = floor($dbTopic->getNumberVersion($topicID) / $maxVersionPage);
		$view->numberPageNavigator = $numberPageNavigator;
		
		//get VersionsID 
		$option = array("topicID" => $topicID, "number" =>$maxVersionPage,"page" => $currentPageNavigator);
		$version = $dbTopic->getVersionNumbers($option);
		$view->version = $version;
		
		
		
		//topic view----------------------------------------
		$topicAdditiveContent = $dbTopic->getTopic($topicID,$topicVersion);
        $view->topicSource = "Source: ".$topicAdditiveContent['topicSource'];
        
        //Rating+++++++++++++++++++++++++++++++++++++++++++++++++
        
        //Friend Rating-------------------------------------
        
        //Friend Rating title
        $view->ratingTitleFriend = "Your Rating: ";
        
        //have create a rating
        if(1 == $request->getPost("RatingCreate"))
        {
            $dbRating->createRating($topicID,$topicVersion,$userID);
        }
        
        //update the Rate
        if(0 < $request->getPost("RatingUpdate"))
        {
            $dbRating->updateRating($topicID,$topicVersion,$userID,$request->getPost("RatingUpdate"));
        }
        
        
        $ratingPoint = $dbRating->getRatingPoint($topicID,$topicVersion,$userID);
        
        //if the ratingPoint == NULL, then have not rate the friend
        if($ratingPoint == NULL)
        {
           $view->ratingPoint = 0; //is 0-> show then a button to create the rating
        }
        else
        {
            $view->ratingPoint = $ratingPoint;
        }
        
        //TopicRating-------------------------------------------
        //title of the Rating from all friends
        $view->ratingTitleAll = "Topic rating: ";
        
        //is the topic rating from owne Version
        $ratingpercent = $dbRating->getRating($topicID,$topicVersion);
        $view->ratingpercent = $ratingpercent;
        
        //if the rating == 0, then have not rated
        if($ratingpercent == 0)
        {
            $view->topicrating = "not rated";
        }
        else
        {
            $ratingstars = ceil((($ratingpercent*100)-20)/(16));
            if($ratingstars <= 0)
            {
                $ratingstars = 1;
            }
            elseif(5 < $ratingstars)
            {
                $ratingstars = 5;
            }
            $view->topicrating = $ratingstars;
        }
        
        
		//comment view++++++++++++++++++++++++++++++++++++++++++
       
		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false,"number" => 3,"page" => 1);
		$view->friendComment = $dbComment->getComment($commentOption);
			
    }
	/** Controller of the page which contains the topicContent.
      * This page is the target of a iframe in showtopic.
      */
    public function topicviewAction()
    {
        $this->_helper->layout()->disableLayout();
        
        //validation ...............
        
        $topicModel = new TopicModel();
        
        $topicRow = $topicModel->getTopic( $_GET['id'], $_GET['ver']);
                
        /* if link specified version is available for this topic */
        if ( !empty( $topicRow))
        {
            $this->view->topicContent = $topicRow['topicContent'];
        }
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
        
        //look to the global session.
        //if the session empty, then jump to the indexside 
        
        //session init and pull userID and topicID inside
        $friendSession = new Zend_Session_Namespace('friendSession');
        $userID = $friendSession->userID;
        $topicID = $friendSession->topicID;
        $topicVersion = $friendSession->topicVersion;
        if(empty($userID) || empty($topicID) || empty($topicVersion))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
        }
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

		$commentOption = array("topicID" => $topicID,"topicVersion"=>$topicVersion, "orderup"=>false, "number" => $maxComment,"page" => $page+1);
		$view->friendComment = $dbComment->getComment($commentOption);
		

		//Page Navigator+++++++++++++++++++++++++++++++++++++++++++++++
		
		
		//determine number of Pages
		$view->maxPageNavigator = $maxPageNavigator;
		
		$numberPage = floor($dbComment->countComments($topicID,$topicVersion) / $maxComment); //MAX Page number

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









