<?php

namespace Manugentoo\Testimonials\Block\Adminhtml\Testimonials\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package Manugentoo\Testimonials\Block\Adminhtml\Testimonials\Edit
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
	/**
	 * @return array
	 */
	public function getButtonData()
	{
		$data = [];
		if ($this->getTestimonialId()) {
			$data = [
				'label' => __('Delete Testimonial'),
				'class' => 'delete',
				'on_click' => 'deleteConfirm(\'' . __(
						'Are you sure you want to do this?'
					) . '\', \'' . $this->getDeleteUrl() . '\')',
				'sort_order' => 20,
			];
		}
		return $data;
	}

	/**
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return $this->getUrl('*/*/delete', ['testimonial_id' => $this->getTestimonialId()]);
	}
}