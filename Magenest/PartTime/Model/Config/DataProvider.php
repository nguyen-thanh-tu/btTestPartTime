<?php

namespace Magenest\PartTime\Model\Config;

use Magenest\PartTime\Model\ResourceModel\PartTime\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $CollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        foreach ($items as $member) {
            $data = $member->getData();

            $this->loadedData[$member->getId()] = $data;
        }

        $data = $this->dataPersistor->get('magenest_part_time');
        if (!empty($data)) {
            $member = $this->collection->getNewEmptyItem();
            $member->setData($data);
            $this->loadedData[$member->getId()] = $member->getData();
            $this->dataPersistor->clear('magenest_part_time');
        }

        return $this->loadedData;
    }
}
