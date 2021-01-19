<?php

namespace Companyinfo\Review\Observer;

use	Magento\Framework\View\Element\Template;
use Companyinfo\Review\Model\ReviewFactory;
use Magento\Framework\DataObject;

class ChangeStatusReview implements \Magento\Framework\Event\ObserverInterface
{
	/**
    * @var ResourceConnection
    */
	protected $resource;

	/**
    * @var ReviewFactory
    */
    protected $_modelFactory;

    /**
     * @var Email 
     */
	protected $email;

	/**
    * @var ConfigInterface
    */
	protected $config;

    protected $logger;

	/**
    * @param Template\Context $context
    * @param \Magento\Framework\App\ResourceConnection $resource
    * @param \Companyinfo\Review\Helper\Email $email
    * @param array $data
    */
	public	function __construct(
					Template\Context $context,
					ReviewFactory $modelFactory,
					\Magento\Framework\App\ResourceConnection $resource,
					\Companyinfo\Review\Helper\Email $email,
					\Companyinfo\Review\Model\Config\ConfigInterface $config,
					array $data	= [])
	{           
					$this->_modelFactory = $modelFactory;
					$this->resource = $resource;
				    $this->email = $email;
				    $this->config = $config;
					$this->logger = $context->getLogger();
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$collection = $observer->getData('collection');
		$customer_entity_name = $this->resource->getTableName('customer_entity');

		$collection->getSelect()->join(['customer_entity' => $customer_entity_name],
									    'main_table.customer_id = customer_entity.entity_id');
		$collection->getSelect()->order('main_table.create_at DESC');

		$this->sendEmail($collection);

        return $this;
	}

	private function sendEmail($collection) 
	{
		$template = $this->config->emailTemplateChange();
		foreach ($collection as $item) {
                $email = $item->getData('email');
			$data = [
			     	  'name' => $item->getData('firstname'),
				 	  'email' => $item->getData('email'),
				      'review' => $item->getData('review')
				 	];            

			$this->logger->debug($email);

            $this->email->sendEmail($email, ['data' => new DataObject($data)], $template);
        }
	}
}
