<?php

namespace Companyinfo\Review\Controller\Index;

class Index	extends	\Magento\Framework\App\Action\Action
{
	/**	@var \Magento\Framework\View\Result\PageFactory */
	protected $resultPageFactory;

	public function __construct(\Magento\Framework\App\Action\Context $context,
								\Magento\Framework\View\Result\PageFactory $resultPageFactory
								)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
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