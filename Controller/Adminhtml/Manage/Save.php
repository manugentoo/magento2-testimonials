<?php
namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Manugentoo\Testimonials\Model\Testimonials;

/**
 * Class Save
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Save extends \Magento\Backend\App\Action
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var mixed
     */
    protected $testimonialsFactory;

    /**
     * @var mixed
     */
    protected  $testimonialRepository;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Manugentoo\Testimonials\Model\TestimonialsFactory|null $testimonialsFactory
     * @param \Manugentoo\Testimonials\Api\TestimonialsRepositoryInterface|null $testimonialRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Manugentoo\Testimonials\Model\TestimonialsFactory $testimonialsFactory = null,
        \Manugentoo\Testimonials\Api\TestimonialsRepositoryInterface $testimonialRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->testimonialsFactory = $testimonialsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Manugentoo\Testimonials\Model\TestimonialsFactory::class);
        $this->testimonialRepository = $testimonialRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Manugentoo\Testimonials\Api\TestimonialsRepositoryInterface::class);
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
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {

            if (empty($data['testimonial_id'])) {
                $data['testimonial_id'] = null;
            }

            /** @var \Manugentoo\Testimonials\Model\Testimonials $model */
            $model = $this->testimonialsFactory->create();

            $id = $this->getRequest()->getParam('testimonial_id');
            if ($id) {
                try {
                    $model = $this->testimonialRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This testimonial no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            // fix image file name before setting the data to model
            if(isset($data[Testimonials::COMPANY_IMAGE][0]['file'])) {
                $image = $data[Testimonials::COMPANY_IMAGE][0];
                $data[Testimonials::COMPANY_IMAGE] = $image['file'];
            }
            else {
                $data[Testimonials::COMPANY_IMAGE] = null;
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'testimonials_prepare_save',
                ['testimonial' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->testimonialRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the testimonial.'));
                $this->dataPersistor->clear('manugentoo_testimonial');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['testimonial_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the testimonial.'));
            }

            $this->dataPersistor->set('manugentoo_testimonial', $data);
            $this->dataPersistor->set('manugentoo_testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['testimonial_id' => $this->getRequest()->getParam('testimonial_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}