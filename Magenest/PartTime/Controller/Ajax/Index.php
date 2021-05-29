<?php

namespace Magenest\PartTime\Controller\Ajax;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $json;
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //lấy dữ liệu từ ajax gửi sang
        $response = $this->getRequest()->getParams();
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $partTime = $this->_objectManager->create('Magenest\PartTime\Model\PartTime');
        $partTime->updateAllbyId($response["member_id"],$response["name"],$response["address"],$response["phone"]);
        // chuyển kết quả về dạng object json và trả về cho ajax
        return $resultJson->setData($response);
    }
}
