<?php

namespace Companyinfo\Review\Controller\Index;

class Review extends \Magento\Framework\App\Action\Action
{
	/**
     * @var \Companyinfo\Review\Model\ReviewFactory $reviewFactory
     */
	protected $reviewFactory;

	/**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Companyinfo\Review\Model\ReviewFactory $reviewFactory
     */
	public function __construct(\Magento\Framework\App\Action\Context $context,
								\Companyinfo\Review\Model\ReviewFactory $reviewFactory
								)
	{
		parent::__construct($context);
		$this->reviewFactory = $reviewFactory;
	}

	public function execute()
	{
		$id = $this->getRequest()->getParam('id');
		$review = $this->getRequest()->getParam('review');
		$modelReview = $this->reviewFactory->Create();

		$modelReview->setCustomer_id($id);
		$modelReview->setReview($review);
		$modelReview->save();
		$this->getResponse()->setBody('success');
	}
}