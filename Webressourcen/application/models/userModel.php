<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License(GPL)
 */

/**
 * loades the database table user
 */
class UserModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'user';

	/** This function returns the highest value of userID.
	  * @return highest vakue of userID
	  */
	public function getMaxUserID()
	{
		$maxUserID = $this->fetchRow( $this->select() ->from( $this, array(new Zend_Db_Expr('max( userID) as maxUserID'))));
		return $maxUserID['maxUserID'];
	}

	/**
	 * gets all user
	 *
	 * @return $user all user
	 */
	public function getAllUser()
	{
		$user = $this->fetchAll();
		return $user;
	}

	/**
	 * gets all user
	 *
         * @param $userID ID of desired user
	 * @return $user user with $userID
	 */
	public function getUser($userID)
	{
		$row = $this->fetchRow('userID = '.$userID);
		return $row;
	}
	
	public function getSearchResult($searchWord)
	{
	$firstNameResult = $this->fetchRow( $this->select() ->from( $this) ->where('firstName LIKE ? ', $searchWord.'%'));
	$lastNameResult = $this->fetchRow( $this->select() ->from( $this) ->where('lastName LIKE ? ', $searchWord.'%'));
	foreach($firstNameResult as $result)
	{
		$lastNameResult->addRow( $result);
	}
	return $lastNameResult;
	}
}
?>
