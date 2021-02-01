<?php

namespace Companyinfo\Review\Model;

use Magento\Framework\Model\AbstractModel;
use Companyinfo\Review\Api\Data\ReviewInterface;

/**
 * Review model
 */
class Review extends AbstractModel implements ReviewInterface
{
    protected $_idFieldName = ReviewInterface::ID;

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

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * @return string
     */
    public function getReview()
    {
        return $this->getData(self::REVIEW);
    }

    /**
     * @param $review
     * @return $this
     */
    public function setReview(string $review)
    {
        $this->setData(self::REVIEW, $review);
        return $this;
    }

    /**
     * @return string
     */
    public function getCreateAt()
    {
        return $this->getData(self::CREATE_AT);
    }

    /**
     * @param string $createAt
     * @return $this
     */
    public function setCreateAt(string $createAt)
    {
        $this->setData(self::CREATE_AT, $createAt);
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->getData(self::UPDATE_AT);
    }

    /**
     * @param string $updateAt
     * @return $this
     */
    public function setUpdateAt(string $updateAt)
    {
        $this->setData(self::UPDATE_AT, $updateAt);
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }
}
