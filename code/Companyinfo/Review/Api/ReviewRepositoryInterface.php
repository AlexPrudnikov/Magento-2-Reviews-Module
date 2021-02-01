<?php

namespace Companyinfo\Review\Api;

use Companyinfo\Review\Api\Data\ReviewInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ReviewRepositoryInterface
 * @package Companyinfo\Review\Api
 * @api
 */
interface ReviewRepositoryInterface
{
    /**
     * @param int $id
     * @return \Companyinfo\Review\Api\Data\ReviewInterface
     */
    public function get(int $id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Companyinfo\Review\Api\Data\ReviewSearchResultInterface
     */
    public function getList(SearchCriteriaInterface  $searchCriteria);

    /**
     * @param \Companyinfo\Review\Api\Data\ReviewInterface $review
     * @return \Companyinfo\Review\Api\Data\ReviewInterface
     */
    public function save(ReviewInterface $review);

    /**
     * @param \Companyinfo\Review\Api\Data\ReviewInterface $review
     * @return bool
     */
    public function delete(ReviewInterface $review);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
