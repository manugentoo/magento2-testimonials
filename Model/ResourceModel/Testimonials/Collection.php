<?php

namespace Manugentoo\Testimonials\Model\ResourceModel\Testimonials;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials as TestimonialResource;
use Manugentoo\Testimonials\Model\Testimonials;

/**
 * Class Collection
 * @package Manugentoo\Testimonials\Model\ResourceModel\Testimonials
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Collection extends AbstractCollection
{
	/**
	 * @var string
	 */
	protected $_idFieldName = 'testimonial_id';
	/**
	 * @var string
	 */
	protected $_eventPrefix = 'testimonials_collecion';
	/**
	 * @var string
	 */
	protected $_eventObject = 'tetimonials_collection';

	/**
	 * @return $this
	 */
	public function addWithImageFilter()
	{
		$this->getSelect()->where('company_image IS NOT NULL');
		return $this;
	}

	/**
	 * @return $this
	 */
	public function radomize()
	{
		$this->getSelect()->order("RAND()");
		return $this;
	}

	/**
	 * Constructor
	 */
	protected function _construct()
	{
		$this->_init(
			Testimonials::class,
			TestimonialResource::class
		);
	}
}
