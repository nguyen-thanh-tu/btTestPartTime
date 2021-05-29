<?php

namespace Magenest\PartTime\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Magenest_PartTime::part_time_manager';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_PartTime::part_time_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('PartTime manager'));

        return $resultPage;
    }

}