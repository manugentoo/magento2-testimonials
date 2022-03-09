<?php

namespace Manugentoo\Testimonials\Model;

use Manugentoo\Testimonials\Api\Data\TestimonialInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Testimonials
 * @package Manugentoo\Testimonials\Model
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Testimonials extends AbstractModel implements TestimonialInterface, IdentityInterface
{

	const CACHE_TAG = 'testimonials';
	const IMAGE_UPLOAD_DIR = 'Manugentoo/testimonials/images/';

	/**
	 * @var string
	 */
	protected $_cacheTag = self::CACHE_TAG;

	/**
	 * Object constructor
	 */
	public function _construct()
	{
		$this->_init(ResourceModel\Testimonials::class);
	}

	/**
	 * @return string|string[]
	 */
	public function getIdentities()
	{
		// return [self::CACHE_TAG] . $this->getTestimonialId();
	}

	/**
	 * @return array
	 */
	public function getDefaultValues()
	{
		$values = [];
		return $values;
	}

	/**
	 * @return mixed
	 */
	public function getTestimonialId()
	{
		return $this->getData(self::TESTIMONIAL_ID);
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->getData(self::NAME);
	}

	/**
	 * @return mixed
	 */
	public function getCompanyName()
	{
		return $this->getData(self::COMPANY_NAME);
	}

	/**
	 * @return mixed
	 */
	public function getCompanyImage()
	{
		return $this->getData(self::COMPANY_IMAGE);
	}

	/**
	 * @return mixed
	 */
	public function getComment()
	{
		return $this->getData(self::COMMENT);
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->getData(self::CREATED_AT);
	}

	/**
	 * @param $testimonialId
	 * @return Testimonials
	 */
	public function setTestimonialId($testimonialId)
	{
		return $this->setData(self::TESTIMONIAL_ID, $testimonialId);
	}

	/**
	 * @param $name
	 * @return Testimonials
	 */
	public function setName($name)
	{
		return $this->setData(self::NAME, $name);
	}

	/**
	 * @param $companyName
	 * @return Testimonials
	 */
	public function setCompanyName($companyName)
	{
		return $this->setData(self::COMPANY_NAME, $companyName);
	}

	/**
	 * @param $companyImage
	 * @return Testimonials
	 */
	public function setCompanyImage($companyImage)
	{
		return $this->setData(self::COMPANY_IMAGE, $companyImage);
	}

	/**
	 * @param $comment
	 * @return Testimonials
	 */
	public function setComment($comment)
	{
		return $this->setData(self::COMMENT, $comment);
	}

	/**
	 * @param $createdAt
	 * @return Testimonials
	 */
	public function setCreatedAt($createdAt)
	{
		return $this->setData(self::CREATED_AT, $createdAt);
	}
}