<?php/** * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW} * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL) *//** * loades the database table comment */class CommentModel extends Zend_Db_Table_Abstract{    protected $_name = 'comment';			/**		get the Commentar from a version of the topic		@param $option are a array. option = array("topicID","topicVersion","orderup")		@return $rowset are the "commentText" with the "userName" an "commentDate"	*/	public function getComment($option)	{		//userTopic Database init		$dbuserTopic = new UserTopicModel();				//select the order		if( $option["orderup"] == true)		{			$sort = 'commentDate ASC';		}		else		{			$sort = 'commentDate DESC';		}				//push the data		$rowset = $this->fetchAll('topicID = "'.$option["topicID"].'" AND topicVersion = "'.$option["topicVersion"].'"',$sort);		$rowset2;		//select the data and add the userName		foreach($rowset as $row)		{						$userTopic = array("userID" => $row['userID'],"topicID" => $row['topicID']);			$row2["userName"] = $dbuserTopic->getUserName($userTopic);			$row2["commentDate"] = $row->commentDate;			$row2["commentText"] = $row->commentText;			$row2["commentID"] = $row->commentID;					$rowset2[] = $row2;		}				//return the result		return $rowset2;	}		public function deleteComment($commentID)	{		$adapter = $this->getAdapter();		$sure = $adapter->quote($commentID);		$where = "commentID = $sure";		if( empty($where))		{			throw new Exception('empty WHERE-clause transfer');					}		$this->delete($where);	}	}?>