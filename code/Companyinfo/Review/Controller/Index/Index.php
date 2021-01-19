<?php

namespace Companyinfo\Review\Controller\Index;

class Index	extends	\Magento\Framework\App\Action\Action
{
	/**	
	* @var PageFactory
	*/
	protected $resultPageFactory;

	/**
    * @var ConfigInterface
    */
	protected $config;

	public function __construct(\Magento\Framework\App\Action\Context $context,
								\Magento\Framework\View\Result\PageFactory $resultPageFactory,
								\Companyinfo\Review\Model\Config\ConfigInterface $config
								)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->config = $config;
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
			$resultPage->getConfig()->getTitle()->set($this->config->getTitle());
			$resultPage->getConfig()->setDescription($this->config->getDescription());
			$resultPage->getConfig()->setKeywords($this->config->getKeywords());
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