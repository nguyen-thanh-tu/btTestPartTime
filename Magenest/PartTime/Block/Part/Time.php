<?php

namespace Magenest\PartTime\Block\Part;

use Magento\Framework\View\Element\Template;
use Magento\Framework\ObjectManagerInterface;

class Time extends \Magento\Framework\View\Element\Template
{
    private $_objectManager;
    protected $storeManager;
    protected $urlInterface;

    public function __construct(
        Template\Context $context,
        ObjectManagerInterface $_objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlInterface,
        array $data = []
    )
    {
        $this->_objectManager = $_objectManager;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        parent::__construct($context, $data);
    }
    public function data(){
        return $this->_objectManager->create('Magenest\PartTime\Model\PartTime');
    }
    public function getCurrentStore()
    {
        return $this->_storeManager->getStore();
    }
    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (!empty($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'on') {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    public function getMemberId(){
        $id = (int)str_replace($this->getCurrentStore()->getUrl("parttime/part/time/").'member_id/',"",$this->getCurrentPageURL());
        return $id;
    }
    public function getDataTable()
    {
        $partTime = $this->data();
        $data = $partTime->getAll();
        $string = "";
        foreach($data as $value){
            $string = $string .
                "<tr>
                    <td>".$value["name"]."</td>
                    <td>".$value["address"]."</td>
                    <td>".$value["phone"]."</td>
                    <td><a href="."/parttime/part/time/member_id/".$value["member_id"].">Edit</ahref></td>
                </tr>";
        }
        return __($string);
    }
    public function getdataOfId()
    {
        $partTime = $this->data();
        $dataOfId = $partTime->getAllbyId($this->getMemberId());
        return $dataOfId[0];
    }

    public function getPhone()
    {
        $data = $this->getdataOfId();
        return $data["phone"];
    }
    public function getName()
    {
        $data = $this->getdataOfId();
        return $data["name"];
    }
    public function getAddress()
    {
        $data = $this->getdataOfId();
        return $data["address"];
    }
}

