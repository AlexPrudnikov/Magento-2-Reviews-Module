<?php

namespace Companyinfo\Review\Api\Data;

use \Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ReviewSearchResultInterface
 * @package Companyinfo\Review\Api\Data
 */
interface ReviewSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Companyinfo\Review\Api\Data\ReviewInterface[]
     */
    public function getItems();

    /**
     * @param ReviewInterface[] $items
     * @return ReviewSearchResultInterface
     */
    public function setItems(array $items);
}
