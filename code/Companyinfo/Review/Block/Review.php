<?php
namespace Companyinfo\Review\Block;

use	Magento\Framework\View\Element\Template;
use Companyinfo\Review\Model\ReviewFactory;
use Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory;

class Review extends Template
{
    /**
    * @var Companyinfo\Review\Model\ReviewFactory
    */
    protected $_reviewFactory;

	/**
    * @var Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory
    */
	protected $collectionFactory;

	/**
    * @var \Magento\Framework\App\ResourceConnection
    */
	protected $resource;

	/**
    * @var \Companyinfo\Review\Helper\Data $helper
    */
	protected $_helper;

	 /**
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Companyinfo\Review\Helper\Data $helper
     * @param array $data
     */
	public	function __construct(
					Template\Context $context,
                    ReviewFactory $reviewFactory,
					CollectionFactory $collectionFactory,
					\Magento\Framework\App\ResourceConnection $resource,
					\Companyinfo\Review\Helper\Data $helper,
					array $data	= [])
	{
                    $this->_reviewFactory = $reviewFactory;
					$this->collectionFactory = $collectionFactory;
					$this->resource = $resource;
					$this->_helper = $helper;
					parent::__construct($context, $data);
	}
	
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Reviews'));
        if ($this->getAllReviews()) {
            $pager = $this->getLayout()->createBlock(
                'Companyinfo\Review\Block\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getAllReviews()
                );
            $this->setChild('pager', $pager);
            $this->getAllReviews()->load();
        }
        return $this;
    }

	/**
    * Render pagination HTML
    *
    * @return string
    */
	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
    * Render pagination HTML
    *
    * @return Review Collection
    */
	public function getAllReviews()
	{
		$page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest( 
        )->getParam('limit') : 5;

		$collection = $this->collectionFactory->create();
		$customer_entity_name = $this->resource->getTableName('customer_entity');

		$collection->getSelect()->join(array('customer_entity' => $customer_entity_name),
											 'main_table.customer_id = customer_entity.entity_id');
		$collection->getSelect()->order('main_table.create_at DESC');

		$collection->setPageSize($pageSize);
		$collection->setCurPage($page);
	
		return $collection;
	}

    /**
    * @return Review model
    */
    public function getReview()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $collection = $this->getAllReviews();
        $review = $collection->getItemById($id);

        return $review;
    }

 	/**
    * Convert Date
    * @param string $data
    * @return string
    */
	public function getConvertDate($date)
	{
		return $this->_helper->getConvertDate($date);
	}

}
