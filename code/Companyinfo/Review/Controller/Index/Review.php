<?php

namespace Companyinfo\Review\Controller\Index;

class Review extends \Magento\Framework\App\Action\Action
{
	/**
     * @var ReviewFactory
     */
	protected $reviewFactory;

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
     * @param Context $context
     * @param ReviewFactory $reviewFactory
     * @param JsonFactory $jsonResultFactory
     * @param Email $email
     * @param Data $data
     * @param DataObject $dataObject
     */
	public function __construct(\Magento\Framework\App\Action\Context $context,
								\Companyinfo\Review\Model\ReviewFactory $reviewFactory,
								\Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
								\Companyinfo\Review\Helper\Email $email,
								\Companyinfo\Review\Helper\Data $helper,
								\Magento\Framework\DataObject $dataObject,
								\Companyinfo\Review\Model\Config\ConfigInterface $config
								)
	{
		parent::__construct($context);
		$this->reviewFactory = $reviewFactory;
		$this->jsonResultFactory = $jsonResultFactory;
		$this->email = $email;
		$this->helper = $helper;
		$this->dataObject = $dataObject;
		$this->config = $config;
	}

	public function execute()
	{
		$request = $this->getRequest();

		$idUser = $this->helper->getCustomerId();
		$review = $request->getParam('review');
		$modelReview = $this->reviewFactory->Create();

		$modelReview->setCustomer_id($idUser);
		$modelReview->setReview($review);
		$modelReview->save();

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

	private function sendEmail($variables)
	{
		$this->dataObject->addData($variables);
		$addTo = $this->config->emailRecipient();	
		$template = $this->config->emailTemplateAdd();
		$this->email->sendEmail($addTo, ['data' => $this->dataObject], $template);	
	}
}