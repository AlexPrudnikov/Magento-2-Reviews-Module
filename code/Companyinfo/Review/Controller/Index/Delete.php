<?php

namespace Companyinfo\Review\Controller\Index;
 
use Companyinfo\Review\Model\ReviewFactory;
 
class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ReviewFactory
     */
    protected $_modelFactory;

    /** 
    *@var \Magento\Framework\Controller\Result\JsonFactory
    */
    protected $jsonResultFactory;
 
    /**
     * @param Context $context
     * @param ReviewFactory $modelFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        ReviewFactory $modelFactory
    ) {
    	parent::__construct($context);
        $this->_modelFactory = $modelFactory;
        $this->jsonResultFactory = $jsonResultFactory;
    }

    public function execute()
    {
        $request = $this->getRequest();
        $reviewId = (int) $request->getParam('id');
        $reviewData = $this->_modelFactory->create();
        if($reviewId) {
        	$reviewData = $reviewData->load($reviewId);
        	$reviewData->delete();
        }

        $page = (int) $request->getParam('p');
        $result = $this->jsonResultFactory->create();
        $result->setData(['page' => $page]);
        return $result;
    }
}