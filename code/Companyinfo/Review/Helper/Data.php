<?php

namespace Companyinfo\Review\Helper;

/**
 * 
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	 /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
	protected $_timezone;

	 /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
	protected $_storeManager;

	 /**
     * @var \Magento\Customer\Model\Session
     */
	protected $_customerSession;

	 /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
	public function __construct(\Magento\Framework\App\Helper\Context $context,
        				        \Magento\Customer\Model\Session $customerSession,
        				    	\Magento\Store\Model\StoreManagerInterface $storeManager,
        				    	\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
        				    	)
	{
		parent::__construct($context);
		$this->_timezone = $timezone;
		$this->_storeManager = $storeManager;
		$this->_customerSession = $customerSession;
	}

	/**
    * Get Base Url
    * @return string
    */
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}

	/**
	* Get admin account link visibility
    * @return bool
    */
	public function isLoggedIn()
	{
		return $this->_customerSession->isLoggedIn();
	}

	/**
    * Get Customer Id
    * @return string
    */
	public function getCustomerId()
	{
		return $this->_customerSession->getCustomerId();
	}

	/**
    * Convert Date
    * @param string $data
    * @return string
    */
	public function getConvertDate($date)
	{
		return $this->_timezone->date(new \DateTime($date))->format('d/m/y');
	}
}
