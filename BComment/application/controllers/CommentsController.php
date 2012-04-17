<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * includes the main features of the Website
 */
class CommentsController extends Zend_Controller_Action
{
    /**
     * saves a comment in the data base
     * @param array<string> $data all informations about the comment
     * @param string $newDate current date
     * @param string $comments commentModel
     * @param string $commentID the ID of the comment
     * @param string $url URL to show.phtml of the particular topic
     * @author Peter Kornowski
     */
    private function saveData($data)
    {
        $newDate = date('Y-m-d H:i:s');
        $data['commentDate'] = $newDate;
        // --- saving part ---
        $comments = new commentModel();
        $commentID = $comments->insert($data);
        // --- routing after storage ---
        $url = '/comments/show/id/' . $data['topicID'];
        $this->_redirect($url);
    }

    /**
     * analyzed the information from the create-form
     * needs the function {@link saveData(array<string>)} to work properly
     * @param array<string> $data all informations about the comment
     * @author Peter Kornowski
     */
    public function validateAction()
    {
        if ($this->getRequest()->isPost())			//avoids direct access without having information pass
        {
            $data = array();
            // --- read informations from create-form ---
            $data['topicID'] = $_POST['topicID'];
            $data['userName'] = $_POST['userName'];
            $data['commentText'] = $_POST['commentText'];
            // --- check all information ---
            if (strlen($data['userName']) == 0)			//checks userName
            {
                $data['userName' ] = 'Anonymus';
            }
       
            if (strlen($data['commentText']) == 0)		//checks commentText
            {
                // if no text route to show
                $url = '/comments/show/id/'. $data['topicID'];
                $this->_redirect($url);
            }
            else
            {
                // else save comment
                $this->saveData($data);
            }
        }
        else
        {
            $this->_redirect('/');				//goes to mainpage
        }
    }

    /**
     * This function changes the title of the header and gives the view information about the topics
     * @param string $topics all information in the table 'topic' of 'comments'
     * @author Peter Kornowski
     */
    public function indexAction()
    {
        $this->view->title = ' - Themenübersicht';

        $topics = new TopicModel();			//loads table
        $this->view->topics = $topics->fetchAll();	//sends table to view
    }

    /**
     * This function changes the title of the header and gives the view information from the show/cshow
     * to create a new comment
     * @author Peter Kornowski
     */
    public function createAction()
    {
        if ($this->getRequest()->isPost())			//avoids direct access without having an ID pass
        {
            $this->view->title = ' - Thema';

            $this->view->topicID = $_POST["topicID"];		//sends topicID   to view
            $this->view->topicName = $_POST["topicName"];	//sends topicName to view
        }
        else
        {
            $this->_redirect('/');				//goes to mainpage
        }
    }

    /**
     * This function changes the title of the header and gives the view information from data base
     * @param string $id topicID
     * @param string $topics   all information in the table 'topic'    of 'comments'
     * @param string $comments all information in the table 'comments' of 'comments'
     * @author Peter Kornowski
     */
    public function showAction()
    {
        $this->view->title = ' - Thema';
       
        $id = (int)$this->getRequest()->getParam('id'); 		//topicID from the URL
       
        $topics = new topicModel();					//loads table 'topics'
        $comments = new commentModel();					//loads table 'comment'
        
        if($topics->fetchRow('topicID='.$id) == 0)			//avoids access to a topic whitch doesn't exist
        {
            $this->_redirect('/');					//goes to mainpage
        }
        else
        {
            $this->view->topics = $topics->fetchRow('topicID='.$id);	//sends one topic with topicID = $id
            $this->view->comments = $comments->fetchAll(
	        $comments->select()					//sends comments
                         ->where('topicID='.$id)			//with topicID = $id
                         ->order('commentDate DESC')			//sorted in descending order by date
                         ->limit(2, 0)					//limited to two comments
        );
        }
    }

    /**
     * This function changes the title of the header and gives the view information from data base
     * @param string $id topicID
     * @param string $topics   all information in the table 'topic'    of 'comments'
     * @param string $comments all information in the table 'comments' of 'comments'
     * @author Peter Kornowski
     */
    public function cshowAction()
    {
        $this->view->title = ' - Kommentare';
       
        $id = (int)$this->getRequest()->getParam('id');			//topicID from the URL
       
        $topics = new topicModel();					//loads table 'topics'
        $comments = new commentModel();					//loads table 'comment'
       
        if($topics->fetchRow('topicID='.$id) == 0)			//avoids access to a topic whitch doesn't exist
        {
            $this->_redirect('/');					//goes to mainpage
        }
        else
        {
            $this->view->topics = $topics->fetchRow('topicID='.$id);	//sends one topic    with topicID = $id
            $this->view->comments = $comments->fetchAll('topicID='.$id);//sends one comments with topicID = $id
        }
    }
}
?>









