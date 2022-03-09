<?php

namespace Infiniti\Testimonials\Block;

use Magento\Framework\View\Element\Template;
use Infiniti\Testimonials\Model\TestimonialsFactory;
use Infiniti\Testimonials\Model\ResourceModel\Testimonials\Collection as TestimonialsCollection;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @class ListTestimonials
 * @namespace Infiniti\Testimonials\Block
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

	public function __construct(
		Template\Context $context,
		TestimonialsFactory $testimonialsFactory,
		TestimonialsCollection $testimonialsCollection,
		array $data = []
	)
	{
		$this->testimonialsFactory = $testimonialsFactory;
		parent::__construct($context, $data);
		$this->testimonialsCollection = $testimonialsCollection;
	}

	/**
	 * @return \Magento\Framework\DataObject[]
	 */
	public function getTestimonials() {
		return $this->testimonialsCollection->addWithImageFilter()->radomize()->getItems();
	}

	/**
	 * @param $image
	 * @return string
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 */
	public function getTestimonialsImageUrl($image) {
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		return $mediaUrl . \Infiniti\Testimonials\Model\Testimonials::IMAGE_UPLOAD_DIR . $image;
	}

}