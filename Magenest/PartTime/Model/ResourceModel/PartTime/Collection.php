<?php

namespace Magenest\PartTime\Model\ResourceModel\PartTime;

/* use required classes */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'member_id';

    public function _construct()
    {
        $this->_init('Magenest\PartTime\Model\PartTime', 'Magenest\PartTime\Model\ResourceModel\PartTime');
    }
}
