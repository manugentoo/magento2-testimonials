<?php

namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Manugentoo\Testimonials\Model\Testimonials;

/**
 * Class Edit
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Edit extends Action
{

	/**
	 * @var Registry
	 */
	protected $_coreRegistry;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * Edit constructor.
	 * @param Action\Context $context
	 * @param PageFactory $resultPageFactory
	 * @param Registry $registry
	 */
	public function __construct(
		Action\Context $context,
		PageFactory $resultPageFactory,
		Registry $registry
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		parent::__construct($context);
	}

	/**
	 * @return ResponseInterface|Redirect|ResultInterface|Page
	 */
	public function execute()
	{
		// 1. Get ID and create model
		$id = $this->getRequest()->getParam('testimonial_id');
		$model = $this->_objectManager->create(Testimonials::class);

		// 2. Initial checking
		if ($id) {
			$model->load($id);


			if (!$model->getId()) {
				$this->messageManager->addError(__('This testimonial no longer exists.'));
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('*/*/');
			}
		}

		$this->_coreRegistry->register('manugentoo_testimonials', $model);

		// 5. Build edit form
		$resultPage = $this->_initAction();
		$resultPage->addBreadcrumb(
			$id ? __('Edit Testimonials') : __('Add Testimonials'),
			$id ? __('Edit Testimonials') : __('Add Testimonials')
		);
		$resultPage->getConfig()->getTitle()->prepend(__('Testimonials'));
		$resultPage->getConfig()->getTitle()
			->prepend($model->getId() ? $model->getTitle() : __('Add Testimonials'));

		return $resultPage;
	}

	/**
	 * @return Page
	 */
	protected function _initAction()
	{
		// load layout, set active menu and breadcrumbs
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Manugentoo_Testimonials::manage_index')
			->addBreadcrumb(__('Manugentoo Testimoinals'), __('Testimoinals'))
			->addBreadcrumb(__('Manage All Testimonials'), __('All'));
		return $resultPage;
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Manugentoo_Testimonials::manage_save');
	}
}