<?php

namespace Magenest\PartTime\Model;

class PartTime extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magenest\PartTime\Model\ResourceModel\PartTime');
    }

    public function getConnect(){
        return $this->getResourceCollection()->getConnection();
    }

    public function getTable(){
        return $this->getConnect()->getTableName('magenest_part_time');
    }
    public function getAll(){
        return $this->getConnect()->fetchAll("SELECT * FROM magenest_part_time");
    }
    public function getAllbyId($member_id){
        return $this->getConnect()->fetchAll("SELECT * FROM magenest_part_time where member_id = $member_id ");
    }
    public function setAll($name,$address,$phone){
        $data = [
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ]
        ];
        foreach ($data as $item) {
            $this->getConnect()->insert($this->getTable(),$item);
        }
    }
    public function updateAllbyId($member_id,$name,$address,$phone){
        $data = [
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ]
        ];
        foreach ($data as $item) {
            return $this->getConnect()->update($this->getTable(),$item,['member_id = ?' => (int)$member_id]);
        }
    }
}