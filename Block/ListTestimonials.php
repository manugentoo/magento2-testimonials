<?php

namespace Manugentoo\Testimonials\Block;

use Manugentoo\Testimonials\Model\Testimonials;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Manugentoo\Testimonials\Model\TestimonialsFactory;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials\Collection as TestimonialsCollection;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ListTestimonials
 * @package Manugentoo\Testimonials\Block
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class ListTestimonials extends Template
{
	/**
	 * @var TestimonialsCollection
	 */
	private $testimonialsCollection;
	/**
	 * @var StoreManagerInterface
	 */
	private $storeManager;

	/**
	 * @param Template\Context $context
	 * @param TestimonialsFactory $testimonialsFactory
	 * @param TestimonialsCollection $testimonialsCollection
	 * @param array $data
	 */
	public function __construct(
		Template\Context $context,
		TestimonialsFactory $testimonialsFactory,
		TestimonialsCollection $testimonialsCollection,
		array $data = []
	) {
		$this->testimonialsFactory = $testimonialsFactory;
		parent::__construct($context, $data);
		$this->testimonialsCollection = $testimonialsCollection;
	}

	/**
	 * @return \Magento\Framework\DataObject[]
	 */
	public function getTestimonials()
	{
		return $this->testimonialsCollection->addWithImageFilter()->radomize()->getItems();
	}

	/**
	 * @param $image
	 * @return string
	 * @throws NoSuchEntityException
	 */
	public function getTestimonialsImageUrl($image)
	{
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
		return $mediaUrl . Testimonials::IMAGE_UPLOAD_DIR . $image;
	}

}