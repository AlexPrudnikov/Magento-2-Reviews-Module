<?php

namespace Slider\BestSellerProducts\Block;

class BestSellerProduct extends \Magento\Framework\View\Element\Template {

    protected $_resourceFactory;
    protected $_imageHelper;
    protected $_cartHelper;
    protected $product;

    protected $_categoryResorceFactoory;

    public function __construct(
    \Magento\Catalog\Block\Product\Context $context,
    \Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
    \Magento\Catalog\Model\Product $product,

     array $data = []
    ) {
        $this->_resourceFactory = $resourceFactory;
        $this->product = $product;
        $this->_imageHelper = $context->getImageHelper();
        $this->_cartHelper = $context->getCartHelper();

        parent::__construct($context, $data);
    }

    public function imageHelperObj() {
        return $this->_imageHelper;
    }

    public function getProduct($id) {
        return $this->product->load($id);
    }

    /**
      To get featured product collection
     */
    public function getBestsellerProduct() {
        $resourceCollection = $this->_resourceFactory->create('Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection');
        $resourceCollection->setPageSize(8);
        return $resourceCollection;
    }

    public function getAddToCartUrl($product, $additional = []) {
        return $this->_cartHelper->getAddUrl($product, $additional);
    }

    public function getProductPriceHtml(
    \Magento\Catalog\Model\Product $product, $priceType = null, $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST, array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }
        $arguments['zone'] = isset($arguments['zone']) ? $arguments['zone'] : $renderZone;
        $arguments['price_id'] = isset($arguments['price_id']) ? $arguments['price_id'] : 'old-price-' . $product->getId() . '-' . $priceType;
        $arguments['include_container'] = isset($arguments['include_container']) ? $arguments['include_container'] : true;
        $arguments['display_minimal_price'] = isset($arguments['display_minimal_price']) ? $arguments['display_minimal_price'] : true;

        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                    \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE, $product, $arguments
            );
        }
        return $price;
    }

}


