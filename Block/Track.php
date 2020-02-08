<?php

namespace Sumrak\KelkooSalesTracking\Block;

use Sumrak\KelkooSalesTracking\Helper\Config;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order\Item;

class Track extends Template
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Sales\Model\Order
     */
    private $order;

    /**
     * @var Config
     */
    private $configHelper;

    /**
     * Track constructor.
     * @param Context $context
     * @param Session $checkoutSession
     * @param Config $configHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        Config $configHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->configHelper = $configHelper;
    }

    /**
     * @return bool
     */
    public function canShowBlock()
    {
        return $this->configHelper->isEnabled();
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->configHelper->getCountryCode();
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->configHelper->getMerchantId();
    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            $this->order = $this->checkoutSession->getLastRealOrder();
        }
        return $this->order;
    }

    /**
     * @return string|false
     */
    public function getQuoteDataJson()
    {
        $order = $this->getOrder();
        $quoteData = [];

        /** @var Item $item */
        foreach ($order->getAllVisibleItems() as $item) {
            $quoteData[] = [
                'productname' => $item->getName(),
                'productid' => $item->getProductId(),
                'quantity' => $item->getQtyOrdered(),
                'price' => $item->getPrice()
            ];
        }

        return json_encode($quoteData);
    }
}
