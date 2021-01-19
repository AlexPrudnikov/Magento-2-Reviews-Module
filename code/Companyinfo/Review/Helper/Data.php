<?php

namespace Companyinfo\Review\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Helper\View as CustomerViewHelper;

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
     * @var \Magento\Customer\Helper\View
     */
    protected $_customerViewHelper;

    /**
    * @var \Magento\Contact\Model\ConfigInterface
    */
    private $_contactsConfig;

    private $logger;

	 /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Contact\Model\ConfigInterface $contactsConfig
     * @param \Magento\Customer\Helper\View $customerViewHelper
     */
	public function __construct(\Magento\Framework\App\Helper\Context $context,
        				        \Magento\Customer\Model\Session $customerSession,
        				    	\Magento\Store\Model\StoreManagerInterface $storeManager,
        				    	\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        				    	\Magento\Contact\Model\ConfigInterface $contactsConfig,
        				    	 CustomerViewHelper $customerViewHelper 
        				    	)
	{
		parent::__construct($context);
		$this->_timezone = $timezone;
		$this->_storeManager = $storeManager;
		$this->_customerSession = $customerSession;
		$this->_customerViewHelper = $customerViewHelper;
		$this->_contactsConfig = $contactsConfig;
		$this->logger = $context->getLogger();
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

	/**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        /**
         * @var \Magento\Customer\Api\Data\CustomerInterface $customer
         */
        $customer = $this->_customerSession->getCustomerDataObject();

        return trim($this->_customerViewHelper->getCustomerName($customer));
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->_customerSession->getCustomerDataObject();

        return $customer->getEmail();
    }

    /**
    * Return email recipient address
    *
    * @return string
    * @since 100.2.0
    */
    public function emailRecipient()
    {
    	return $this->_contactsConfig->emailRecipient();
    }
}
