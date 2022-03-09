<?php
namespace Manugentoo\Testimonials\Model\ResourceModel;

/**
 * Class Testimonials
 * @package Manugentoo\Testimonials\Model\ResourceModel
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Testimonials extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * Testimonials constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    )
    {
        $this->_date = $date;
        parent::__construct($context);
    }

    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('manugentoo_testimonials', 'testimonial_id');
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }
        return parent::_beforeSave($object);
    }

}