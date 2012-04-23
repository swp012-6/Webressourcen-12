<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * loades the database table topic
 */
class TopicModel extends Zend_Db_Table_Abstract
{
    protected $_name = 'topic';
	
	/**
		search the Name from the Topic with the topicID
		@param $topicID is the primer-key
		@return is the Name from the topic
	*/
	public function getTopicName($topicID)
	{
		$rowset = $this->fetchALl('topicID = "'.$topicID.'"');
		$row = $rowset->current();
		return $row->topicName;
	}
}
?>