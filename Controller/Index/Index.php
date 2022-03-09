<?php
namespace Manugentoo\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Manugentoo\Testimonials\Controller\Index
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Index extends Action
{
	/**
	 * @var PageFactory
	 */
	protected $_pageFactory;

	/**
	 * @param Context $context
	 * @param PageFactory $pageFactory
	 */
	public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

	/**
	 * @return ResponseInterface|ResultInterface|Page
	 */
	public function execute()
    {
        return $this->_pageFactory->create();
    }
}