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

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * This function changes the title of the header and calls up the view.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @param string $masterOnline - boolean: 1 -> Master is logged in; 0 -> Master isn't logged in
     * @author Peter Kornowski
     */
    public function indexAction()
    {
        $this->view->title = ' - Hauptseite';
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
                $this->_redirect('/');
            }
            else
            {      
                //loads master information
                $master = new masterModel();
                $row = $master->fetchRow('userID = 1');

                // checks username and password?
                if ($row->userName == $usern && $row->password == md5($password))
                {
                    $masterNamespace->masterOnline = 1;
                    $this->_redirect('/'); 
                }
                else
                {
                    //error if it didn't work
                    $this->view->error = "Login failed. Have you confirmed your account?";
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
            $row = $master->fetchRow('userID = 1');

            // checks username and password?
            if ($row->userName == $usern && $row->password == md5($password))
            {
                //gets new user information from updateform
                $newUsern = $this->_request->getPost('newUsern');
                $newPassword = $this->_request->getPost('newPassword');

                if (!empty($newUsern))			//update username
                {
                    $data = array('userName' => $newUsern);

                    $n = $master->update($data, 'userID = 1');
                }
                if(!empty($newPassword))		//update password
                {
                    $data = array('password' => md5($newPassword));

                    $n = $master->update($data, 'userID = 1');
                }
                $this->_redirect('/');
            }
            else
            {
                //error if it didn't work
                $this->view->error = "Update failed. Have you confirmed your account?";
            }
        }
        else  
        {
            $this->_redirect('/');
        }
    }


}













