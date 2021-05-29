<?php

namespace Magenest\PartTime\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class CustomerRegisterSuccess implements ObserverInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    public function execute(EventObserver $observer)
    {
        $data = $observer->getData("customer");
        $address = $data->getEmail();
        $name = $data->getFirstname()." ".$data->getMiddlename()." ".$data->getLastname();
        $phone = 111111111;
        $colection = $this->objectManager->create("Magenest\PartTime\Model\PartTime");
        return $colection->setAll($name,$address,$phone);
    }
}
