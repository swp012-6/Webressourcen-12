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
     * @author Peter Kornowski
     */
    public function indexAction()
    {
        $this->view->title = ' - Hauptseite';
    }

    /**
     * This function changes the title of the header and calls up the view.
     * @param string $titel - Additive for the title in the header of the Main.phtml
     * @author Peter Kornowski
     */
    public function preloginAction()
    {
        $this->view->title = ' - Administrator';
    }

    public function loginAction()
    {
        $this->view->title = ' - Administrator';
    }

    public function logoutAction()
    {
        // action body
    }

    public function updatefromAction()
    {
        $this->view->title = ' - Administrator';
    }

    public function updateAction()
    {
        // action body
    }


}













