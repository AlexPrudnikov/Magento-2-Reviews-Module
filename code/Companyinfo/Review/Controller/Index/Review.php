<?php

namespace Companyinfo\Review\Controller\Index;

use Magento\Framework\App\Action\Context;
use Companyinfo\Review\Api\Data\ReviewInterfaceFactory;
use Companyinfo\Review\Api\ReviewRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Companyinfo\Review\Helper\Email;
use Companyinfo\Review\Helper\Data;
use Magento\Framework\DataObject;
use Companyinfo\Review\Model\Config\ConfigInterface;

class Review extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Email
     */
	protected $email;

	/**
     * @var Data
     */
	protected $helper;

	/**
     * @var DataObject
     */
	protected $dataObject;

	/**
    *@var JsonFactory
    */
    protected $jsonResultFactory;

    /**
    * @var ConfigInterface
    */
	protected $config;

    /**
     * @var ReviewInterfaceFactory
     */
	protected $reviewInterfaceFactory;

    /**
     * @var ReviewRepositoryInterface
     */
	protected $reviewRepositoryInterface;

    /**
     * Review constructor.
     * @param Context $context
     * @param ReviewInterfaceFactory $reviewInterfaceFactory
     * @param ReviewRepositoryInterface $reviewRepositoryInterface
     * @param JsonFactory $jsonResultFactory
     * @param Email $email
     * @param Data $helper
     * @param DataObject $dataObject
     * @param ConfigInterface $config
     */
	public function __construct(Context $context,
								ReviewInterfaceFactory $reviewInterfaceFactory,
								ReviewRepositoryInterface $reviewRepositoryInterface,
								JsonFactory $jsonResultFactory,
								Email $email,
								Data $helper,
								DataObject $dataObject,
								ConfigInterface $config
								)
	{
		parent::__construct($context);
		$this->reviewInterfaceFactory = $reviewInterfaceFactory;
		$this->reviewRepositoryInterface = $reviewRepositoryInterface;
		$this->jsonResultFactory = $jsonResultFactory;
		$this->email = $email;
		$this->helper = $helper;
		$this->dataObject = $dataObject;
		$this->config = $config;
	}

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
	public function execute()
	{
		$request = $this->getRequest();

		$idUser = $this->helper->getCustomerId();
		$review = $request->getParam('review');

        $modelReview = $this->reviewInterfaceFactory
            ->create()
            ->setCustomerId($idUser)
            ->setReview($review);
        $this->reviewRepositoryInterface
            ->save($modelReview);

		$variables = [
					  'name' => $this->helper->getUserName(),
					  'email' => $this->helper->getUserEmail(),
					  'review' => $review
					 ];

		$this->sendEmail($variables);

		$result = $this->jsonResultFactory->create();
		$result->setData([
                          'message' => __('Thank you for your review, it will be published after being checked by a moderator!.')
                         ]);
		return $result;
	}

    /**
     * @param array $variables
     * @return void
     */
	private function sendEmail(array $variables) : void
	{
		$this->dataObject->addData($variables);
		$addTo = $this->config->emailRecipient();
		$template = $this->config->emailTemplateAdd();
		$this->email->sendEmail($addTo, ['data' => $this->dataObject], $template);
	}
}
