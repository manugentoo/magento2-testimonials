<?php

namespace Manugentoo\Testimonials\Model;

use Manugentoo\Testimonials\Api\Data;
use Manugentoo\Testimonials\Api\TestimonialsRepositoryInterface;
use Manugentoo\Testimonials\Model\TestimonialsFactory;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials as ResourceTestimonials;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

/**
 * Class TestimonialsRepository
 * @package Manugentoo\Testimonials\ModelRes
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class TestimonialsRepository implements TestimonialsRepositoryInterface
{

    /**
     * @var ResourceTestimonials
     */
    protected $resource;
    /**
     * @var TestimonialsFactory
     */
    protected $testimonialsFactory;
    /**
     * @var Data\TestimonialInterface
     */
    protected $dataTestimonialsFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjecProcessor;

    /**
     * TestimonialsRepository constructor.
     * @param ResourceTestimonials $resource
     * @param TestimonialsFactory $testimonialsFactory
     * @param Data\TestimonialInterface $dataTestimonialsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct (
        ResourceTestimonials $resource,
        TestimonialsFactory $testimonialsFactory,
        Data\TestimonialInterface $dataTestimonialsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->testimonialsFactory = $testimonialsFactory;
        $this->dataTestimonialsFactory = $dataTestimonialsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjecProcessor = $dataObjectProcessor;
    }

    /**
     * @param Data\TestimonialInterface $testimonial
     * @return mixed|void
     * @throws CouldNotSaveException
     */
    public function save(Data\TestimonialInterface $testimonial)
    {
       try {
           $this->resource->save($testimonial);
       }
       catch (\Exception $exception) {
           throw new CouldNotSaveException(
               __('Could now save the testimonial: $%1', $exception->getMessage()),
               $exception
           );
       }
    }

    /**
     * @param $testimonialId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialsFactory->create();
        $testimonial->load($testimonialId);

        if(!$testimonial->getTestimonialId()) {
            throw new NoSuchEntityException(
                __('Testimonial with %1 does not exists. $%1',$testimonialId)
            );
        }
        return $testimonial;
    }

    /**
     * @param Data\TestimonialInterface $testimonial
     * @return mixed|void
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TestimonialInterface $testimonial)
    {
        try {
            $this->resource->delete($testimonial);
        }
        catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could now delete the testimonial: $%1', $exception->getMessage()),
                $exception
            );
        }
    }

    /**
     * @param $testimonialId
     * @return mixed|void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($testimonialId)
    {
        $this->delete($this->getById($testimonialId));
    }
}