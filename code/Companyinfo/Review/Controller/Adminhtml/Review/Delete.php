<?php

namespace Companyinfo\Review\Controller\Adminhtml\Review;
 
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Companyinfo\Review\Model\ReviewFactory;
 
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var ReviewFactory
     */
    protected $_modelFactory;
 
    /**
     * @param Context $context
     * @param ReviewFactory $modelFactory
     */
    public function __construct(
        Context $context,
        ReviewFactory $modelFactory
    ) {
        $this->_modelFactory = $modelFactory;
        parent::__construct($context);
    }
 
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $reviewId = (int) $this->getRequest()->getParam('id');
        $reviewData = $this->_modelFactory->create();
        if($reviewId) {
        	$reviewData = $reviewData->load($reviewId);
        	$reviewData->delete();
        }
        $this->messageManager->addSuccess(__('The entry has been deleted.'));
 
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
 
    /**
     * Check Category Map recode delete Permission.
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Companyinfo_Review::row_data_massdelete');
    }
}