﻿<?php

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
		$dbUserTopic = new UserTopicModel();
        $dbTopic = new TopicModel();
        
        //Init Session
        $friendSession = new Zend_Session_Namespace('friendSession');
        
        if((empty($friendSession->userID) || empty($friendSession->topicID))&&(NULL == $request->getQuery("hash")))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
        }
        
        // if the hash invalid than kicked out
        $userTopicHash = $dbUserTopic->registerHash($friendSession->hash);
        
        if((empty($userTopicHash["userID"])||empty($userTopicHash["topicID"]))&&(NULL == $request->getQuery("hash")))
        {
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/'); 
           
        }
        
        //language init
        
        $languageNamespace = new Zend_Session_Namespace( 'language');
        
        if ( isset( $_GET['lang']))
        {
            $languageNamespace->lang = $_GET['lang'];
        }
        
        $registry = Zend_Registry::getInstance();
        $translate = $registry->get( 'Zend_Translate');
        $this->_translate = $translate;
        switch ( $languageNamespace->lang)
        {
            case 'de':  $translate->setLocale( 'en'); break;
            default:    $translate->setLocale( 'de');
        }   
        
        if(NULL == $request->getQuery("hash"))
        {
            
            //main_menue
            //title
            $view->main_menue_title = $this->_translate->_("Thema auswählen: ");
        
            //get the topics
            $topicIDs = $dbUserTopic->getTopics($friendSession->userID);
        
            $topics;
            $count = 1;
            foreach($topicIDs as $tID)
            {
                $topics[$count]['topicID'] = $tID['topicID'];
                $topics[$count]['topicName'] = $dbTopic->getTopicName($tID['topicID']);
            
                $count++;
            }
            $view->main_menue_topics = $topics;
        
        
            if(NULL != $request->getQuery("topic"))
            {
                //save in the session with new TopicID
            
                $friendSession->topicID = $request->getQuery("topic");
            
                $option = array("topicID" => $request->getQuery("topic"), "number" =>1,"page" => 0);
                $version = $dbTopic->getVersionNumbers($option);
                foreach($version as $v)
                {
                    $topicVersion = $v;
                }
                $friendSession->topicVersion = $topicVersion;
            }  
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
        
        //Session init
        $friendSession = new Zend_Session_Namespace('friendSession');
        
        //read the hashcode
        if(NULL == $request->getQuery("hash"))
        {
            $friendSession->userID = NULL;
            $friendSession->topicID = NULL;
            
            //if no hashcode in the URL, then go to IndexController
            $this->_redirect('/');
           
        }
    
        //get the userID an topicID about the hash
        $usertopic = $dbUserTopic->registerHash($request->getQuery("hash"));
        $userID =$usertopic['userID'];
        $topicID =$usertopic['topicID'];
        
        if(empty($userID) || empty($topicID)||(true == $usertopic['master']))//no friend can not log in as Master
        {
            $friendSession->userID = NULL;
            $friendSession->topicID = NULL;
            //if the userID ore the topicID empty, then go to IndexController
            $this->_redirect('/');          
        }
        
        //session init and pull userID and topicID inside
        
        $friendSession->userID = $userID;
        $friendSession->topicID = $topicID;
        $friendSession->hash = $request->getQuery("hash");
      
        
        //have not the user a userName, then update his name 
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
        $dbTopic = new TopicModel();
            
        
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
		$view->headTitle($this-> _translate-> _("Name ändern"));
		
		//title -----------------
		$view->friendTopicTitel = $this-> _translate-> _( 'Name ändern für das Thema:'). ' "'. $dbTopic->getTopicName($topicID). '"';
        
		//FORMULAR------------------------------------------------
		// Name	
		$form->addElement('text','name');
		$form->name->setLabel($this-> _translate-> _('Name:  '));
		$form->name->setRequired(true);
        
        
		//$form->name->addValidator('stringLength', true, array(0, 20));
		//exaption for name
		$notEmpty = new Zend_Validate_NotEmpty();
		$notEmpty->setMessage($this-> _translate-> _('Bitte schreiben sie einen Namen rein!'));
		$form->name->addValidator($notEmpty);
		
		//submintbutten create with name 'send'
		$form->addElement('submit',$this-> _translate-> _('Ändern'));
         
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
		$view->headTitle($this-> _translate-> _("Kommentar Hinzufügen - ").$dbTopic->getTopicName($topicID));
		        
		//title -----------------
		$view->friendTopicTitel = ($this-> _translate-> _("Kommentar Hinzufügen - ").$dbTopic->getTopicName($topicID));
	       
		//FORMULAR------------------------------------------------
		//Label-> Name
		$form->addElement('checkbox','name');
		$form->name->setLabel($this-> _translate-> _('Wollen Sie anonym bleiben?'));
	   
		//Comment area: 	-it's important information
		//					-max 500 symbols
		$form->addElement('textarea','comment');
		$form->comment->setLabel($this-> _translate-> _('Kommentar :'));
		$form->comment->setRequired(true);
		$form->comment->addValidator('stringLength', true, array(0, 500));
		//exaption for comment
		$notEmpty = new Zend_Validate_NotEmpty();
		$notEmpty->setMessage($this-> _translate-> _('Bitte geben Sie ein Kommentar ein!'));
		$form->comment->addValidator($notEmpty);
		
		//submintbutten create with name 'send'
		$form->addElement('submit',$this-> _translate-> _('Hinzufügen'));
        
        //Backbutton
        $view->Bachbutton = $this-> _translate-> _('Themen Übersicht') ; 

		//when comment is empty ore when its the first attempt, is send the form  to the viewer
		if(!$request->isPost() || !$form->isValid($_POST))
		{
			$view->form = $form;
		}
		else// its the input correctly, then send the results to the database
		{
			$name = $form->getValue('name');
			$comment = $form->getValue('comment');
			
            //the comment was filtered. words there are to long, are cuted
            
            $maxWordLength = 100;
            $words_before = explode(" ", $comment);
            $words_after;
            $wordcount = 0;
            
            foreach($words_before as $word)
            {
                if($maxWordLength < strlen($word))
                {
                    for($i = 0; $i < ((strlen($word))/$maxWordLength); $i++)
                    {
                        $words_after[$wordcount] = substr($word,($i*$maxWordLength),$maxWordLength);
                        if($i < (((strlen($word))/$maxWordLength)-1))
                        {
                            $words_after[$wordcount] .= "- ";
                        }
                        $wordcount++;
                    }
                }
                else
                {
                    $words_after[$wordcount] = $word;
                
                    $wordcount++;
                }
            }
            
            $comment = implode(" ",$words_after);
            
			//array for the database
			$conntent = array("userID" => $userID,"topicID"=>$topicID,"topicVersion" => $topicVersion,"anonymous"=> $name,"commentText"=>$comment);
			//save
			$dbCommentsuccessfull = $dbComment->addComment($conntent);
			//user message
            if($dbCommentsuccessfull == 1)
            {
                $view->message = $this-> _translate-> _('Kommentar wurder erfolgreich hinzugefügt');
            }
            else
            {
                $view->message = $this-> _translate-> _('Kommentar wurder nicht erfolgreich hinzugefügt');
            }
			
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
        $dbUserTopic = new UserTopicModel();
        
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
        
        //have not the user a userName, then update his name 
        $userTopicoption = array( "userID"=> $userID, "topicID" => $topicID);
        if(($dbUserTopic->getUserName($userTopicoption)) == NULL)
        {
            //jump to createName
            $this->_redirect('/Friend/createname');
        }
        
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
        $view->versionTitle = $this-> _translate-> _("Version:  ");
		//compute currentPageNavigator
		$currentPageNavigator = floor((($dbTopic->getNumberVersion($topicID))-($page)) / $maxVersionPage);
        
        if(NULL != $request->getQuery("PageNavigator"))
        {
            $currentPageNavigator = $request->getQuery("PageNavigator");
        }
		$view->currentPageNavigator = $currentPageNavigator;

		//compute numberPageNavigator
		$numberPageNavigator = ceil(($dbTopic->getNumberVersion($topicID) / $maxVersionPage)-1);
		$view->numberPageNavigator = $numberPageNavigator;
		
		//get VersionsID 
		$option = array("topicID" => $topicID, "number" =>$maxVersionPage,"page" => $currentPageNavigator);
		$version = $dbTopic->getVersionNumbers($option);
		$view->version = $version;
		
		
		
		//topic view----------------------------------------
		$topicAdditiveContent = $dbTopic->getTopic($topicID,$topicVersion);
        $view->topicSource = $this-> _translate-> _("Quelle: ").$topicAdditiveContent['topicSource'];
        
        //Rating+++++++++++++++++++++++++++++++++++++++++++++++++
        
        //Friend Rating-------------------------------------
        
        //Friend Rating title
        $view->ratingTitleFriend = $this-> _translate-> _("Ihre Bewertung: ");
        
        
        //Rating button 
        $view->RatingButton = $this-> _translate-> _('Wollen Sie das Thema Bewerten?');
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
        $view->ratingTitleAll = $this-> _translate-> _("Wertung des Themas: ");
        
        //is the topic rating from owne Version
        $ratingpercent = $dbRating->getRating($topicID,$topicVersion);
        $view->ratingpercent = $ratingpercent;
        
        //if the rating == 0, then have not rated
        if($ratingpercent == 0)
        {
            $view->topicrating = "off";
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
        
        //Buttons : ALL Comment, Add Comment and Update Name, Delete
        $view->ButtonAllComment = $this-> _translate-> _('Alle Kommentare');
        $view->ButtonAddComment = $this-> _translate-> _('Kommentar hinzufügen');
        $view->ButtonUpdateName = $this-> _translate-> _('Name ändern');
        $view->ButtonDelete = $this-> _translate-> _('Löschen');
        
        //User Name anonym
        $view->NameAnonymous = $this-> _translate-> _('Anonym');
			
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
		$view->headTitle($this-> _translate-> _("Alle Kommentare - ").$dbTopic->getTopicName($topicID));
		
		
		//title -----------------
		$view->friendTopicTitel = $this-> _translate-> _("Alle Kommentare - ").$dbTopic->getTopicName($topicID);
		
		//comment view----------------------------------------

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
        
        
        //Buttons : ALL Comment, Add Comment and Update Name, Delete
        $view->ButtonShowTopic = $this-> _translate-> _('Zurück');
        $view->ButtonAddComment = $this-> _translate-> _('Kommentar hinzufügen');
        $view->ButtonUpdateName = $this-> _translate-> _('Name ändern');
        $view->ButtonDelete = $this-> _translate-> _('Löschen');
		
    }
}









