<?php

class MasterController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
    }

    public function indexAction()
    {
        // action body
    }

    /** This function shows a form where the master can insert topic-parameters like content or source.
      * If an error occurred in validateAction, this page will show an errormessage.
      */      
    public function importAction()
    {
        //session_start(); .............
        if ( isset($_GET['error'])) 
        {
            switch ($_GET['error'])
            {
                case 1: $this->view->errorMsg = 'Themen-Name bereits vergeben!'; 
                        break;
                
                case 2: $this->view->errorMsg = 'Bitte alle Felder füllen!';
                        break;
                default: 
            }
        }
        $topicForm = new Application_Form_CreateTopic();
		$this->view->topicForm = $topicForm;
    }

    /* This function inserts topic-parameters in the database */
    public function validateAction()
    {
        //session_start(); ............
		
        /* save content of posted variables */
        $topicName = $_POST['topicName'];
		$contentType = $_POST['contentType'];
		$topicContent = nl2br($_POST['topicContent']);
		$topicSource = $_POST['topicSource'];
		
        /* if the form-textfields where filled */
		if ( (empty( $topicName)) || (empty( $topicContent)))
		{	
            $this->_redirect('master/import?error=2');
        }
        
        /* HTTP-Request to get body of spezified page */
		if ($contentType == 'link')
		{
			$topicSource = $topicContent;
            $client = new Zend_Http_Client($topicContent);
            $response = $client->request();
            $body = $response->getBody();
            $body = preg_replace('/<a[^>]+>/i', '', $body); //removes <a> tags
            $topicContent = $body;
        }
            
        $topicModel = new topicModel();
        $result = $topicModel->createTopic( $topicName, $topicContent, $topicSource);
            
        if ( !$result)
        {
            $this->_redirect( 'master/import?error=1');
        }
    }

    /**
     * overview of friends
     * 
     * @param string $friends all information in the table 'user' of 'webressource'
     * @author Peter Kornowski
     */
    public function friendAction()
    {
            $userModel = new UserModel();
            $this->view->friends = $userModel->getAllUser();
            $createFriendForm = new Application_Form_CreateFriend();
            $createFriendForm->addButton();
            $this->view->createFriendForm = $createFriendForm;
    }

    public function showfriendAction()
    {
        if ($this->getRequest()->isPost()) //avoid direct access
        {
            //load models
            $userTopicModel = new UserTopicModel;
            $userModel = new UserModel();

            $user = $userModel->getUser($_POST['userID']);
            //pass first name
            if(empty($user['first_name']))
            {
                $this->view->first_name = 'Herr/Frau';
            }
            else
            {
                $this->view->first_name = $user['first_name'];
            }
            //pass last name
            if(empty($user['last_name']))
            {
                $this->view->last_name = 'Unbekannt';
            }
            else
            {
                $this->view->last_name = $user['last_name'];
            }
            //pass email
            $this->view->email = $user['email'];

            echo $topics = $userTopicModel->getTopics($_POST['userID']);
            //_________MUSS NOCH ÜBERARBEITET WERDEN____________________
        }
    }

    /** This function shows a list of all available topics on the left side of the page.
      * If a topic is selected, his content will get shown in a iframe.
      * The master is also able to access other functions like edittopic, invite, showcomments from this page.
      */
    public function showtopicsAction()
    {
        $topicModel = new topicModel();
        
        switch ( $_GET['error'])
        {
            case 1: $this->view->msg = 'Bitte füllen Sie das Feld Kommentar!';
            // .........................
        }
        
        
        /* get all topics as rowSet and sent it to the view */
		$topicList = $topicModel->getTopicList();
		
        foreach( $topicList as $topic)
        {
            $navi .= '<li><a href="http://localhost/Webressourcen/public/master/showtopics?id='.$topic['topicID'] . '&ver=' . $topicModel->getMaxTopicVersion( $topic['topicID']) . '">';
            $navi .= $topic['topicName'].'</a></li>';
        }
        $this->view->placeholder( 'navi')->append( '<div id = "main_Menue"><ul>' . $navi . '</ul></div>');
        
        /* topic was already selectet to show */
        if ( isset( $_GET['id']))
        {
            $topicID = $_GET['id'];
            /* set version to standard if not available */
            if (!isset( $_GET['ver']))
            {
                $selectedTopicVersion = $topicModel->getMaxTopicVersion( $topicID);
            }
            else // use the postet version number 
            $selectedTopicVersion = $_GET['ver'];
            
            /* sent the version number to the view */
            $this->view->selectedTopicVersion = $selectedTopicVersion;
            
            /* use the topicID and selectedTopicVersion to get row with the content of the selected topic */
            $topicRow = $topicModel->getTopic( $topicID, $selectedTopicVersion);
            
            /* get the topicName by topicID */
            $topicName = $topicModel->getTopicName( $topicID);
            
            /* select all versionnumbers and send them to the view as rowSet */
			$option = array("topicID" => $topicID);
            $topicVersionArray = $topicModel->getVersionNumbers( $option);
            $this->view->topicVersionArray = $topicVersionArray;
            
            /* there exists a topic with the specified topicID and topicVersion */
            if ( !empty( $topicRow))
            {
                $topicSource = $topicRow['topicSource'];
                
                /* set the topicSource if empty */
                if ( empty( $topicSource))
                {
                    $topicSource = 'nicht angegeben/bekannt';
                }
                
                /* send topicName and content (includes the topicVersion, topicContent and topicSOurce) to the view */
                $this->view->topicName = $topicName;
                $topicContent = '<iframe src = "topicview?id=' . $topicID . '&ver=' . $selectedTopicVersion . '" name = "topicview" width = "90%" height="600"></iframe><p>Quelle: ' . $topicSource;                
                $topicContent .= '<p><a href = "http://localhost/Webressourcen/public/master/edittopic?id=' . $_GET['id'] . '&ver=' . $selectedTopicVersion . '">';
                $topicContent .= 'Inhalt überarbeiten</a>';
                $this->view->topicContent = $topicContent;
                
                
                
                
                //-----------------show comments-----------------------
                $comment = new CommentModel;
                
                /* get all comments of the selected topic, as rowSet */
                $commentRowSet = $comment->getComment( array(   'topicID' => $topicID,
                                                                'topicVersion' => $selectedTopicVersion,    
                                                                'orderup' => 0,
                                                                'page' => 1,
                                                                'number' => 3));
                
                if ( !empty( $commentRowSet))
                {
                    /* send the rowSet with user-comments and names to the view */
                    $this->view->CommentRowSet = $commentRowSet;
                }
                
                $userID = 1; //test-purpose
                /* send a generated comment-creation-form to the view */
                $createCommentForm = new Application_Form_CreateComment();
                $createCommentForm->setIDs( $topicID, $userID, $selectedTopicVersion);
                $this->view->createCommentForm = $createCommentForm;
                
            }
            else // no topic for the specified topicID + topicVersion
            {
                $this->view->topicContent = '<h1>Kein Thema vorhanden!</h1>';
            }
        }
    }

    public function lockfriendAction()
    {
        // action body
    }

    public function closetopicAction()
    {
        $topicModel = new TopicModel();
        
        $topicModel->delete( 'topicID = ' . $_POST['topicID']);    //auf erfolg testen?
        
        $this->view->msg = 'Thema wurde erfolgreich gelöscht!';
    }

    public function closeAction()
    {
        // action body
    }

    /**
     * This function sends all user to the view
     * 
     * @param string $friends all information in the table 'user' of 'webressource'
     * @author Peter Kornowski
     */
    public function inviteAction()
    {
        if ($this->getRequest()->isPost())	//avoids direct access without having information passed
        {
            //load master session and save topicID
            $masterNamespace = new Zend_Session_Namespace('master');
            $masterNamespace->currentTopic = $_POST['topicID'];

            $userModel = new UserModel();
            $this->view->friends = $userModel->getAllUser();
            $createFriendForm = new Application_Form_CreateFriend();
            $createFriendForm->addSendButton();
            $this->view->createFriendForm = $createFriendForm;
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /**
     * This function sends emails to the friends and saves the connection in userTopic
     * 
     * @param string $_POST[$i] particular emailaddress of the user whit the userID $i
     * @author Peter Kornowski
     */
    public function sendAction()
    {
        //load master session
        $masterNamespace = new Zend_Session_Namespace('master');

        if ($masterNamespace->currentTopic > 0)	//avoids direct access without having topicID
        {
            //load models
            $userTopicModel = new UserTopicModel;
            $userModel = new UserModel();
            $topicModel = new TopicModel();

            //transfer information
            $topicID = $masterNamespace->currentTopic;
            $topicName = $topicModel->getTopicName( $topicID );
            //and set topicID in the master session to 0
            $masterNamespace->currentTopic = 0;

            $config = array('auth' => 'login',	//login mail-server
                'username' => 'swp12-6@gmx.de',
                'password' => 'BKLRswp12');
 
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmx.net', $config);

            $max = $userModel->getMaxUserID();

            $mail = new Zend_Mail();		//create mail
            $mail->setBodyText('Einladung zu '. $topicName);
            $mail->setFrom('swp12-6@gmx.de', 'Webressourcen');
            $mail->setSubject('Einladung zu '. $topicName);

            if ($this->getRequest()->isPost())	//direct access from invite
            {
                for($i=1; $i<=$max; $i++)		//send to all 
                {
                    if(isset($_POST[$i]))		//who are checked
                    {
                        $mail->addTo($_POST[$i]);
                    // --- also save the connection in userTopic ---
                        $hash = md5("U". $i ."T". $topicID); //the hashcode
                        $userTopic = array('userID'  => $i,
                                           'topicID' => $topicID,
                                           'hash'    => $hash);
                        $userTopicModel->addUserTopic($userTopic);
                    }
                }
            }
            else				//access from create friend
            {
                $mail->addTo($masterNamespace->email);
            // --- also save the connection in userTopic ---
                $hash = md5("U". $masterNamespace->userID ."T". $topicID); //the hashcode
                $userTopic = array('userID'  => $masterNamespace->userID,
                                   'topicID' => $topicID,
                                   'hash'    => $hash);
                $userTopicModel->addUserTopic($userTopic);
            }

            //unset informarion of the friend in master session
            $masterNamespace->email  = 0;
            $masterNamespace->userID = 0;

            try	//finilly try to send the mail
            {
                $mail->send($transport);
                $this->_redirect("/master/showtopics?id=$topicID&ver=".$topicModel->getMaxTopicVersion($topicID));
            }
            catch (Exception $e)
            {
                //error message
                $this->view->error = "Es ist ein Fehler beim Senden aufgetretten";
            }
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /* sends the topicContent to the view, so the master is able to edit it in a textarea */
    public function edittopicAction()
    {        
        //session_start(); ..........
        
        if ( isset( $_GET['id']))
        {
            $topicID = $_GET['id'];
            
            /* set topicVersion to default if necessary and send it to the view */
            if ( !isset( $_GET['ver']))
            {
                $topicVersion = 1;
            }
            else $topicVersion = $_GET['ver'];
            $this->view->topicVersion = $topicVersion;
            
            $topicModel = new topicModel();
            
            $topicName = $topicModel->getTopicName( $topicID);    //get topicName if available
            
            /* topics with spezified topicID are available */
            if ( !empty( $topicName)) 
            {
                switch ( $_GET['error'])
                {
                    case 1: $this->view->msg = 'Bitte alle Felder füllen!';
                            break;
                    case 2: $this->view->msg = 'Fehler bei der Versionserstellung! Bitte wenden SIe sich an den Administrator.';
                            break;
                }
                $this->view->topicName = $topicName;
                
                $topicRow = $topicModel->getTopic( $topicID, $topicVersion);
                
                /* if link specified version is available for this topic */
                if ( !empty( $topicRow))
                {
                    $this->view->topicContent = str_replace("<br />", "", $topicRow['topicContent']);
                    $this->view->topicSource = $topicRow['topicSource'];
                }
                else $this->view->msg = 'Angegebende Version existiert für dieses Thema nicht!';
            }
            else $this->view->msg = 'Kein Thema zum bearbeiten vorhanden!';
        }
        else $this->view->msg = 'Keine Themen-ID angegeben!';
    }

    /* This function creates a new topicVersion with the posted topicContent and topicSource */
    public function validateeditAction()
    {
        $topicModel = new TopicModel();
        
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        $topicContent = nl2br( $_POST['topicContent']);
        $topicSource = $_POST['topicSource'];
        
        if ( (empty( $topicID)) || (empty( $topicVersion)) || (empty( $topicContent)) || (empty( $topicSource)))
        {
            $this->_redirect( 'edittopic?id=' . $topicID . '&ver=' . $topicVersion . '&error=1');
        }
        
        if ( $topicModel->createNewTopicVersion( $topicID, $topicContent, $topicSource))
        {           
                $this->view->msg = 'Neue Version wurde erstellt!';
        }
        else $this->_redirect( 'edittopic?id=' . $topicID . '&ver=' . $topicVersion . '&error=2');
    }

    /* inserts a comment in the database */
    public function validatecommentAction()
    {
        /* save posts in variables */
        $commentText = $_POST['commentText'];
        $userID = $_POST['userID'];
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        $anonymous = $_POST['anonymous'];
        
        if ( (empty( $userID)) || (empty( $topicID)) || (empty( $topicVersion)))
        {
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
        }
        if ( empty( $commentText))
        {
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion . '&error=1');
        }
        
        $commentModel = new CommentModel();
        
        try
        {
            $commentModel->insert( array( 'commentText' => $commentText, 'userID' => $userID, 'topicID' => $topicID, 'topicVersion' => $topicVersion, 'anonymous' => $anonymous));
        }
        catch (Exception $e)
        {
            //.........................................
        }
        
        $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
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

    /* Shows comments on extra pages with 10 comments per page. */
    public function showcommentsAction()
    {
        //.....session, ausnahmen.............
        $topicID = $_GET['id'];
        $topicVersion = $_GET['ver'];
        $page = $_GET['page'];
        
        $commentModel = new CommentModel();
        
        $commentNumber = $commentModel->countComments( $topicID, $topicVersion);
        
        if ( $commentNumber)
        {
            $this->view->pageNumber = ceil( $commentNumber / 10);
        
            $commentRowSet = $commentModel->getComment( array(  'topicID' => $topicID,
                                                                'topicVersion' => $topicVersion,    
                                                                'orderup' => 0,
                                                                'page' => $page,
                                                                'number' => 10));
                
            if ( !empty( $commentRowSet))
            {    
                /* send the rowSet with user-comments and names to the view */
                $this->view->CommentRowSet = $commentRowSet;
            }
        }
    }
    
    /**
     * .inserts a new friend in the database and redirects to the send page,
     * to invite the new created friend. 
     */
    public function createfriendAction()
    {
        //load master session
        $masterNamespace = new Zend_Session_Namespace('master');

        if ($this->getRequest()->isPost())	//avoids direct access without having information passed
        {
            // load all inforation
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $adresse = $_POST['adresse'];
            
            if ( !(empty($email)) )		//if email address is entered
            {
                $userModel = new UserModel();
    
                try				//try to save the user
                {
                    $userID = $userModel->insert( 
                        array( 'first_name' => $firstName, 
                               'last_name' => $lastName,
                               'email' => $email,
                               'job' => $job,
                               'adresse' => $adresse)
                        );
                }
                catch (Exception $e)
                {
                    //set topicID in the master session to 0
                    $masterNamespace->currentTopic = 0;
                    //error message
                    $this->view->error = "Es ist ein Fehler beim Speicher aufgetretten";
                    break;
                }
    
                if ( $masterNamespace->currentTopic > 0 )	//if topicID is passed
                {    
                    $masterNamespace->email  = $email;
                    $masterNamespace->userID = $userID;
                    $this->_redirect( '/master/send');  
                }
                else
                {
                    $this->_redirect( '/master/friend');
                }
            }
            //set topicID in the master session to 0
            $masterNamespace->currentTopic = 0;
            //error message
            $this->view->error = "Sie haben vergessen eine E-Mail-Adresse anzugeben.";
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }    
}
?>
