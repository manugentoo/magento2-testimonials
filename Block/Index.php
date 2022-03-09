<?php

namespace Manugentoo\Testimonials\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials\Collection;
use Manugentoo\Testimonials\Model\TestimonialsFactory;
use Manugentoo\Testimonials\Api\Data\TestimonialInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

/**
 * Class Index
 * @package Manugentoo\Testimonials\Block
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Index extends Template
{
	/**
	 * @var string
	 */
	const BASE_IMAGE_PATH = "manugentoo/testimonials/images";

	/**
	 * @var TestimonialsFactory
	 */
	protected $testimonialsFactory;
	/**
	 * @var StoreManagerInterface
	 */
	protected $storeManager;

	/**
	 * @param Template\Context $context
	 * @param TestimonialsFactory $testimonialsFactory
	 * @param StoreManagerInterface $storeManager
	 * @param array $data
	 */
	public function __construct(
		Template\Context $context,
		TestimonialsFactory $testimonialsFactory,
		StoreManagerInterface $storeManager,
		array $data = []
	) {
		$this->testimonialsFactory = $testimonialsFactory;
		$this->storeManager = $storeManager;
		parent::__construct($context, $data);
	}

	/**
	 * @return Collection
	 */
	public function getTestimonials()
	{
		return $this->testimonialsFactory->create()->getCollection();
	}

	/**
	 * @param TestimonialInterface $testimonial
	 * @return string|null
	 * @throws NoSuchEntityException
	 */
	public function getImageUrl(TestimonialInterface $testimonial)
	{
		if ($image = $testimonial->getCompanyImage()) {
			return $this->storeManager->getStore()
					->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . self::BASE_IMAGE_PATH . $image;
		}

		return null;
	}
}