<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * loades the database table user_topic
 */
class UserTopicModel extends Zend_Db_Table_Abstract
{
    protected $_name = 'userTopic';
	
	/**
	 * gets UserName with userID and topicID
	 *
	 * @param array $userTopic "userID","topicID"
	 * @return $userName name of the user
	 */
	public function getUserName($userTopic)
	{
		$rowset = $this->fetchAll('userID = "'.$userTopic["userID"].'" AND topicID = "'.$userTopic["topicID"].'"');
		$row = $rowset->current();
		return $row->userName;
	}

	/**
	 * adds UserName with userID, topicID and hash
	 *
	 * @param array $userTopic "userID","topicID","hash"
	 */
	public function addUserName($userTopic)
	{
		$this->insert($userTopic);
	}
}
?>
