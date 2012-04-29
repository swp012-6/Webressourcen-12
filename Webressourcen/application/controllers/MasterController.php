<?php

class MasterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        Zend_Layout::getMvcInstance()->setLayout('master');
    }

    public function indexAction()
    {
        // action body
    }

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

    public function validateAction()
    {
        //session_start(); ............
		
        /* save content of posted variables */
        $topicName = $_POST['topicName'];
		$contentType = $_POST['contentType'];
		$topicContent = nl2br($_POST['topicContent']);
		$topicSource = $_POST['topicSource'];
		
        /* if the form-textfields where filled */
		if ( (!empty( $topicName)) && (!empty( $topicContent)))
		{	
            /* HTTP-Request to get body of spezified page ................*/
			if ($contentType == 'link')
			{
				$topicSource = $topicContent;
                $client = new Zend_Http_Client($topicContent);
                $response = $client->request();
                $body = $response->getBody();
                //list( $firstPart, $bodyTextArea) = explode('<body>', $body);
                //list( $bodyTextArea, $secondPart) = explode('</body>', $body);
                $topicContent = strip_tags($body, '<img><p><br><ul><il>');
                //$topicContent = $bodyTextArea;
                //$topicContent = $body;
            }
            
            $topicModel = new topicModel();
            $result = $topicModel->createTopic( $topicName, $topicContent, $topicSource);
            
            if ( $result)
            {
                $this->_redirect( 'master/import');
            }
            else $this->_redirect( 'master/import?error=1');
		}
		else $this->_redirect('master/import?error=2');
    }

    public function showfriendAction()
    {
        // action body
    }

    public function showtopicsAction()
    {
        $topicModel = new topicModel();
        
        switch ( $_GET['error'])
        {
            case 1: echo 'Bitte füllen Sie das Feld Kommentar!';
            // .........................
        }
        
        
        /* get all topics as rowSet and sent it to the view */
		$topicList = $topicModel->getTopicList();
		$this->view->topicList = $topicList;
        
        /* topic was already selectet to show */
        if ( isset( $_GET['id']))
        {
            /* set version to standard if not available */
            if (!isset( $_GET['ver']))
            {
                $selectedTopicVersion = 1;
            }
            else // use the postet version number 
            $selectedTopicVersion = $_GET['ver'];
            
            /* sent the version number to the view */
            $this->view->selectedTopicVersion = $selectedTopicVersion;
            
            /* use the topicID and selectedTopicVersion to get row with the content of the selected topic */
            $topicID = $_GET['id'];
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
                $topicContent = $topicRow['topicContent'];
                
                /* set the topicSource if empty */
                if ( empty( $topicSource))
                {
                    $topicSource = 'nicht angegeben/bekannt';
                }
                
                /* send topicName and content (includes the topicVersion, topicContent and topicSOurce) to the view */
                $this->view->topicName = $topicName;
                $topicContent = 'Version: ' . $selectedTopicVersion . '<p>Inhalt:<br>' . $topicContent . '<p>Quelle: ' . $topicSource;
                $topicContent .= '<p><a href = "http://localhost/Webressourcen/public/master/edittopic?id=' . $_GET['id'] . '&ver=' . $selectedTopicVersion . '">';
                $topicContent .= 'Inhalt überarbeiten</a>';
                $this->view->topicContent = $topicContent;
                
                
                
                
                //-----------------show comments-----------------------
                $comment = new CommentModel;
                
                /* get all comments of the selected topic, as rowSet */
                $commentRowSet = $comment->getComment( array(   'topicID' => $topicID,
                                                                'topicVersion' => $selectedTopicVersion,    
                                                                'orderup' => 0,
                                                                'exp' => $_GET['exp']));
                
                if ( !empty( $commentRowSet))
                {
                    /* configure the variables exp and expButtonValue to manage the expansion-button */
                    if ( $_GET['exp']) 
                    {
                        $this->view->exp = 0;
                        $this->view->expButtonValue = 'kürzen';
                    }
                    else 
                    {
                        $this->view->exp = 1;
                        $this->view->expButtonValue = 'erweitern';
                    }
                    
                    
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
        // action body
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
        $userModel = new userModel();
	$this->view->friends = $userModel->fetchAll();
    }

    /**
     * This function sends emails to the friends
     * 
     * @param string $_POST[$i] particular emailaddress of the user whit the userID $i
     * @author Peter Kornowski
     */
    public function sendAction()
    {
        if ($this->getRequest()->isPost())	//avoids direct access without having information passed
        {
            $config = array('auth' => 'login',	//login mail-server
                'username' => 'swp12-6@gmx.de',
                'password' => 'BKLRswp12');
 
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmx.net', $config);

            $mail = new Zend_Mail();		//create mail
            $mail->setBodyText('Einladung zu ');
            $mail->setFrom('swp12-6@gmx.de', 'Webressourcen');
            for($i=1; $i<=10; $i++)		//send to all 
            {
                if(isset($_POST[$i]))		//who are checked
                {
                    $mail->addTo($_POST[$i]);
                }
            }
            $mail->setSubject('Einladung');
            $mail->send($transport);
        }
        else
        {
            $this->_redirect('/master');	//goes to mainpage
        }
    }

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
            $topicAdditiveModel = new topicAdditiveModel();
            
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

    public function validateeditAction()
    {
        $topicModel = new TopicModel();
        
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        $topicContent = $_POST['topicContent'];
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

    public function validatecommentAction()
    {
        /* save posts in vairables */
        $commentText = $_POST['commentText'];
        $userID = $_POST['userID'];
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        
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
            $commentModel->insert( array( 'commentText' => $commentText, 'userID' => $userID, 'topicID' => $topicID, 'topicVersion' => $topicVersion));
        }
        catch (Exception $e)
        {
            //.........................................
        }
        
        $this->_redirect( 'master/showtopics?id=' . $topicID . '&ver=' . $topicVersion);
    }


}





























