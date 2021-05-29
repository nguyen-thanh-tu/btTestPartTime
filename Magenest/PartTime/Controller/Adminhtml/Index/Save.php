<?php

namespace Magenest\PartTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magenest\PartTime\Model\PartTime;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magenest_PartTime::save';

    protected $dataProcessor;
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (empty($data['member_id'])) {
                $data['member_id'] = null;
            }

            // Init model and load by ID if exists
            $model = $this->_objectManager->create('Magenest\PartTime\Model\PartTime');
            $id = $this->getRequest()->getParam('member_id');
            if ($id) {
                $model->load($id);
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('parttime/index/edit', ['member_id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the image.'));
                $this->dataPersistor->clear('magenest_part_time');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('parttime/index/edit', ['member_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('parttime/index/index');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('magenest_part_time', $data);
            return $resultRedirect->setPath('parttime/index/edit', ['member_id' => $this->getRequest()->getParam('member_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('parttime/index/index');
    }
}
