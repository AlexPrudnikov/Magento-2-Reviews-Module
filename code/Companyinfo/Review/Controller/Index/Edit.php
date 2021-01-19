<?php

namespace Companyinfo\Review\Controller\Index;
 
use Companyinfo\Review\Model\ReviewFactory;
 
class Edit extends \Magento\Framework\App\Action\Action
{
    /**
    * @var ReviewFactory
    */
    protected $_modelFactory;

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

    /**
    * @var ConfigInterface
    */
    protected $config;
 
    /**
     * @param Context $context
     * @param JsonFactory $jsonResultFactory
     * @param Email $email
     * @param Data $data
     * @param DataObject $dataObject
     * @param ConfigInterface $config
     * @param ReviewFactory $modelFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Companyinfo\Review\Helper\Email $email,
        \Companyinfo\Review\Helper\Data $data,
        \Magento\Framework\DataObject $dataObject,
        \Companyinfo\Review\Model\Config\ConfigInterface $config,
        ReviewFactory $modelFactory
    ) {
    	parent::__construct($context);
        $this->jsonResultFactory = $jsonResultFactory;
        $this->email = $email;
        $this->data = $data;
        $this->dataObject = $dataObject;
        $this->config = $config;
        $this->_modelFactory = $modelFactory;
    }

    public function execute()
    {
    	$status = 0;
    	$request = $this->getRequest();
        $reviewId = (int) $request->getParam('idReview');
		$editedReview= $request->getParam('review');

		$reviewData = $this->_modelFactory->Create();
		$review = $reviewData->load($reviewId);

		$review->setStatus($status);
		$review->setReview($editedReview);
		$review->save();

        $variables = [
                      'name' => $this->data->getUserName(),
                      'email' => $this->data->getUserEmail(),
                      'review' => $review->getData('review')
                     ];

        $this->sendEmail($variables);

		$page = (int) $request->getParam('p');
		$result = $this->jsonResultFactory->create();
		$result->setData(['page' => $page,
                          'message' => __('Your review edited, it will be published after being checked by a moderator!.')
                         ]);
		return $result;
    }

    private function sendEmail($variables)
    {
        $this->dataObject->addData($variables);
        $addTo = $this->config->emailRecipient(); 
        $template = $this->config->emailTemplateEdit();
        $this->email->sendEmail($addTo, ['data' => $this->dataObject], $template);  
    }
}