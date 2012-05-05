﻿<?php
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
	 * @return string $userName name of the user
	 */
	public function getUserName($userTopic)
	{
		$rowset = $this->fetchAll('userID = "'.$userTopic["userID"].'" AND topicID = "'.$userTopic["topicID"].'"');
		$row = $rowset->current();
        
        if ( empty( $row))
        {
            return 'gelöschter Nutzer';
        }
        
		return $row->userName;
	}

	/**
	 * adds userTopic with userID, topicID and hash
	 *
	 * @param array $userTopic "userID","topicID","hash"
	 */
	public function addUserTopic($userTopic)
	{
		try	// try to save $userTopic
		{
			$this->insert($userTopic);
		}
		catch (Exception $e)
		{
			// get old entry
			$row = $this->fetchRow('userID = "'.$userTopic["userID"].'"
						AND topicID = "'.$userTopic["topicID"].'"');
			// delete old entry
			$row->delete();
			// save again
			$this->insert($userTopic);
		}
	}

	/**
	 * gets topicIDs which are connected with $userID
	 *
	 * @param int $userID ID of desired user
         * @return array $topics topicIDs and usernames
	 */
	public function getTopics($userID)
	{
		$topics = $this->fetchAll($this->select()
			       ->where('userID = ?',$userID));
		return $topics;
	}

	/**
	 * gets userIDs which are connected with $topicID
	 *

	 * @param int $topicID ID of desired topic
         * @return array $users usersIDs and usernames
	 */
	public function getUsers($topicID)
	{
		$users = $this->fetchAll($this->select()
			       ->where('topicID = ?',$topicID));
		return $users;
	}

	/**
	 * deletes UserName
	 *
	 * @param int $userID  userID of the userTopic
         * @param int $topicID topicID of the userTopic
	 */
	public function delUserTopic($userID, $topicID)
	{
		// get userTopic
		$row = $this->fetchRow('userID = "'.$userID.'"
					AND topicID = "'.$topicID.'"');
		// delete userTopic
		$row->delete();
		
	}
}
?>
