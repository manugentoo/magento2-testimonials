<?php

namespace Manugentoo\Testimonials\Model\ResourceModel\Testimonials\Grid;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials\Collection as TestimonialsCollection;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 * @package Manugentoo\Testimonials\Model\ResourceModel\Testimonials\Grid
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Collection extends TestimonialsCollection implements SearchResultInterface
{
	/**
	 * @var AggregationInterface
	 */
	protected $aggregations;

	/**
	 * Collection constructor.
	 * @param EntityFactoryInterface $entityFactory
	 * @param LoggerInterface $logger
	 * @param FetchStrategyInterface $fetchStrategy
	 * @param ManagerInterface $eventManager
	 * @param $mainTable
	 * @param $eventPrefix
	 * @param $eventObject
	 * @param $resourceModel
	 * @param string $model
	 * @param AdapterInterface|null $connection
	 * @param AbstractDb|null $resource
	 */
	public function __construct(
		EntityFactoryInterface $entityFactory,
		LoggerInterface $logger,
		FetchStrategyInterface $fetchStrategy,
		ManagerInterface $eventManager,
		$mainTable,
		$eventPrefix,
		$eventObject,
		$resourceModel,
		$model = Document::class,
		AdapterInterface $connection = null,
		AbstractDb $resource = null
	) {
		parent::__construct(
			$entityFactory,
			$logger,
			$fetchStrategy,
			$eventManager,
			$connection,
			$resource
		);
		$this->_eventPrefix = $eventPrefix;
		$this->_eventObject = $eventObject;
		$this->_init($model, $resourceModel);
		$this->setMainTable($mainTable);
	}

	/**
	 * @return AggregationInterface
	 */
	public function getAggregations()
	{
		return $this->aggregations;
	}

	/**
	 * @param AggregationInterface $aggregations
	 * @return SearchResultInterface|void
	 */
	public function setAggregations($aggregations)
	{
		$this->aggregations = $aggregations;
	}

	/**
	 * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
	 */
	public function getSearchCriteria()
	{
		return null;
	}

	/**
	 * @param SearchCriteriaInterface|null $searchCriteria
	 * @return $this|SearchResultInterface
	 */
	public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
	{
		return $this;
	}

	/**
	 * Get total count.
	 *
	 * @return int
	 */
	public function getTotalCount()
	{
		return $this->getSize();
	}

	/**
	 * Set total count.
	 *
	 * @param int $totalCount
	 * @return $this
	 */
	public function setTotalCount($totalCount)
	{
		return $this;
	}

	/**
	 * Set items list.
	 *
	 * @param ExtensibleDataInterface[] $items
	 * @return $this
	 */
	public function setItems(array $items = null)
	{
		return $this;
	}
}
