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
		this function returns the name of the topic declared by topicID
		@param $topicID is the primer-key
		@return is the Name from the topic
	*/
	public function getTopicName($topicID)
	{
		$rowset = $this->fetchALl('topicID = "'.$topicID.'"');
		$row = $rowset->current();
		return $row->topicName;
	}
    
    
    /** returns all versionnumbers for the specified topicID
      * @param $topicID ID of the specified topic
      * @return array with all versionnumbers
      */
    public function getVersionNumbers( $topicID)
    {
        $topicAdditiveModel = new TopicAdditiveModel();
        $topicVersionRowSet = $topicAdditiveModel->fetchAll( $topicAdditiveModel->select()->where( 'topicID = ?', $topicID));
        
        foreach( $topicVersionRowSet as $topicVersionRow)
        {
            $topicVersionArray[] = $topicVersionRow['topicVersion'];
        }
        return $topicVersionArray;
    }
    
    /** returns the content of a topic-version ...............................evtl sollte hier die userID mit gefordert werden, wegen Zugriff!
      * @param $topicVersion version of the topic
      * @param $topicID ID of the topic
      * @return row which includes topicContent and topicSource
      */
    public function getTopic( $topicID, $topicVersion)
    {
        $topicAdditiveModel = new TopicAdditiveModel();
        return $topicAdditiveModel->fetchRow( $topicAdditiveModel->select()->where( 'topicID = ?', $topicID)->where( 'topicVersion = ?', $topicVersion));
    }
}
?>