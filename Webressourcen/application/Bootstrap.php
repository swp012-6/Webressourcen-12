<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * gets the layout and the database
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	/**
	 * loads key data for database and layout
	 * @param string $layout the layout
	 * @param string $view the particular view
	 * @param array<string> $params informations about database
	 * @param string $db the database from $params
	 * @author Peter Kornowski
	 */
	 
	function _initViewHelpers()
	{
		
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		//-- is the doctype and there are the text type ----
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		$view->headMeta()->appendName('keywords','Webressourcen');
		

		//-- are the style sheet------
		$view->headLink()->appendStylesheet('http://localhost/Webressourcen/public/_files/css/styles.css');
		//$view->headLink()->appendStylesheet('../public/_files/css/styles.css');

		
		//-- are the title name ----
		$view->headTitle()->setSeparator(' - ');
		$view->headTitle('Webressourcen');
		
		
		//-- Loader ----
		
		//-- include automatically important files
		require_once "Zend/Loader.php";
		Zend_Loader::registerAutoload();
		
		
		//-- set the includepath 
		set_include_path('.' . PATH_SEPARATOR .
						'../library' . PATH_SEPARATOR .
						'../application/models/' . PATH_SEPARATOR .
						get_include_path());
		
		
		//-- database ----

		
		//--include the model
		require_once '../application/models/TopicModel.php';
		require_once '../application/models/CommentModel.php';
		require_once '../application/models/UserTopicModel.php';
		require_once '../application/models/UserModel.php';
		require_once '../application/models/TopicAdditiveModel.php';
		require_once '../application/models/MasterModel.php';
		
		
		//--FrontController ----
		//-- Setup Controller

		$frontController = Zend_Controller_Front::getInstance();
		
		//path to the Controller
		$frontController->setControllerDirectory('../application/controllers');
		
		
		
		
		
	}
 
}

