<?php
namespace Companyinfo\Review\Block;

use	Magento\Framework\View\Element\Template;
use Companyinfo\Review\Model\ReviewFactory;
use Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory;

class ReviewForm extends Template
{
	/**
     * @var \Companyinfo\Review\Helper\Data
     */
	protected $_helper;

	/**
     * @param Template\Context $context
     * @param \Companyinfo\Review\Helper\Data $helper
     * @param array $data
     */
	public function __construct(
					Template\Context $context,
					\Companyinfo\Review\Helper\Data $helper,
					array $data	= [])
	{
					parent::__construct($context, $data);
					$this->_helper = $helper;
	}

	/**
    * Get Customer Id
    * @return string
    */
	public function getCustomerId()
	{
		return $this->_helper->getCustomerId();
	}

	/**
	* Get admin account link visibility
    * @return bool
    */
	public function isLoggedIn()
	{
		return $this->_helper->isLoggedIn();
	}

	/**
    * Get Base Url
    * @return string
    */
	public function getBaseUrl()
	{
		return $this->_helper->getBaseUrl();
	}

	/**
    * Get Url Action Form
    * @return string
    */
	public function getFormAction()
    {
        return $this->getUrl('review/index/review', ['_secure' => true]);
    }

}
