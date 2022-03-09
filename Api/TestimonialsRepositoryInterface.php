<?php

namespace Manugentoo\Testimonials\Api;

use Manugentoo\Testimonials\Api\Data\TestimonialInterface;

/**
 * Interface TestimonialsRepositoryInterface
 * @package Manugentoo\Testimonials\Api
 */
interface TestimonialsRepositoryInterface
{
    /**
     * @param Data\TestimonialInterface $testimonial
     * @return mixed
     */
    public function save(TestimonialInterface $testimonial);

    /**
     * @param $testimonialId
     * @return mixed
     */
    public function getById($testimonialId);

    /**
     * @param Data\TestimonialInterface $testimonial
     * @return mixed
     */
    public function delete(TestimonialInterface $testimonial);

    /**
     * @param $testimonialId
     * @return mixed
     */
    public function deleteById($testimonialId);
}