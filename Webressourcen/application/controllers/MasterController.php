<?php

class MasterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
        // action body
    }

    public function importAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
        //session_start(); .............
        if ( isset($_GET['error'])) 
        {
            switch ($_GET['error'])
            {
                case 1: $this->view->errorMsg = 'Themen-Name bereits vergeben!'; 
                        break;
                
                case 2: $this->view->errorMsg = 'Bitte alle Felder f�llen!';
                        break;
                default: 
            }
        }
        $topicForm = new Application_Form_CreateTopic();
		$this->view->topicForm = $topicForm;
    }

    public function validateAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
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
            
            $topicAdditiveModel = new topicAdditiveModel();
            $topicModel = new topicModel();
            
            /* begin of the transaction */
            $topicAdditiveModel->getAdapter()->beginTransaction();
            try
            {
                /* insert new topicName into table topicName */
                $topicModel->insert( array( 'topicName' => $topicName));
                
                /* get auto-created topicID and insert topicData + topicID in table topic */
                $topicIDRow = $topicModel->fetchRow( $topicModel->select()->where( 'topicName = ?' , $topicName));
                $topicID = $topicIDRow['topicID'];
                $topicAdditiveModel->insert( array( 'topicID' => $topicID, 'topicContent' => $topicContent, 'topicSource' => $topicSource));
 
                /* commit transaction */
                $query = $topicAdditiveModel->getAdapter()->commit();
            }
            catch(Exception $e) //transaction failed, rollback
            {
                $topicAdditiveModel->getAdapter()->rollBack();
                $this->_redirect( 'master/import?error=1');
            }
            
            $this->_redirect( 'master/import');
		}
		else $this->_redirect('master/import?error=2');
    }

    public function showfriendAction()
    {
        // action body
    }

    public function showtopicsAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
		$topicAdditiveModel = new topicAdditiveModel();
        $topicModel = new topicModel();
        
        /* get all topics as rowSet and sent it to the view */
		$allTopicsRowSet = $topicModel->fetchAll();
		$this->view->allTopicsRowSet = $allTopicsRowSet;
        
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
            
            /* use the topicID to get row with the content of the selected topic */
            $topicID = $_GET['id'];
            $topicRow = $topicAdditiveModel->fetchRow( $topicAdditiveModel->select()->where( 'topicID = ?', $topicID)->where( 'topicVersion = ?', $selectedTopicVersion));
            
            /* get the topicName by topicID */
            $topicNameRow = $topicModel->fetchRow( $topicModel->select()->where( 'topicID = ?', $topicID));
            
            /* select all versionnumbers and send them to the view as rowSet */
            $versionNumbersRow = $topicAdditiveModel->fetchAll( $topicAdditiveModel->select()->where( 'topicID = ?', $topicID));
            $this->view->versionNumbersRow = $versionNumbersRow;
            
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
                $this->view->topicName = $topicNameRow['topicName'];
                $topicContent = 'Version: ' . $selectedTopicVersion . '<p>Inhalt:<br>' . $topicContent . '<p>Quelle: ' . $topicSource;
                $topicContent .= '<p><a href = "http://localhost/Webressourcen/public/master/edittopic?id=' . $_GET['id'] . '&ver=' . $selectedTopicVersion . '">';
                $topicContent .= 'Inhalt �berarbeiten</a>';
                $this->view->topicContent = $topicContent;
                
                //-----show comments-------------
                
                $comment = new CommentModel;
                $userTopic = new UserTopicModel;
                
                /* get all comments for the selected topic, as rowSet */
                $commentRowSet = $comment->fetchAll( 'topicID = "' . $topicID . '" AND topicVersion = "' . $selectedTopicVersion.'"');
                
                if ( !empty( $commentRowSet))
                {
                    /* insert a new column userName in the commentRowSet */
                    foreach( $commentRowSet as $commentRow)
                    {
                        $userRow = $userTopic->fetchRow( 'userID = "' . $commentRow['userID'] . '" AND topicID = "' . $commentRow['topicID'] . '"');
                        $userCommentRow['userName'] = $userRow['userName'];
                        $userCommentRow['commentDate'] = $commentRow['commentDate'];
                        $userCommentRow['commentText'] = $commentRow['commentText'];
                        $userCommentRowSet[] = $userCommentRow;
                    }
                    
                    /* send the rowSet with user-comments to the view */
                    $this->view->userCommentRowSet = $userCommentRowSet;
                }
                
                
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

    public function inviteAction()
    {
        // action body
    }

    public function edittopicAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
        
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
            
            $topicNameRow = $topicModel->fetchRow( 'topicID =' . $topicID);    //get topicName if available
            
            /* topics with spezified topicID are available */
            if ( !empty( $topicNameRow)) 
            {
                if ( $_GET['error'] == 1)
                {
                    $this->view->msg = 'Bitte alle Felder f�llen!';
                }
                $this->view->topicName = $topicNameRow['topicName'];
                
                $topicRow = $topicAdditiveModel-> fetchRow( $topicAdditiveModel->select()->where( 'topicID = ?', $topicID)->where( 'topicVersion = ?', $topicVersion));
                /* in link spezified version is available for this topic */
                if ( !empty( $topicRow))
                {
                    $this->view->topicContent = str_replace("<br />", "", $topicRow['topicContent']);
                    $this->view->topicSource = $topicRow['topicSource'];
                }
                else $this->view->msg = 'Angegebende Version existiert f�r dieses Thema nicht!';
            }
            else $this->view->msg = 'Kein Thema zum bearbeiten vorhanden!';
        }
        else $this->view->msg = 'Keine Themen-ID angegeben!';
    }

    public function validateeditAction()
    {
        Zend_Layout::getMvcInstance()->setLayout('master');
        
        $topicID = $_POST['topicID'];
        $topicVersion = $_POST['topicVersion'];
        $topicContent = $_POST['topicContent'];
        $topicSource = $_POST['topicSource'];
        
        if ( (!empty( $topicID)) && (!empty( $topicVersion)) && (!empty( $topicContent)) && (!empty( $topicSource)))
        {
            $topicAdditiveModel = new topicAdditiveModel();
            $maxVersion = $topicAdditiveModel->fetchRow( $topicAdditiveModel->select()  ->from( $topicAdditiveModel, array(new Zend_Db_Expr('max(topicVersion) as maxVersion')))
                                                                        ->where( 'topicID = ?', $topicID));
            $maxVersion = $maxVersion['maxVersion'];
            
            $topicAdditiveModel->insert( array( 'topicID' => $topicID, 'topicVersion' => $maxVersion+1, 'topicContent' => $topicContent, 'topicSource' => $topicSource));
            $this->view->msg = 'Neue Version wurde erstellt!';
        }
        else $this->_redirect( 'edittopic?id=' . $topicID . '&ver=' . $topicVersion . '&error=1');
    }


}



























