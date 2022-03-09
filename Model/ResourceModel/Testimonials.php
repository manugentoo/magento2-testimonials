<?php

namespace Manugentoo\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Manugentoo\Testimonials\Api\Data\TestimonialInterface;

/**
 * Class Testimonials
 * @package Manugentoo\Testimonials\Model\ResourceModel
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Testimonials extends AbstractDb
{
	/**
	 * @var DateTime
	 */
	protected $_date;

	/**
	 * @param Context $context
	 * @param DateTime $date
	 */
	public function __construct(
		Context $context,
		DateTime $date
	) {
		$this->_date = $date;
		parent::__construct($context);
	}

	/**
	 * Define main table
	 */
	protected function _construct()
	{
		$this->_init(TestimonialInterface::TABLE_NAME, TestimonialInterface::TABLE_NAME);
	}

	/**
	 * @param AbstractModel $object
	 * @return AbstractDb
	 */
	protected function _beforeSave(AbstractModel $object)
	{
		if ($object->isObjectNew()) {
			$object->setCreatedAt($this->_date->date());
		}
		return parent::_beforeSave($object);
	}

}