<?php
namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Edit extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Manugentoo_Testimonials::manage_save');
    }

    /**
     * @return \Magento\Framework\View\Result\Page
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
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('testimonial_id');
        $model = $this->_objectManager->create(\Manugentoo\Testimonials\Model\Testimonials::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $logger = $objectManager->create(\Psr\Log\LoggerInterface::class);
            $logger->debug("DEBUGGG " . $model->getCompanyImage());


            if (!$model->getId()) {
                $this->messageManager->addError(__('This testimonial no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
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
}