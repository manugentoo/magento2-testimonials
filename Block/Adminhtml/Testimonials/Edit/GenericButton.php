<?php
namespace Manugentoo\Testimonials\Block\Adminhtml\Testimonials\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Infiniti\Testimonials\Api\TestimonialsRepositoryInterface;

/**
 * Class GenericButton
 * @package Manugentoo\Testimonials\Block\Adminhtml\Testimonials\Edit
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var TestimonialsRepositoryInterface
     */
    protected $testimonialsRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param TestimonialsRepositoryInterface $testimonialsRepository
     */
    public function __construct(
        Context $context,
        TestimonialsRepositoryInterface $testimonialsRepository
    ) {
        $this->context = $context;
        $this->testimonialsRepository = $testimonialsRepository;
    }

    /**
     * @return |null
     */
    public function getTestimonialId()
    {
        try {
            return $this->testimonialsRepository->getById(
                $this->context->getRequest()->getParam('testimonial_id')
            )->getId();
        } catch (NoSuchEntityException $e) {

        }
        return null;
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}