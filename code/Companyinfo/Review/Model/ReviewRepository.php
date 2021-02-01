<?php

namespace Companyinfo\Review\Model;

use Companyinfo\Review\Api\Data\ReviewInterface;
use Companyinfo\Review\Api\Data\ReviewSearchResultInterface;
use Companyinfo\Review\Api\Data\ReviewSearchResultInterfaceFactory;
use Companyinfo\Review\Api\ReviewRepositoryInterface;
use Companyinfo\Review\Model\ResourceModel\Review as ReviewResource;
use Companyinfo\Review\Model\ResourceModel\Review\Collection as ReviewCollection;
use Companyinfo\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;


class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var ReviewResource
     */
    private $reviewResource;

    /**
     * @var ReviewFactory
     */
    private $reviewFactory;

    /**
     * @var ReviewCollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * @var ReviewSearchResultInterfaceFactory
     */
    private $reviewSearchResultFactory;

    /**
     * ReviewRepository constructor.
     * @param ReviewResource $reviewResource
     * @param ReviewFactory $reviewFactory
     * @param ReviewCollectionFactory $reviewCollectionFactory
     * @param ReviewSearchResultInterfaceFactory $reviewSearchResultInterfaceFactory
     */
    public function __construct(
        ReviewResource $reviewResource,
        ReviewFactory $reviewFactory,
        ReviewCollectionFactory $reviewCollectionFactory,
        ReviewSearchResultInterfaceFactory $reviewSearchResultInterfaceFactory
    )
    {
        $this->reviewResource = $reviewResource;
        $this->reviewFactory = $reviewFactory;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->reviewSearchResultFactory = $reviewSearchResultInterfaceFactory;
    }

    /**
     * @param int $id
     * @return ReviewInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id) : ReviewInterface
    {
        if(!array_key_exists($id, $this->registry)) {
            $review = $this->reviewFactory->create();
            $this->reviewResource->load($review, $id);
            if(!$review->getId()) {
                throw new NoSuchEntityException(__('Requested review does not exist'));
            }
            $this->registry[$id] = $review;
        }

        return $this->registry[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ReviewSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) :ReviewSearchResultInterface
    {
        /** @var ReviewCollection $collection */
        $collection = $this->reviewCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

       return $this->reviewSearchResultFactory
               ->create()
               ->setSearchCriteria($searchCriteria)
               ->setItems($collection->getItems())
               ->setTotalCount($collection->getSize());
    }

    /**
     * @param ReviewInterface $review
     * @return ReviewInterface
     * @throws StateException
     */
    public function save(ReviewInterface $review) : ReviewInterface
    {
        try {
            /** @var Review $review */
            $this->reviewResource->save($review);
            $this->registry[$review->getId()] = $this->get($review->getId());
        } catch (\Exception $exception) {
            throw new StateException(__('Unable to save review #%1', $review->getId()));
        }

        return $this->registry[$review->getId()];
    }

    /**
     * @param ReviewInterface $review
     * @return bool
     * @throws StateException
     */
    public function delete(ReviewInterface $review) : bool
    {
        try {
            /** @var Review $review */
            $this->reviewResource->delete($review);
            unset($this->registry[$review->getId()]);
        } catch (\Exception $exception) {
            throw new StateException(__('Unable to remove review #%1', $review->getId()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws StateException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id) : bool
    {
        return $this->delete($this->get($id));
    }
}

//https://habr.com/ru/post/413463/
