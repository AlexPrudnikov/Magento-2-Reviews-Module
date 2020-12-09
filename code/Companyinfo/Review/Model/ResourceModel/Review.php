<?php

namespace Companyinfo\Review\Model\ResourceModel;

/**
 * Review Resource Model
 */
class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected $_idFieldName = 'id';
	
	protected function	_construct()
	{
		$this->_init('reviews_store_table',	'id');
	}
}