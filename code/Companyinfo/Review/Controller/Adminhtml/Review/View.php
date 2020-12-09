<?php

namespace Companyinfo\Review\Controller\Adminhtml\Review;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
 
class View extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
 
    /**
     * @param Context $context
     * @param ReviewFactory $modelFactory
     */
    public function __construct(
        Context $context,
        Pagefactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
 
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
         /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Review View'));
 
        return $resultPage;
    }
}