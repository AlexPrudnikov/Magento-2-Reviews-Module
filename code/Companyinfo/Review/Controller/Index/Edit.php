<?php

namespace Companyinfo\Review\Controller\Index;

use Companyinfo\Review\Model\ReviewFactory;
use Companyinfo\Review\Api\ReviewRepositoryInterface;
use Companyinfo\Review\Model\Config\ConfigInterface;
use Companyinfo\Review\Helper\Data;
use Companyinfo\Review\Helper\Email;
use Magento\Framework\DataObject;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\Context;

class Edit extends \Magento\Framework\App\Action\Action
{
    /**
    * @var ReviewFactory
    */
    protected $_modelFactory;

    /**
     * @var ReviewRepositoryInterface
     */
    protected $reviewRepositoryInterface;

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
     * Edit constructor.
     * @param Context $context
     * @param JsonFactory $jsonResultFactory
     * @param Email $email
     * @param Data $data
     * @param DataObject $dataObject
     * @param ConfigInterface $config
     * @param ReviewFactory $modelFactory
     * @param ReviewRepositoryInterface $reviewRepositoryInterface
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonResultFactory,
        Email $email,
        Data $data,
        DataObject $dataObject,
        ConfigInterface $config,
        ReviewFactory $modelFactory,
        ReviewRepositoryInterface $reviewRepositoryInterface
    ) {
    	parent::__construct($context);
        $this->jsonResultFactory = $jsonResultFactory;
        $this->email = $email;
        $this->data = $data;
        $this->dataObject = $dataObject;
        $this->config = $config;
        $this->_modelFactory = $modelFactory;
        $this->reviewRepositoryInterface = $reviewRepositoryInterface;
    }

    public function execute()
    {
    	$request = $this->getRequest();
        $reviewId = (int) $request->getParam('idReview');
		$editedReview = $request->getParam('review');

        $review = $this->reviewRepositoryInterface->get($reviewId);
        $review->setStatus(0)
               ->setReview($editedReview);
        $this->reviewRepositoryInterface->save($review);

        $variables = [
                      'name' => $this->data->getUserName(),
                      'email' => $this->data->getUserEmail(),
                      'review' => $review->getReview()
                     ];

        $this->sendEmail($variables);

		$page = (int) $request->getParam('p');
		$result = $this->jsonResultFactory->create();
		$result->setData(['page' => $page,
                          'message' => __('Your review edited, it will be published after being checked by a moderator!.')
                         ]);
		return $result;
    }

    /**
     * @param $variables
     */
    private function sendEmail($variables) : void
    {
        $this->dataObject->addData($variables);
        $addTo = $this->config->emailRecipient();
        $template = $this->config->emailTemplateEdit();
        $this->email->sendEmail($addTo, ['data' => $this->dataObject], $template);
    }
}
