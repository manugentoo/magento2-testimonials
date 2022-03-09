<?php

namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Index extends Action
{

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * Index constructor.
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(Context $context, PageFactory $resultPageFactory)
	{
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}

	/**
	 * @return Page|ResponseInterface|ResultInterface|void
	 */
	public function execute()
	{
		/** @var Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Manugentoo_Testimonials::parent');
		$resultPage->getConfig()->getTitle()->prepend((__('Manage Testimonials')));

		return $resultPage;
	}

}