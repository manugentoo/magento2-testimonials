<?php
namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

/**
 * Class Delete
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Delete extends \Magento\Backend\App\Action
{

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Manugentoo_Testimonials::manage_delete');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('testimonial_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Manugentoo\Testimonials\Model\Testimonials::class);
                $model->load($id);
                $title = $model->getName();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The testimonial has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch(
                    'adminhtml_testimonials_on_delete',
                    ['title' => $title, 'status' => 'success']
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_testimonials_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['testimonial_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a testimonial to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
