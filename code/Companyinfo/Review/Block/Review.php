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

		$collection = $this->collectionFactory->create()->addFieldToFilter('status', ['in' => [1]]);
		$customer_entity_name = $this->resource->getTableName('customer_entity');

		$collection->getSelect()->join(['customer_entity' => $customer_entity_name],
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
        $collection = $this->collectionFactory->create();
        $customer_entity_name = $this->resource->getTableName('customer_entity');

        $collection->getSelect()->join(['customer_entity' => $customer_entity_name],
                                       'main_table.customer_id = customer_entity.entity_id');

        $review = $collection->getItemById($id);
        return $review;
    }

    public function getRequestParam($param)
    {
        $request = $this->getRequest();
        $result = $request->getParam($param) ? $request->getParam($param) : 1;
        return $result;
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

    /**
    * Convert Date
    * @param string $data
    * @return bool
    */
    public function usersReview($customerId)
    {
        return $this->_helper->isLoggedIn() && $this->_helper->getCustomerId() === $customerId;
    }

    /**
    * Get Url Action Edit
    * @return string
    */
    public function getEditAction($id)
    {
        $page = $this->getRequestParam('p');
        return $this->getUrl("review/index/edit?id=${id}&p=${page}", ['_secure' => true]);
    }

    /**
    * Get Url Action Delete
    * @return string
    */
    public function getDeleteAction($id)
    {
        $page = $this->getRequestParam('p');
        return $this->getUrl("review/index/delete?id=${id}&p=${page}", ['_secure' => true]);
    }

}
