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

		//---- view ---------
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
		$view->headLink()->appendStylesheet('http://localhost/BComment/public/_files/css/styles.css');

		//---- data base ----
		require_once 'Zend/Db.php';
		require_once 'Zend/Debug.php';
	       
		require_once 'Zend/Db/Table.php';
		Zend_Db_Table::setDefaultAdapter($db);
	       
		require_once '../application/models/TopicModel.php';
		require_once '../application/models/CommentModel.php';
	}

}
?>
