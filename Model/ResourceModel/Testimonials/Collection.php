<?php
namespace Manugentoo\Testimonials\Model\ResourceModel\Testimonials;

/**
 * Class Collection
 * @package Manugentoo\Testimonials\Model\ResourceModel\Testimonials
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
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
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(\Manugentoo\Testimonials\Model\Testimonials::class, \Manugentoo\Testimonials\Model\ResourceModel\Testimonials::class);
    }

	/**
	 * @return $this
	 */
    public function addWithImageFilter() {
    	$this->getSelect()->where('company_image IS NOT NULL');
    	return $this;
	}

	/**
	 * @return $this
	 */
	public function radomize() {
    	$this->getSelect()->order("RAND()");
    	return $this;
	}
}
