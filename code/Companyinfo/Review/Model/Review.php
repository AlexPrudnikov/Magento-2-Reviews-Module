<?php

namespace Companyinfo\Review\Model;

/**
 * Review model
 */
class Review extends \Magento\Framework\Model\AbstractModel
{
	 /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
	public function	__construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry	$registry,
		\Magento\Framework\Model\ResourceModel\AbstractResource	$resource = null,
		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection =	null, 
		array $data	= []
		)
	{
		parent::__construct($context, $registry, $resource,	$resourceCollection, $data);
	}

	protected function _construct()
	{
		$this->_init('Companyinfo\Review\Model\ResourceModel\Review');
	}
}