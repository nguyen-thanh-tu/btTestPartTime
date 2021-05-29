<?php
namespace Magenest\PartTime\Model\Checkout\Cart;
use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Framework\Exception\LocalizedException;

class Plugin
{
    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote;
    protected $scopeConfig;

    const PRODUCT_NAME = "member_config/part_time/product_name";

    /**
     * Plugin constructor.
     *
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->quote = $checkoutSession->getQuote();
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * beforeAddProduct
     *
     * @param      $subject
     * @param      $productInfo
     * @param null $requestInfo
     *
     * @return array
     * @throws LocalizedException
     */
    public function beforeAddProduct($subject, $productInfo, $requestInfo = null)
    {
        $product_name = $this->scopeConfig->getvalue(self::PRODUCT_NAME);
        if ($productInfo->getData("name") !== $product_name) {
            throw new LocalizedException(__('Could not add Product to Cart'));
        }

        return [$productInfo, $requestInfo];
    }
}
