<?php

namespace Magenest\PartTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magenest_PartTime::save';

    protected $_coreRegistry;
    protected $resultPageFactory;

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
     * Load layout and set active menu
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_PartTime::part_time_manager');
        return $resultPage;
    }

    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('member_id');
        $model = $this->_objectManager->create('Magenest\PartTime\Model\PartTime');

        // Initial checking
        if ($id) {
            $model->load($id);

            // If cannot get ID of model, display error message and redirect to List page
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Delivery Time no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('parttime/index/index');
            }
        }

        // Registry banner
        $this->_coreRegistry->register('magenest_part_time', $model);

        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? __('Edit Customer '.$model->getId()) : __('Create Member')); // title

        return $resultPage;
    }
}
