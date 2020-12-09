<?php

namespace Companyinfo\Review\Controller\Adminhtml\Index;

use	Magento\Backend\App\Action\Context;
use	Magento\Framework\View\Result\PageFactory;

class Index	extends	\Magento\Backend\App\Action
{
	protected $_publicActions = ['index'];
	protected $resultPageFactory;

	public function __construct(Context $context, PageFactory $resultPageFactory)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public	function execute()
	{
		$resultPage	= $this->resultPageFactory->create();
		return $resultPage;
	}

 	/**
    * Check is user can access to Google Advertising Channels Connector
    *
    * @return bool
    */
	protected function _isAllowed()
	{	
		return	$this->_authorization->isAllowed('Companyinfo_Review::index');
	}
	
}