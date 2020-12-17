<?php
 
namespace Companyinfo\Review\Controller\Adminhtml\Review;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Companyinfo\Review\Model\ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Companyinfo\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Companyinfo\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Framework\Stdlib\DateTime $dateTime
    ) {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
        $this->dateTime = $dateTime;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('review/review/edit');
            return;
        }
        try {
            $rowData = $this->reviewFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
                $rowData->setCustomerId($data['customer_id']);
                $rowData->setReview($data['review']);
                $rowData->setUpdateAt($this->dateTime->formatDate(true));
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('review/review/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Companyinfo_Review::save');
    }
}