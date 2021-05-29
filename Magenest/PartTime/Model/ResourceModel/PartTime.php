<?php

namespace Magenest\PartTime\Model\ResourceModel;

class PartTime extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('magenest_part_time', 'member_id');
    }
}
