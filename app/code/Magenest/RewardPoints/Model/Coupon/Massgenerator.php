<?php

namespace Magenest\RewardPoints\Model\Coupon;

/**
 * Class Massgenerator
 * @package Magenest\RewardPoints\Model\Coupon
 */
class Massgenerator extends \Magento\SalesRule\Model\Coupon\Massgenerator
{

    /**
     * @param $ruleId
     * @param $qty
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function generateCouponPool($ruleId, $qty)
    {
        $this->generatedCount = 0;
        $this->generatedCodes = [];
        $maxAttempts = $this->getMaxAttempts() ? $this->getMaxAttempts() : self::MAX_GENERATE_ATTEMPTS;
        $this->increaseLength();
        /** @var $coupon \Magento\SalesRule\Model\Coupon */
        $coupon = $this->couponFactory->create();
        $nowTimestamp = $this->dateTime->formatDate($this->date->gmtTimestamp());
        for ($i = 0; $i < $qty; $i++) {
            $attempt = 0;
            do {
                if ($attempt >= $maxAttempts) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('We cannot create the requested Coupon Qty. Please check your settings and try again.')
                    );
                }
                $code = $this->generateCode();
                ++$attempt;
            } while ($this->getResource()->exists($code));
            $expirationDate = $this->getToDate();
            if ($expirationDate instanceof \DateTime) {
                $expirationDate = $expirationDate->format('Y-m-d H:i:s');
            }
            $coupon->setId(null)
                ->setRuleId($ruleId)
                ->setUsageLimit($this->getUsesPerCoupon())
                ->setUsagePerCustomer($this->getUsagePerCustomer())
                ->setExpirationDate($expirationDate)
                ->setCreatedAt($nowTimestamp)
                ->setType(\Magento\SalesRule\Helper\Coupon::COUPON_TYPE_SPECIFIC_AUTOGENERATED)
                ->setCode($code)
                ->save();

            $this->generatedCount += 1;
            $this->generatedCodes[] = $code;
        }
        return $this->generatedCodes;
    }
}