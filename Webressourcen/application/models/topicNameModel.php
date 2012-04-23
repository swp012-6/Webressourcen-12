<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * loades the database table topicName
 */
class topicNameModel extends Zend_Db_Table_Abstract
{
    protected $_name = 'topicname';
	protected $_primary = 'topicID';
}
?>