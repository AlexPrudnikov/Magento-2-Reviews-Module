<?php

namespace Companyinfo\Review\Controller\Adminhtml\Review;
 
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\DB\TransactionFactory;
use Companyinfo\Review\Model\ReviewFactory;
use Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory;
 
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter.​_
     * @var Filter
     */
    protected $_filter;
 
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var ReviewFactory
     */
    protected $_modelFactory;

     /**
     * @var TransactionFactory
     */
    protected $_transactionFactory;
 
    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     * @param TransactionFactory $transactionFactory
     * @param ReviewFactory $modelFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        ReviewFactory $modelFactory,
        TransactionFactory $transactionFactory,
        CollectionFactory $collectionFactory
    ) {
 
        $this->_filter = $filter;
        $this->_modelFactory = $modelFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_transactionFactory = $transactionFactory;
        parent::__construct($context);
    }
 
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $recordDeleted = 0;

        $transaction = $this->_transactionFactory->create();
        foreach ($collection as $item) {
            $deleteItem = $this->_modelFactory->create()->load($item->getId());
            $transaction->addObject($deleteItem);
            $recordDeleted++;
        }
        $transaction->delete();

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $recordDeleted));
 
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