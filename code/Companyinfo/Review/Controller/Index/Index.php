<?php

namespace Companyinfo\Review\Controller\Index;

class Index	extends	\Magento\Framework\App\Action\Action
{
	/**	
	* @var \Magento\Framework\View\Result\PageFactory
	*/
	protected $resultPageFactory;

	/**
    * @var \Companyinfo\Review\Helper\Data $helper
    */
	protected $helper;

	public function __construct(\Magento\Framework\App\Action\Context $context,
								\Magento\Framework\View\Result\PageFactory $resultPageFactory,
								\Companyinfo\Review\Helper\Data $helper
								)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->helper = $helper;
	}

	/*
	* Index	action
	*
	* @return $this
	*/
	public function execute()
	{
		$page = $this->getRequest()->getParam('p');

		if(!$page)
		{
			$resultPage = $this->resultPageFactory->create();
			$resultPage->getConfig()->getTitle()->set($this->helper->getConfigData('meta_title'));
			$resultPage->getConfig()->setDescription($this->helper->getConfigData('meta_description'));
			$resultPage->getConfig()->setKeywords($this->helper->getConfigData('meta_keyword'));
			return $resultPage;	
		} else 
		{
			$this->getAjax();
		}
	}

	protected function getAjax()
	{
		$this->_view->loadLayout();
		$layout = $this->_view->getLayout();
		$block = $layout->getBlock("new_reviews");
		$this->getResponse()->setBody($block->toHtml());
	}
}