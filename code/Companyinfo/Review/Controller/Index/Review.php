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
	protected $data;

	/**
     * @var DataObject 
     */
	protected $dataObject;

	/** 
    *@var JsonFactory
    */
    protected $jsonResultFactory;

    protected $logger;

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
								\Companyinfo\Review\Helper\Data $data,
								\Magento\Framework\DataObject $dataObject
								)
	{
		parent::__construct($context);
		$this->reviewFactory = $reviewFactory;
		$this->jsonResultFactory = $jsonResultFactory;
		$this->email = $email;
		$this->data = $data;
		$this->dataObject = $dataObject;
	}

	public function execute()
	{
		$request = $this->getRequest();

		$idUser = $this->data->getCustomerId();
		$review = $request->getParam('review');
		$modelReview = $this->reviewFactory->Create();

		$modelReview->setCustomer_id($idUser);
		$modelReview->setReview($review);
		$modelReview->save();

		$variables = [
					  'name' => $this->data->getUserName(),
					  'email' => $this->data->getUserEmail(),
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
		$addTo = $this->data->emailRecipient();	
		$template = 'email_template_add_new_review';
		$this->email->sendEmail($addTo, ['data' => $this->dataObject], $template);	
	}
}