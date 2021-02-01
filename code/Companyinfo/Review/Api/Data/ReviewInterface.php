<?php

namespace Companyinfo\Review\Api\Data;

/**
 * Interface ReviewInterface
 * @package Companyinfo\Api\Data
 * @api
 */
interface ReviewInterface
{
    /**
     * Constants
     * @var string
     */
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const REVIEW = 'review';
    const STATUS = 'status';
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @param int $customerId
     * @return $this
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @return string
     */
    public function getReview();

    /**
     * @param $review
     * @return $this
     */
    public function setReview(string $review);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @return string
     */
    public function getCreateAt();

    /**
     * @param string $createAt
     * @return $this
     */
    public function setCreateAt(string $createAt);

    /**
     * @return string
     */
    public function getUpdateAt();

    /**
     * @param string $updateAt
     * @return $this
     */
    public function setUpdateAt(string $updateAt);
}
