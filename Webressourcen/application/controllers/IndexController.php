<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * gets the main page
 */
class IndexController extends Zend_Controller_Action
{
    protected $_translate;
    
    public function init()
    {
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

    /**
     * This function changes the title of the header and calls up the view.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @param string $masterOnline - boolean: 1 -> Master is logged in; 0 -> Master isn't logged in
     * @author Peter Kornowski
     */
    public function indexAction()
    {
        $this->view->title = ' - ' . $this->_translate->_( 'Hauptseite');
        $masterNamespace = new Zend_Session_Namespace('master');
        $this->view->masterOnline = $masterNamespace->masterOnline;
    }

    /**
     * This function changes the title of the header and calls up the login formular.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @author Peter Kornowski
     */
    public function preloginAction()
    {
        $this->view->title = ' - Administrator';
	$masterNamespace = new Zend_Session_Namespace('master');
        $this->view->masterOnline = $masterNamespace->masterOnline;
    }

    /**
     * This function changes the title of the header and leads through the login.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @param string $error - error message
     * @author Peter Kornowski
     */
    public function loginAction()
    {
        $this->view->title = ' - Administrator';
	$masterNamespace = new Zend_Session_Namespace('master');

        if ($this->getRequest()->isPost())		//avoids direct access without having information pass
        {
            //gets user information from prelogin
            $usern = $this->_request->getPost('usern');
            $password = $this->_request->getPost('password');
               
            if (empty($usern) || empty($password))
            {
                //error if textfield is empty
                $this->view->error = $this->_translate->_( 'Login fehlgeschlagen. Bitte füllen Sie alle Felder aus.');
            }
            else
            {      
                //loads master information
                $master = new masterModel();
                $row = $master->fetchRow('userID = 0');

                // checks username and password?
                if ($row->userName == $usern && $row->password == md5($password))
                {
                    $masterNamespace->masterOnline = 1;
                    $this->_redirect('/'); 
                }
                else
                {
                    //error if login didn't work
                    $this->view->error = $this->_translate->_( 'Login fehlgeschlagen. Haben Sie ihren Account bestätigt?');
                }
            }
        }
        else  
        {
            $this->_redirect('/');
        }
    }

    /**
     * This function changes the title of the header and leads through the logout.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @author Peter Kornowski
     */
    public function logoutAction()
    {
	$masterNamespace = new Zend_Session_Namespace('master');
        $masterNamespace->masterOnline = 0;
        $this->_redirect('/');
    }

    /**
     * This function changes the title of the header and calls up the update formular.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @author Peter Kornowski
     */
    public function updateformAction()
    {
        $masterNamespace = new Zend_Session_Namespace('master');
        $this->view->masterOnline = $masterNamespace->masterOnline;

        if ($masterNamespace->masterOnline == 1)
        {
            $this->view->title = ' - Administrator';
        }
        else  
        {
            $this->_redirect('/');
        }
    }

    /**
     * This function changes the title of the header and leads through the update.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @param string $error - error message
     * @author Peter Kornowski
     */
    public function updateAction()
    {
	$masterNamespace = new Zend_Session_Namespace('master');
        $this->view->masterOnline = $masterNamespace->masterOnline;
        if ($this->getRequest()->isPost())		//avoids direct access without having information pass
        {
            //gets old user information from updateform
            $usern = $this->_request->getPost('usern');
            $password = $this->_request->getPost('password');

            //loads master information
            $master = new masterModel();
            $row = $master->fetchRow('userID = 0');

            // checks username and password?
            if ($row->userName == $usern && $row->password == md5($password))
            {
                //gets new username from updateform
                $newPassword1 = $this->_request->getPost('newPassword1');
                $newPassword2 = $this->_request->getPost('newPassword2');

                if ($newPassword1 == $newPassword2)
                {
                    //gets new username from updateform
                    $newUsern = $this->_request->getPost('newUsern');
    
                    if (!empty($newUsern))		//update username
                    {
                        $data = array('userName' => $newUsern);
    
                        $n = $master->update($data, 'userID = 0');

                        //change userName in UserTopic
                        $userTopicModel = new UserTopicModel();
                        $m = $userTopicModel->update($data, 'userID = 0');
                    }
                    if(!empty($newPassword1))		//update password
                    {
                        $data = array('password' => md5($newPassword1));
    
                        $n = $master->update($data, 'userID = 0');
                    }
                    $this->_redirect('/');
                }
                else
                {
                    //error if new passwort check didn't work
                    $this->view->error = $this->_translate->_( 'Update fehlgeschlagen. Haben Sie Ihr neues Passwort nicht bestätigt?');
                }
            }
            else
            {
                //error if login didn't work
                $this->view->error = $this->_translate->_( 'Update fehlgeschlagen. Haben Sie Ihren Account nicht bestätigt?');
            }
        }
        else  
        {
            $this->_redirect('/');
        }
    }


}
?>
