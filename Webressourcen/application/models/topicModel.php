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
	public function getTopicName( $topicID)
	{
		$topicNameRow = $this->fetchRow('topicID = "'.$topicID.'"');
		return $topicNameRow['topicName'];
	}
    
    
    /** returns all versionnumbers for the specified topicID
      * @param $option "topicID" ID of the specified topic, "number" number VersionsID, "page" pageoperator
      * @return array with all versionnumbers
      */
    public function getVersionNumbers( $option)
    {
        $topicAdditiveModel = new TopicAdditiveModel();
		$where =  'topicID = "'.$option['topicID'].'"';
		$number = $option["number"]; 									// number of Comments
		$offset = ($option["number"]* $option["page"]); 				//startpoint when return Comment
		$sort = 'topicVersion DESC';
        $topicVersionRowSet = $topicAdditiveModel->fetchAll( $where,$sort,$number,$offset);
        
        foreach( $topicVersionRowSet as $topicVersionRow)
        {
            $topicVersionArray[] = $topicVersionRow['topicVersion'];
        }
        return $topicVersionArray;
    }
	
	/**
		return number of Version
		@param $topicID ID of the specified topic
		@return a int with the number if Version
	*/
	public function getNumberVersion($topicID)
	{
		$topicAdditiveModel = new TopicAdditiveModel();
        $topicVersionRowSet = $topicAdditiveModel->fetchAll();
		return count($topicVersionRowSet);
	}
    /**
		give the number of one Version in the Database
		@param $option: "topicID", "topicVersion"
		@return the number from this Version
	*/
	public function getTheNumberFromVersion($option)
	{
		$topicAdditiveModel = new TopicAdditiveModel();
		
		$where =  'topicID = "'.$option['topicID'].'" AND topicVersion <= "'.$option['topicVersion'].'"';
		$sort = 'topicVersion DESC';
        $topicVersionRowSet = $topicAdditiveModel->fetchAll($where,$sort);
		return count($topicVersionRowSet);
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
        $topicList = $this->fetchAll( $this->select() ->from( $this, array( 'topicID', 'topicName')));
        
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
            return null;
        }
        return $topicID;
    }
    
    /** This function creates a new version to an existing topic.
      * The new versionnumber is the increment of the currently highest.
      * @param $topicID ID of the existing topic
      * @param $topicContent content of the new version
      * @param $topicSource new version's source
      * @return 1 if success, null if failed
      */
    public function createNewTopicVersion( $topicID, $topicContent, $topicSource)
    {
        $topicAdditiveModel = new TopicAdditiveModel();
        try
        {
            $maxVersion = $this->getMaxTopicVersion( $topicID);
            $topicAdditiveModel->insert( array( 'topicID' => $topicID, 'topicVersion' => $maxVersion+1, 'topicContent' => $topicContent, 'topicSource' => $topicSource));
        }
        catch ( Exception $e)
        {
            return null;
        }
        return 1;
    }
    
    /** This function returns the highest value of topicVersion for a given topicID.
      * @param topicID given topicID
      * @return highest value of topicVersion
      */
    public function getMaxTopicVersion( $topicID)
    {
        $topicAdditiveModel = new TopicAdditiveModel();
        
        $maxVersion = $topicAdditiveModel->fetchRow( $topicAdditiveModel->select()  ->from( $topicAdditiveModel, array(new Zend_Db_Expr('max(topicVersion) as maxVersion')))
                                                                                    ->where( 'topicID = ?', $topicID));
        return $maxVersion['maxVersion'];
    }
    
    /** 
     * deletes topic, topicAdditives, comments and userTopics with the given ID
     * @param topicID given topicID
     * @return $success 1 successful, 0 failed
     */
    public function delTopic($topicID)
    {
        //load models
        $topicAdditiveModel = new TopicAdditiveModel();
        $topicModel = new TopicModel();
        $commentModel = new commentModel();
        $userTopicModel = new UserTopicModel();
        //delete topic, topicAdditives, comments and userTopics
        try
        {
            $topicModel->delete( 'topicID = '. $topicID);
            $topicAdditiveModel->delete( 'topicID = '. $topicID);
            $commentModel->delete( 'topicID = '. $topicID);
            $userTopicModel->delete( 'topicID = '. $topicID);
	}
        catch (Exception $e)
        {
            return 0;	//failed
        }
        return 1;	//successful
    }
}
?>
