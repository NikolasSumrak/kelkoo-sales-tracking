<?php

namespace Sumrak\KelkooSalesTracking\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const CONFIG_ENABLED_XPATH = 'kelkoo_sales_tracking/general/enabled';
    const CONFIG_MERCHANT_ID_XPATH = 'kelkoo_sales_tracking/general/merchant_id';
    const CONFIG_COUNTRY_CODE_XPATH = 'kelkoo_sales_tracking/general/country_code';
    const CONFIG_DEFAULT_COUNTRY_CODE_XPATH = 'general/country/default';

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_ENABLED_XPATH,
            ScopeInterface::SCOPE_STORE
            ) && $this->getMerchantId();
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->scopeConfig->getValue(self::CONFIG_MERCHANT_ID_XPATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        $countryCode = $this->scopeConfig->getValue(self::CONFIG_COUNTRY_CODE_XPATH, ScopeInterface::SCOPE_STORE);
        if (empty($countryCode )) {
            $countryCode = $this->scopeConfig->getValue(self::CONFIG_DEFAULT_COUNTRY_CODE_XPATH, ScopeInterface::SCOPE_STORE);
        }
        return $countryCode;
    }
}
