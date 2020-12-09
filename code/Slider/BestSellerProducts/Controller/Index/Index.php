<?php
namespace Slider\BestSellerProducts\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action {
	private $pageFactory;
	public  function __construct(
    	\Magento\Framework\View\Result\PageFactory $pageFactory,
    	Context $context)
	{
    	parent::__construct($context);
        $this->pageFactory = $pageFactory;
	}
 
	public function execute()
	{
        return $this->pageFactory->create();
	}
}