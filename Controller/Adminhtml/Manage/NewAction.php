<?php

namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class NewAction extends Action
{

	/**
	 * @var ForwardFactory
	 */
	protected $resultForwardFactory;

	/**
	 * @param Context $context
	 * @param ForwardFactory $resultForwardFactory
	 */
	public function __construct(
		Context $context,
		ForwardFactory $resultForwardFactory
	) {
		$this->resultForwardFactory = $resultForwardFactory;
		parent::__construct($context);
	}

	/**
	 * @return Forward|ResponseInterface|ResultInterface
	 */
	public function execute()
	{
		/** @var Forward $resultForward */
		$resultForward = $this->resultForwardFactory->create();
		return $resultForward->forward('edit');
	}

	/**
	 * @return mixed
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Manugentoo_Testimonials::manage_save');
	}

}