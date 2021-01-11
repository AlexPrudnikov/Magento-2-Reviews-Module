<?php

namespace Companyinfo\Review\Controller\Adminhtml\Review;
 
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\TransactionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Companyinfo\Review\Model\ReviewFactory;
use Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Framework\Event\ManagerInterface;
 
class MassStatus extends \Magento\Backend\App\Action
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
    * @var ManagerInterface
    */
    protected $_eventManager;
 
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
        CollectionFactory $collectionFactory,
        ManagerInterface $eventManager
    ) {
        $this->_filter = $filter;
        $this->_modelFactory = $modelFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_transactionFactory = $transactionFactory;
        $this->_eventManager = $eventManager;
        parent::__construct($context);
    }
 
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
    	$status = $this->getRequest()->getParam('status');
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        $this->_eventManager->dispatch('companyinfo_review_save_commit_after', ['collection' => $collection]);
        
        $transaction = $this->_transactionFactory->create();
        foreach ($collection as $item) {
            $changeStatus = $this->_modelFactory->create()->load($item->getId());
            $changeStatus->setStatus($status);
            $transaction->addObject($changeStatus);
        }
        $transaction->save();

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));
 
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}