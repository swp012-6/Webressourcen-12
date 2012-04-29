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
}
?>
