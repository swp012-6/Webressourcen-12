<?php
/* -- INDEX --
 
 - init()
 - importAction()
 - validateAction()
 - friendAction()
 - showfriendAction()
 - showtopicsAction()
 - lockfriendAction()
 - delfriendAction()
 - closetopicAction()
 - closeAction()
 - inviteAction()
 - sendAction()
 - edittopicAction()
 - validateeditAction()
 - validatecommentAction()
 - topicviewAction()
 - showcommentsAction()
 - createfriendAction()
 - httpRequest($url)
 - searchAction()
 - deletecommentAction()
 */

/** This class is the controller for the section ../public/master .
  * Only the master has access to this section by loggin in at ../public/index/prelogin .
  * This controller manages the topic-creation, -deletion, invitation and the update of topics.
  * @author Christoph Beger and Peter Kornowski
  */
class MasterController extends Zend_Controller_Action
{ 
    protected $_translate;
    
    public function init()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
        
        $bootstrap = $this->getInvokeArg( 'bootstrap');
        $this->config = $bootstrap->getOptions();
        
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
    }

    public function indexAction()
    {
        // action body
    }

    /** This function shows a form where the master can insert topic-parameters like content or source.
      * If an error occurred in validateAction, this page will show an errormessage.
      * @author Christoph Beger 
      */      
    public function importAction()
    {
        //session_start(); .............
        if ( isset($_GET['error'])) 
        {
            switch ($_GET['error'])
            {
                case 1: $this->view->errorMsg = $this->_translate->_( 'Themen-Name bereits vergeben!'); 
                        break;
                
                case 2: $this->view->errorMsg = $this->_translate->_( 'Bitte alle Felder füllen!');
                        break;
                case 3: $this->view->errorMsg = $this->_translate->_( 'Ihre Eingabe entsprach keiner gültigen URL!');
                        break;
                default: 
            }
        }
        $topicForm = new Application_Form_CreateTopic(); 
        $this->view->topicForm = $topicForm;
        
        /* set baseUrl for the view */
        $list = explode( '/', $_SERVER['REQUEST_URI']);
        $this->view->baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $list['1'];
    }

    /* This function inserts topic-parameters in the database */
    public function validateAction()
    {
        //session_start(); ............
		
        /* save content of posted variables */
        $topicName = $_POST['topicName'];
		$topicType = $_POST['topicType'];
		$topicContent = nl2br($_POST['topicContent']);
		$topicSource = $_POST['topicSource'];
		
        /* if the form-textfields are not filled */
		if ( (empty( $topicName)) || (empty( $topicContent)))
		{	
            $this->_redirect('master/import?error=2');
        }
        
        /* HTTP-Request to get body of spezified page */
		if ( $topicType)
		{
            /* validate the POST especially the entered URL */
            $form = new Application_Form_CreateTopic();
            if ( !$form->isValid($_POST))
            {
                $this->_redirect('master/import?error=3');
            }
            
			$topicSource = $topicContent;
            
            $topicContent = $this->httpRequest( $topicContent);
        }
            
        $topicModel = new topicModel();
        $result = $topicModel->createTopic( $topicName, $topicContent, $topicSource, $topicType);
            
        if ( !$result)
        {
            $this->_redirect( 'master/import?error=1');
        }
	
        $this->view->topicID = $result;
        $this->view->version = $topicModel->getMaxTopicVersion( $result);
    }

    /**
     * overview of friends
     * 
     * @param string $friends all information in the table 'user' of 'webressource'
     * @author Peter Kornowski
     */
    public function friendAction()
    {
            //load all friends
            $userModel = new UserModel();
            $this->view->friends = $userModel->getAllUser();
            // create friend formular
            $createFriendForm = new Application_Form_CreateFriend();
            $createFriendForm->addButton();
            $this->view->createFriendForm = $createFriendForm;
    }

    /**
     * details of a friend
     * 
     * @param int $_POST['userID'] the ID of the user
     * @param array $infoTopics information about available topics and userName
     * @author Peter Kornowski
     */
    public function showfriendAction()
    {
        if ( isset( $_GET['id'])) //if userID in URL do:
        {
            //load models
            $userTopicModel = new UserTopicModel;
            $userModel = new UserModel();
            $topicModel = new TopicModel();
            // create friend formular
            $createFriendForm = new Application_Form_CreateFriend();
            $createFriendForm->editButton($_GET['id']);
            $this->view->createFriendForm = $createFriendForm;
            //get userID from URL
            $userID = $_GET['id'];
            //load user
            $user = $userModel->getUser($userID);
            //authentification
            if(empty($user['email']))
            {
                $this->_redirect('/master/friend');
            }
            //pass first name
            if(empty($user['first_name']))
            {
                $this->view->first_name = $this->_translate->_( 'Herr/Frau');
            }
            else
            {
                $this->view->first_name = $user['first_name'];
            }
            //pass last name
            if(empty($user['last_name']))
            {
                $this->view->last_name = $this->_translate->_( 'Unbekannt');
            }
            else
            {
                $this->view->last_name = $user['last_name'];
            }
            //invite option
            $invite = $userTopicModel->notInvitedTopics($userID);
            $infoInviteID = array();
            $infoInviteName = array();
            for($i=0; $i<sizeof($invite); $i++)
            {
                $infoInviteID[]   = $invite[$i];
                $infoInviteName[]   = $topicModel->getTopicName($invite[$i]);
            }
            //topics
            $topics = $userTopicModel->getTopics($userID);
            // prepare arrays
            $infoTopicIDs = array();
            $infoTopicNames = array();
            $infoUserNames = array();
            // fill arrays
            for($i=0; $i<sizeof($topics); $i++)
            {
                $infoTopicIDs[]   = $topics[$i]["topicID"];
                $infoTopicNames[] = $topicModel->getTopicName($topics[$i]["topicID"]);
                $infoUserNames[]  = $topics[$i]["userName"];
            }
            //pass all other important information to the view
            $this->view->infoInviteID = $infoInviteID;
            $this->view->infoInviteName = $infoInviteName;
            $this->view->infoTopicIDs = $infoTopicIDs;
            $this->view->infoTopicNames = $infoTopicNames;
            $this->view->infoUserNames = $infoUserNames;
            $this->view->sizeInvite = sizeof($infoInviteID);
            $this->view->sizeTopics = sizeof($infoTopicIDs);
            $this->view->userID = $userID;
            $this->view->email = $user['email'];
            $this->view->job = $user['job'];
            $this->view->adresse = $user['adresse'];

	//Es muss noch eine überarbeitung des Profils ermöglicht werden.

        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /** This function shows a list of all available topics on the left side of the page.
      * If a topic is selected, his content will get shown in a iframe.
      * The master is also able to access other functions like edittopic, invite, showcomments from this page.
      * @author Christoph Beger
      */
    public function showtopicsAction()
    {
        $topicModel = new topicModel();
        
        switch ( $_GET['msg'])
        {
            case 1: $this->view->msg = $this->_translate->_( 'Bitte füllen Sie das Feld Kommentar!');
                    break;
                    
            case 2: $this->view->msg = $this->_translate->_( 'Es wurde erfolgreich eine neue Version erstellt.');
                    break;
                    
            case 3: $this->view->msg = $this->_translate->_( 'Einladungen erfolgreich versendet.');
                    break;
                    
            case 4: $this->view->msg = $this->_translate->_( 'Ihr Kommentar konnte leider nicht erstellt werden!');
            break;
        }
        
        
        /* get all topics as rowSet and sent it to the view */
		$topicList = $topicModel->getTopicList();
		
        $navi = '';
        foreach( $topicList as $topic)
        {
            $navi .= '<a class="Navlink" href="http://localhost/Webressourcen/public/master/showtopics?id='.$topic['topicID'] . '&ver=' . $topicModel->getMaxTopicVersion( $topic['topicID']) . '">';
            $navi .= $topic['topicName'].'</a><br>';
        }

        $this->view->placeholder( 'navi')->append( $navi);
        
        /* topic was already selectet to show */
        if ( isset( $_GET['id']))
        {
            $topicID = $_GET['id'];
            
            /* set version to standard if not available */
            if ( !isset( $_GET['ver']))
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
                    $topicSource = $this->_translate->_( 'nicht angegeben/bekannt');
                }
                
                /* send topicName and content (includes the topicVersion, topicContent and topicSOurce) to the view */
                $this->view->topicName = $topicName;
                $topicContent = '<iframe src = "topicview?id=' . $topicID . '&ver=' . $selectedTopicVersion . '" name = "topicview" width = "90%" height="600"></iframe><p>' . $this->_translate->_( 'Quelle: ') . $topicSource;                

                $this->view->topicContent = $topicContent;
                $this->view->topicTest = 1;
                
                //----------------topic rating-------------------------
                $topicRatingModel = new TopicRatingModel();
                
                $ratingPercent = $topicRatingModel->getRating( $topicID, $selectedTopicVersion);
                $this->view->ratingPercent = $ratingPercent;
        
                //if the topic is not rated yet
                if( !$ratingPercent)
                {
                    $this->view->topicRating = $this->_translate->_( 'noch nicht bewertet');
                }
                else
                {
                    $ratingStars = ceil( (( $ratingPercent * 100) - 20) / (16) );
                    if( $ratingStars <= 0)
                    {
                        $ratingStars = 1;
                    }
                    elseif( 5 < $ratingStars)
                    {
                        $ratingStars = 5;
                    }
                    $this->view->topicRating = $ratingStars;
                }
                
                
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
                    $this->view->commentRowSet = $commentRowSet;
                }
                
                $userID = 1; //test-purpose -------------------------------------------------------------------------------------------------------
                /* send a generated comment-creation-form to the view */
                $createCommentForm = new Application_Form_CreateComment();
                $createCommentForm->setIDs( $topicID, $userID, $selectedTopicVersion);
                $this->view->createCommentForm = $createCommentForm;
                
            }
            else // no topic for the specified topicID + topicVersion
            {
                $this->view->topicTest = 0;
                $this->view->topicContent = '<h1>' . $this->_translate->_( 'Kein Thema vorhanden!') . '</h1>';
            }
        }
    }

    /**
     * deletes the connection between user and topic
     * 
     * @param int $_POST['userID'] the ID of the user
     * @author Peter Kornowski
     */
    public function lockfriendAction()
    {
        if ($this->getRequest()->isPost()) //avoid direct access
        {
            //load model
            $userTopicModel = new UserTopicModel;
            try	// try to delete userTopic
            {
                $userTopicModel->delUserTopic($_POST['userID'], $_POST['topicID']);
                $this->_redirect('/master/showfriend?id='.$_POST['userID']);
            }
            catch (Exception $e)
            {
                $this->view->error = $this->_translate->_( 'Fehler beim Löschen der Verbindung zwischen Freund und Thema');
            }
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /**
     * deletes the user ans his connections
     * 
     * @param int $_POST['userID'] the ID of the user
     * @author Peter Kornowski
     */
    public function delfriendAction()
    {
        if ($this->getRequest()->isPost()) //avoid direct access
        {
            //load model
            $userModel = new UserModel;
            $userTopicModel = new UserTopicModel;
            try	// try to delete userTopic
            {
                $userTopicModel->delete( 'userID = '. $_POST['userID']);
                $userModel->delete( 'userID = '. $_POST['userID']);
                $this->_redirect('/master/friend');
            }
            catch (Exception $e)
            {
                $this->view->error = $this->_translate->_( 'Fehler beim Löschen des Freundes');
            }
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /** This function is called, when an user wants to delete a topic.

      * @author Christoph Beger
      */
    public function closetopicAction()
    {
        if ( !isset( $_POST['topicID']))
        {
            $this->_redirect( '/master/showtopics');
        }
        //load model
        $topicModel = new TopicModel();
        //delete topic, topicAdditives, comments and userTopics
        $success = $topicModel->delTopic( $_POST['topicID']);
        //check result
        if( !$success)
        {						//error message
            $this->view->error = $this->_translate->_( 'Es ist ein Fehler beim Löschen aufgetreten.');
        }
        else
        {
            $this->_redirect('/master/showtopics');	//goes to showtopics
        }
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
            //load models
            $userTopicModel = new UserTopicModel;
            $userModel = new UserModel();
            //get and pass user
            $this->view->friends = $userModel->getAllUser();
            //get userIDs from usertopic
            $users = $userTopicModel->getUsers($_POST['topicID']);
            // prepare arrays
            $infoUserIDs = array();
            // fill arrays
            for($i=0; $i<sizeof($users); $i++)
            {
                $infoUserIDs[] = $users[$i]["userID"];
            }
            //pass userIDs
            $this->view->infoUserIDs = $infoUserIDs;
            //pass topicID
            $this->view->topicID = $_POST['topicID'];

            //create createFriendForm
            $createFriendForm = new Application_Form_CreateFriend();
            $createFriendForm->addSendButton($_POST['topicID']);
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

        if ($masterNamespace->currentTopic > 0 || $this->getRequest()->isPost())	//avoids direct access without having topicID
        {
            //load models
            $userTopicModel = new UserTopicModel;
            $userModel      = new UserModel();
            $topicModel     = new TopicModel();

            //transfer information
            if ($this->getRequest()->isPost())
            {
                $topicID = $_POST['topicID'];
            }
            else
            {
                $topicID = $masterNamespace->currentTopic;
                $userID  = $masterNamespace->userID;
                $email   = $masterNamespace->email;
                //and set IDs in the master session to 0
                $masterNamespace->currentTopic = 0;
                $masterNamespace->userID       = 0;
                $masterNamespace->email        = 0;
            }
            $topicName = $topicModel->getTopicName( $topicID );
            $max = $userModel->getMaxUserID();

            //login mail-server
            $emailConfig = array('auth' => $this->config['email']['auth'],
                             'username' => $this->config['email']['username'],
                             'password' => $this->config['email']['password']);
            $transport = new Zend_Mail_Transport_Smtp( $this->config['email']['host'], $emailConfig);
            //prepare mail
            $mail = new Zend_Mail();
            $mail->setSubject('Einladung zu '. $topicName);
            $mail->setFrom($this->config['email']['username'], 'Webressourcen');

//----access directly from invite----
            if ($this->getRequest()->isPost())
            {
                for($i=1; $i<=$max; $i++)		//send to all 
                {
                    if(isset($_POST[$i]))		//who are checked
                    {
                        $mail->addTo($_POST[$i]);
                    // --- also save the connection in userTopic ---
                        $hash = md5($i .microtime(). $topicID); //the hashcode
                        $userTopic = array('userID'  => $i,
                                           'topicID' => $topicID,
                                           'hash'    => $hash);
                        $userTopicModel->addUserTopic($userTopic);
                        //mail message
                        $mail->setBodyText('Sie haben eine Einladung zu dem Thema '. $topicName ." erhalten.\n"
                                          ."Mit diesem Link koennen Sie das Thema erreichen: "
                                          ."http://".Zend_Controller_Front::getInstance()->getRequest()->getServer("HTTP_HOST")
                                          ."/Webressourcen/public/friend?hash=".$hash);

                        try	//finilly try to send the mail
                        {
                            $mail->send($transport);
                        }
                        catch (Exception $e)
                        {
                            //error message
                            $this->view->error = $this->_translate->_( 'Es ist ein Fehler beim Senden aufgetretten.') . '<br>'
                                                . $this->_translate->_( 'Wahrscheinlich ist eine der E-Mail-Adressen falsch.') . '<br>'
                                                . $this->_translate->_( 'Die Freunde mit korrekten E-Mail-Adressen wurden benachrichtigt.');
                            $error = 1;
                            //delete new userTopic
                            $userTopicModel->delUserTopic($i,$topicID);
                        }
                    }
                }
            }
//----access from create friend----
            else				
            {
                $mail->addTo($email);
            // --- also save the connection in userTopic ---
                $hash = md5($userID .microtime(). $topicID); //the hashcode
                $userTopic = array('userID'  => $userID,
                                   'topicID' => $topicID,
                                   'hash'    => $hash);
                $userTopicModel->addUserTopic($userTopic);
                //mail message
                $mail->setBodyText('Sie haben eine Einladung zu dem Thema '. $topicName ." erhalten.\n"
                                  ."Mit diesem Link erreichen Sie das Thema: "
                                  ."http://".Zend_Controller_Front::getInstance()->getRequest()->getServer("HTTP_HOST")
                                  ."/Webressourcen/public/friend?hash=".$hash);

                try	//finilly try to send the mail
                {
                    $mail->send($transport);
                }
                catch (Exception $e)
                {
                    //error message
                    $this->view->error = $this->_translate->_( 'Es ist ein Fehler beim Senden aufgetretten.') . '<br>'
                                        . $this->_translate->_( 'Wahrscheinlich ist eine der E-Mail-Adressen falsch.') . '<br>'
                                        . $this->_translate->_( 'Die Freunde mit korrekten E-Mail-Adressen wurden benachrichtigt.');
                    $error = 1;
                    //delete new userTopic
                    $userTopicModel->delUserTopic($userID,$topicID);
                }
            }

            
            if($error!=1)
            {
                if($_POST['toUser'])
                {
                    $this->_redirect("/master/showfriend?id=". $_POST['toUser']); 
                }
                else
                {
                   $this->_redirect("/master/showtopics?id=$topicID&ver=".$topicModel->getMaxTopicVersion($topicID)."&msg=3"); 
                }
            }
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }

    /** sends the topicContent to the view, so the master is able to edit it in a textarea 
      * @author Christoph Beger
      */
    public function edittopicAction()
    {        
        //session_start(); ..........
        
        if ( isset( $_GET['id']))
        {
            $topicID = $_GET['id'];
        
            $topicModel = new TopicModel();    
        
            /* set topicVersion to maximum if necessary and send it to the view */
            if ( !isset( $_GET['ver']))
            {
                $topicVersion = $topicModel->getMaxTopicVersion( $topicID);
            }
            else $topicVersion = $_GET['ver'];
            $this->view->topicVersion = $topicVersion;
            
            $topicName = $topicModel->getTopicName( $topicID);    //get topicName if available
        
            /* set baseUrl for the view */
            $list = explode( '/', $_SERVER['REQUEST_URI']);
            $this->view->baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $list['1'];
        
            /* topics with spezified topicID are not available */
            if ( empty( $topicName)) 
            {
                $this->view->msg = '<h1>' . $this->_translate->_( 'Kein Thema zum bearbeiten vorhanden!') . '</h1>';
                $this->view->topicTest = 0;
            }
            else 
            {
                /* error-msg output */
                switch ( $_GET['msg'])
                {
                    case 1: $this->view->msg = $this->_translate->_( 'Bitte alle Felder füllen!');
                            break;
                    case 2: $this->view->msg = $this->_translate->_( 'Ihre Eingabe entsprach keiner gültigen URL.');
                            break;
                }
                $this->view->topicName = $topicName;
                
                $topicRow = $topicModel->getTopic( $topicID, $topicVersion);
                
                /* if there is no topic with the specified versionNumber */
                if ( empty( $topicRow))
                {
                    $this->view->msg = '<h1>' . $this->_translate->_( 'Angegebende Version existiert für dieses Thema nicht!') . '</h1>';
                    $this->view->topicTest = 0;
                }
                else 
                {
                    /* topic type is text ( "0") */
                    if ( !$topicRow['topicType'])
                    {
                        $this->view->topicType = 0;
                        $this->view->topicContent = str_replace("<br />", "", $topicRow['topicContent']);
                    }
                    else //if topic type is link ( "1"), just show the URL
                    {
                        $this->view->topicType = 1;
                        $this->view->topicContent = $topicRow['topicSource'];
                    }
        
                    $this->view->topicSource = $topicRow['topicSource'];
                    $this->view->topicTest = 1;
                }
            }
        }
        else 
        {
            $this->view->msg = '<h1>' . $this->_translate->_( 'Keine Themen-ID angegeben!') . '</h1>';
            $this->view->topicTest = 0;
        }
    }

    /** This function creates a new topicVersion with the posted topicContent and topicSource. 
      * @author Christoph Beger
      */
    public function validateeditAction()
    {
        $topicModel = new TopicModel();
        
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        $topicContent = nl2br( $_POST['topicContent']);
        $topicSource = $_POST['topicSource'];
        $topicType = $_POST['topicType'];
        
        if ( (empty( $topicID)) || (empty( $topicVersion)) || (empty( $topicContent)))
        {
            $this->_redirect( 'master/edittopic?id=' . $topicID . '&ver=' . $topicVersion . '&msg=1');
        }
        
        /* new version contains a link */
        if ( $topicType)
        {
            /* validate the POST especially the entered URL */
            $form = new Application_Form_CreateTopic();
            if ( !$form->isValid($_POST))
            {
                $this->_redirect( 'master/edittopic?id=' . $topicID . '&ver=' . $topicVersion . '&msg=2');
            }
            
            $topicSource = $topicContent;
            $topicContent = $this->httpRequest( $topicContent);
        }
        
        if ( $topicModel->createNewTopicVersion( $topicID, $topicContent, $topicSource, $topicType))
        {           
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . ( $topicVersion + 1) . '&msg=2');
        }
        else 
        {           
            $this->view->error = $this->_translate->_( 'Fehler bei der Versionserstellung.');
        }
    }

    /** inserts a comment in the database 
      * @author Christoph Beger
      */
    public function validatecommentAction()
    {
        /* save posts in variables */
        $commentText = nl2br(strip_tags($_POST['commentText'], '<p><br>'));
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
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion . '&msg=1');
        }
        
        $commentModel = new CommentModel();
        
        try
        {
            $commentModel->insert( array( 'commentText' => $commentText, 'userID' => $userID, 'topicID' => $topicID, 'topicVersion' => $topicVersion, 'anonymous' => $anonymous));
        }
        catch (Exception $e)
        {
            $this->_redirect( 'master/showtopics?id=' .topicID . '&ver=' . $topicVersion . '&msg=4');
        }
        
        $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
    }
    
    /** Controller of the page which contains the topicContent.
      * This page is the target of a iframe in showtopic.
      * @author Christoph Beger
      */
    public function topicviewAction()
    {
        $this->_helper->layout()->disableLayout();
        
        if ( (empty( $_GET['id'])) || (empty( $_GET['ver'])))
        {
            $this->_redirect( 'master/showtopics');
        }
        
        $topicModel = new TopicModel();
        
        $topicRow = $topicModel->getTopic( $_GET['id'], $_GET['ver']);
                
        if ( !empty( $topicRow))
        {
            $this->view->topicContent = str_replace('<br />', '', $topicRow['topicContent']);
        }
    }

    /** Shows comments on extra pages with 10 comments per page. 
      * @author Christoph Beger
      */
    public function showcommentsAction()
    {
        $topicID = $_GET['id'];
        $topicVersion = $_GET['ver'];
        $page = $_GET['page'];
        
        if ( (empty($topicID)) || (empty($topicVersion)))
        {
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
        }
        
        if ( empty( $page))
        {
            $page = 1;
        }
        
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
                $this->view->commentRowSet = $commentRowSet;
            }
        }
        else 
        {
            $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
        }
    }
    
    /**
     * inserts a new friend in the database and redirects to the send page,
     * to invite the new created friend. 
     */
    public function createfriendAction()
    {

        if ($this->getRequest()->isPost())	//avoids direct access without having information passed
        {
            // load all inforation
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $adresse = $_POST['adresse'];
            $edit = $_POST['edit'];
	//-----EDIT-----
            if($edit > 0)
            {
                //load model
                $userModel = new UserModel();
		//--Update--
                if($firstName)
            	{
                    $userModel->update(array('first_Name' => $firstName),'userID = '.$edit);
            	}
                if($lastName)
            	{
                    $userModel->update(array('last_Name' => $lastName),'userID = '.$edit);
            	}
                if($email)
            	{
                    $userModel->update(array('email' => $email),'userID = '.$edit);
            	}
                if($job)
            	{
                    $userModel->update(array('job' => $job),'userID = '.$edit);
            	}
                if($adresse)
            	{
                    $userModel->update(array('adresse' => $adresse),'userID = '.$edit);
            	}
		//goes back to the details
                $this->_redirect('/master/showfriend?id='.$edit);
            }
            else
            {
	//-----SAVE-----
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
                        //error message
                        $this->view->error = $this->_translate->_( 'Es ist ein Fehler beim Speicher aufgetretten');
                        break;
                    }
        
                    if ($_POST['topicID'])	//if topicID is passed
                    {
                        //load master session
                        $masterNamespace = new Zend_Session_Namespace('master');
                        //save everything in mastersession
                        $masterNamespace->currentTopic = $_POST['topicID'];
                        $masterNamespace->email  = $email;
                        $masterNamespace->userID = $userID;
                        $this->_redirect( '/master/send');  
                    }
                    else
                    {
                        $this->_redirect( '/master/friend');
                    }
                }
                //error message
                $this->view->error = $this->_translate->_( 'Sie haben vergessen eine E-Mail-Adresse anzugeben.');
            }
        }
        else
        {
            $this->_redirect('/master');	//goes to master mainpage
        }
    }    
    
    /** This function handels the HTTP-Request to get the content of a page.
      * @param $url URL of the page
      * @author Christoph Beger
      */
    public function httpRequest( $url)
    {
        /* get hostname and check if plugin is available */
        $urlArray = parse_url( $url);
            
        /* ----- Please insert new plugins here ----- */
        switch ($urlArray['host'])
        {
            case 'de.wikipedia.org':    $plugin = new Plugin_Authentication_WikipediaDe();
                                        $response = $plugin->getResponse( $url, $this->config['wikipedia']);
                                        break;
                                            
            case 'en.wikipedia.org':    $plugin = new Plugin_Authentication_WikipediaEn();
                                        $response = $plugin->getResponse( $url, $this->config['wikipedia']);
                                        break;
                                           
            case 't3n.de':              $plugin = new Plugin_Authentication_T3nDE();
                                        $response = $plugin->getResponse( $url, $this->config['t3n']);
                                        break;
                                           
            default:                    $client = new Zend_Http_Client( $url);
                                        $response = $client->request();
        }
         
        $body = $response->getBody();
        $body = preg_replace('/<a[^>]+>/i', '', $body); //removes <a> tags
        $body = preg_replace('/<form[^>]+>/i', '', $body); //removes <form> tags
        $body = preg_replace('/<iframe[^>]+>/i', '', $body); //removes <iframe> tags
        $body = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $body); //removes <script> tags
            
        return $body;
    }
	
    /** This function is looking for a word
     * @author Enrico Kleemann
     */
    public function searchAction()
    {
        if ( empty( $_POST['search']))
        {
            $this->_redirect( 'master/index');
        }
        //load models
        $topicModel = new Topicmodel();
        $userModel  = new UserModel();
        //search
        $resultFriend = $userModel->getSearchResult($_POST['search']);
        $tempResultTopic = $topicModel->getSearchResult($_POST['search']);
        if(count($tempResultTopic)!= NULL)
        {
            $i = 0;
            foreach( $tempResultTopic as $b)
            {
                $resultTopic[$i]['topicID'] = $b['topicID'];
                $resultTopic[$i]['topicName'] = $b['topicName'];
                $version = $topicModel->getMaxTopicVersion( $b['topicID']);
                $resultTopic[$i]['version'] = $version;
                $i++;
            }
        }
        else
        {
            $resultTopic = NULL;
        }
        //pass result
        $this->view->resultFriend = $resultFriend;
        $this->view->resultTopic = $resultTopic;
	}
    
    /** This function deletes a comment by commentID
      * @author Christoph Beger

      */
    public function deletecommentAction()
    {
        /* no commentID got transmitted */
        if ( (!isset( $_POST['commentID'])) || (!isset( $_POST['topicID'])) || (!isset( $_POST['topicVersion'])))
        {
            $this->_redirect( 'master');
        }
        
        $commentID = $_POST['commentID'];
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        
        $commentModel = new CommentModel();
        
        $commentModel->deleteComment( $commentID);
        
        $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
    
    }
}
?>
