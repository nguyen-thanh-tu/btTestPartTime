<?php

namespace Magenest\PartTime\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;
use Magenest\PartTime\Model\PartTimeFactory;

class GenericButton
{

    protected $context;
    protected $bannerFactory;

    public function __construct(
        Context $context,
        PartTimeFactory $PartTimeFactory
    )
    {
        $this->context = $context;
        $this->bannerFactory = $PartTimeFactory;
    }

    /**
     * Return Banner ID
     */
    public function getBannerId()
    {
        $id = $this->context->getRequest()->getParam('member_id');
        $banner = $this->bannerFactory->create()->load($id);
        if ($banner->getId())
            return $id;
        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
