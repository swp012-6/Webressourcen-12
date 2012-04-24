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
    
    /** returns array with topicIDs and topicNames to list all available topics ................hier muss noch die userID rein,bleibt aus testzwecken erstmal weg
      * @param $userID ID of the logged in user
      * @return 2-dimensional array with topicID and topicName
      */
    public function getTopicList()
    {
        $allTopicsRowSet = $this->fetchAll( $this->select()->from( $this, 'topicID'));
        
        foreach ( $allTopicsRowSet as $allTopicsRow)
        {
            $topicList[] = array('topicID' => $allTopicsRow['topicID'], 'topicName' => $this->getTopicName( $allTopicsRow['topicID']));
        }
        return $topicList;
    }
    
    /** creates a new topic with an unique topicID
      * @param $topicName name of the new topic
      * @param $topicContent content of the new topic
      * @param $topicSource source
      * @return returns 0 if transaction failed, else 1
      */
    public function createTopic( $topicName, $topicContent, $topicSource) 
    {
        $topicAdditiveModel = new TopicAdditiveModel();
        
        /* begin of the transaction */
        $topicAdditiveModel->getAdapter()->beginTransaction();
        try
        {
            /* insert new topicName into table topicName */
            $this->insert( array( 'topicName' => $topicName));
 
            /* get auto-created topicID and insert topicData + topicID in table topic */
            $topicIDRow = $this->fetchRow( $this->select()->where( 'topicName = ?' , $topicName));
            $topicID = $topicIDRow['topicID'];
            $topicAdditiveModel->insert( array( 'topicID' => $topicID, 'topicContent' => $topicContent, 'topicSource' => $topicSource));
 
            /* commit transaction */
            $query = $topicAdditiveModel->getAdapter()->commit();
        }
        catch(Exception $e) //transaction failed, rollback
        {
            $topicAdditiveModel->getAdapter()->rollBack();
            $return;
        }
        return 1;
    }
}
?>