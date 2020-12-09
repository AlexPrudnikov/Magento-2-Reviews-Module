<?php

namespace Companyinfo\Review\Model\ResourceModel\Review;

/**
* Review Collection
*/
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection	
{
	protected $_idFieldName = 'id';

	/**
	* Initialize resource collection
	*
	* @return void
	*/
	protected function	_construct()
	{
		$this->_init('Companyinfo\Review\Model\Review', 'Companyinfo\Review\Model\ResourceModel\Review');
	}
}
