<?php

namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Manugentoo\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory;

/**
 * Class MassDelete
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 *
 */
class MassDelete extends Action
{
	/**
	 * @var Filter
	 */
	protected $filter;

	/**
	 * @var CollectionFactory
	 */
	protected $collectionFactory;

	/**
	 * @param Context $context
	 * @param Filter $filter
	 * @param CollectionFactory $collectionFactory
	 */
	public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
	{
		$this->filter = $filter;
		$this->collectionFactory = $collectionFactory;
		parent::__construct($context);
	}

	/**
	 * @return Redirect
	 * @throws LocalizedException
	 */
	public function execute()
	{
		$collection = $this->filter->getCollection($this->collectionFactory->create());

		$collectionSize = $collection->getSize();

		foreach ($collection as $testimonial) {
			$testimonial->delete();
		}

		$this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

		/** @var Redirect $resultRedirect */
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		return $resultRedirect->setPath('*/*/');
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Manugentoo_Testimonials::manage_delete');
	}
}
