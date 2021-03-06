<?php
/**
 * Copyright © Magenest JSC. All rights reserved.
 *
 * Created by PhpStorm.
 * User: crist
 * Date: 29/10/2021
 * Time: 10:53
 */

namespace Magenest\AffiliateCatalogRule\Pricing\Price;


use Magento\Catalog\Model\Product;
use Magenest\AffiliateCatalogRule\Model\ResourceModel\AffiliateRule;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\Adjustment\Calculator;
use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\StoreManagerInterface;

class OriginRulePrice extends AbstractPrice
{
    /**
     * Price type identifier string
     */
    const PRICE_CODE = 'original_catalog_rule_price';

    /**
     * @var TimezoneInterface
     */
    protected $dateTime;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var AffiliateRule
     */
    protected $ruleResource;

    /**
     * @param Product $saleableItem
     * @param float $quantity
     * @param Calculator $calculator
     * @param PriceCurrencyInterface $priceCurrency
     * @param TimezoneInterface $dateTime
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param AffiliateRule $ruleResource
     */
    public function __construct(
        Product $saleableItem,
        $quantity,
        Calculator $calculator,
        PriceCurrencyInterface $priceCurrency,
        TimezoneInterface $dateTime,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        AffiliateRule $ruleResource
    ) {
        parent::__construct($saleableItem, $quantity, $calculator, $priceCurrency);
        $this->dateTime = $dateTime;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->ruleResource = $ruleResource;
    }

    /**
     * Returns catalog rule value
     *
     * @return float|boolean
     */
    public function getValue()
    {
        if (null === $this->value) {
            if ($this->product->hasData(self::PRICE_CODE)) {
                $value = $this->product->getData(self::PRICE_CODE);
                $this->value = $value ? (float)$value : false;
            } else {
                $this->value = $this->ruleResource->getRulePrice(
                    $this->dateTime->scopeDate($this->storeManager->getStore()->getId()),
                    $this->storeManager->getStore()->getWebsiteId(),
                    $this->customerSession->getCustomerGroupId(),
                    $this->product->getId()
                );
                $this->value = $this->value ? (float)$this->value : false;
            }
            if ($this->value) {
                $this->value = $this->priceCurrency->convertAndRound($this->value);
            }
        }

        return $this->value;
    }
}
