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
<<<<<<< HEAD
	protected $_name = 'user';

	/**
	 * counts the user
	 *
	 * @return $number number of user
	 */
	public function countUser()
	{
		$rowset = $this->fetchAll();
		$number = count($rowset);
		return $number;
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
=======
    protected $_name = 'user';
    
    /** This function returns the highest value of userID.
      * @return highest vakue of userID
      */
    public function getMaxUserID()
    {
        $maxUserID = $this->fetchRow( $this->select()  ->from( $this, array(new Zend_Db_Expr('max( userID) as maxUserID'))));
        return $maxUserID['maxUserID'];
    }
>>>>>>> 17f21294dfe0b5710eef48a4ec68017222f3b5f2
}
?>
