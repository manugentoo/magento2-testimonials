<?php

namespace Manugentoo\Testimonials\Api\Data;

/**
 * Interface TestimonialInterface
 * @package Manugentoo\Testimonials\Api\Data
 */
interface TestimonialInterface {


	const TABLE_NAME = 'manugentoo_testimonials';

    const TESTIMONIAL_ID = 'testimonial_id';

    const NAME = 'name';

    const COMPANY_NAME = 'company_name';

    const COMPANY_IMAGE = 'company_image';

    const COMMENT = 'comment';

    const CREATED_AT = 'created_at';

	const UPLOAD_DIR = 'testimonial';

    /**
     * @return int
     */
    public function getTestimonialId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @return string
     */
    public function getCompanyImage();

    /**
     * @return string
     */
    public function getComment();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param $testimonialId
     * @return TestimonialInterface
     */
    public function setTestimonialId($testimonialId);

    /**
     * @param $name
     * @return TestimonialInterface
     */
    public function setName($name);

    /**
     * @param $companyName
     * @return TestimonialInterface
     */
    public function setCompanyName($companyName);

    /**
     * @param $companyImage
     * @return TestimonialInterface
     */
    public function setCompanyImage($companyImage);

    /**
     * @param $comment
     * @return TestimonialInterface
     */
    public function setComment($comment);

    /**
     * @param $createdAt
     * @return TestimonialInterface
     */
    public function setCreatedAt($createdAt);

}