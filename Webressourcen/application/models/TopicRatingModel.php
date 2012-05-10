<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * loades the database table topicrating
 */
class TopicRatingModel extends Zend_Db_Table_Abstract
{
    protected $_name = 'topicrating';
	
    /**
        create  the rating for a friend 
        @param topicID to identifikation thhe topic
        @param topicVersion to identifikation thhe Version
        @param userID to identifikation thhe friend
    */
    public function createRating($topicID,$topicVersion,$userID)
    {
        
        //test the params of empty
        if(!(empty($topicID)||empty($topicVersion)||empty($userID)))
        {
          
            //test the topicID,topicVersion and userID in the database,if this empty then create the rating
            $where = array("topicID" => $topicID,"topicVersion"=> $topicVersion,"userID" => $userID);
            $rowset = $this->fetchAll($where);
            $row = $rowset->current();
            
            if(NULL == $row['rating'])
            {
                //if the row empty, than create 
                $date = array("topicID" => $topicID,"topicVersion"=> $topicVersion,"userID" => $userID,"rating"=> 1);
                $this->insert($date);
               
            }
        }
    }
    
    /**
        update the rating
        @param topicID to identifikation thhe topic
        @param topicVersion to identifikation thhe Version
        @param userID to identifikation thhe friend
        @param assessment
    */
    public function updateRating($topicID,$topicVersion,$userID,$assessment)
    {
        //test the params of empty
        if((!(empty($topicID)||empty($topicVersion)||empty($userID) || empty($assessment))) && ($assessment < 6) && ($assessment>0))
        {
            
            //test the topicID,topicVersion and userID in the database,if this empty then update the rating
            $where = "topicID = $topicID AND topicVersion = $topicVersion AND userID = $userID";
            $rowset = $this->fetchAll($where);
            $row = $rowset->current();
          
            if(NULL != $row->rating)
            {
                
                
                $key = "topicID=$topicID AND topicVersion=$topicVersion AND userID=$userID";
                
                $where = $this->getAdapter()->quoteInto($key);
               
                $data =  array('rating' => $assessment);
                
                $this->update($data,$where);
                
            }
        }
    }
    
    /**
        get the rating in percent
        @param topicID to identifikation thhe topic
        @param topicVersion to identifikation thhe Version
        @return rating in percent
    */
    public function getRating($topicID,$topicVersion)
    {
        //push the data out of database from a topicVersion
        $where = "topicID = $topicID AND topicVersion = $topicVersion";
        $rowset = $this->fetchAll($where);
       
        //if the rowset empty, then return 0
        if(NULL == $rowset)
        {
            return 0;
            echo "1";
        }
        else
        {
           
            $ratingpoint = 0;   //save all ratingpoints from the frend
            $count = 0;         //save the friend, they have evaluated
            foreach($rowset as $row)
            {
                if($row->rating != NULL)
                {
                    $ratingpoint += $row->rating;
                    $count++;
                }
            }
            
            $rating = 0;// if the result
            
            if($count == 0)//if the count 0, then habe no one evaluated
            {
                return 0;
            }
            else
            {
                
                $rating = ($ratingpoint/($count * 5));
                return $rating;
            }
        }
        
    }
    
    /**
        get from a friend the ratingpoints
        @param topicID to identifikation thhe topic
        @param topicVersion to identifikation thhe Version
        @param userID to identifikation thhe friend
        @return ratingpoints (from 1-5)
    */
    public function getRatingPoint($topicID,$topicVersion,$userID)
    {
        $where = "topicID = $topicID AND topicVersion = $topicVersion AND userID = $userID";
        $rowset = $this->fetchAll($where);
        $row = $rowset->current();
        
        return $row['rating'];
    }
    
    /**
        if delete the version, then musst delete the rate from the version
        @param topicID to identifikation thhe topic
        @param topicVersion to identifikation thhe Version
    */
    public function deleteRating($topicID,$topicVersion)
    {
        $adapter = $this->getAdapter();
		$sure1 = $adapter->quote($topicID);
        $sure2 = $adapter->quote($topicVersion);
		$where = "topicID = $sure1 AND topicVersion = $sure2";
		if( empty($where))
		{
			throw new Exception('empty WHERE-clause transfer');
			
		}
		$this->delete($where);
    }
}
?>
