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
		get the UserName about the UserID and TopicID
		@param $userTopic, "userID","topicID"
		@return userName
	*/
	public function getUserName($userTopic)
	{
		$rowset = $this->fetchALl('userID = "'.$userTopic["userID"].'" AND topicID = "'.$userTopic["topicID"].'"');
		$row = $rowset->current();
		return $row->userName;
	}
}
?>