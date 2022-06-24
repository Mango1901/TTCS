<?php

namespace Magenest\AdminActivity\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Login
 *
 * @package Magenest\AdminActivity\Model\ResourceModel
 */
class Login extends AbstractDb
{
	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	public function _construct()
	{
		// Table Name and Primary Key column
		$this->_init('magenest_login_activity', 'entity_id');
	}
}
