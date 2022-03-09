<?php
namespace Manugentoo\Testimonials\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Testimonials
 * @package Manugentoo\Testimonials\Block\Adminhtml
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Testimonials extends Container
{
	/**
	 * @return void
	 */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_testimonials';
        $this->_blockGroup = 'Manugentoo Testimonials';
        $this->_headerText = __('Manage Testimonials');

        parent::_construct();

        if ($this->_isAllowedAction('Manugentoo_Testimonials::manage_save')) {
            $this->buttonList->update('add', 'label', __('Add Testimonials'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    /**
     * @param $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
