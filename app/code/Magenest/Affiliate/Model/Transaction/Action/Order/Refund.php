<?php


namespace Magenest\Affiliate\Model\Transaction\Action\Order;

use Magento\Framework\Phrase;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Creditmemo;
use Magenest\Affiliate\Model\Transaction\AbstractAction;
use Magenest\Affiliate\Model\Transaction\Status;
use Magenest\Affiliate\Model\Transaction\Type;

/**
 * Class Refund
 *
 * @package Magenest\Affiliate\Model\Transaction\Action\Order
 */
class Refund extends AbstractAction
{
    /**
     * @return float
     */
    public function getAmount()
    {
        return -(float)$this->getObject()->getCommissionAmount();
    }

    /**
     * @return int
     */
    public function getType()
    {
        return Type::COMMISSION;
    }

    /**
     * @param null $transaction
     *
     * @return Phrase
     */
    public function getTitle($transaction = null)
    {
        $param = $transaction === null
            ? '#' . $this->getOrder()->getIncrementId()
            : '#' . $transaction->getOrderIncrementId();

        return __('Taken back commission for refunding order %1', $param);
    }

    /**
     * @return array
     */
    public function prepareAction()
    {
        $order = $this->getOrder();

        $totalAmountHold = $this->transactionFactory->create()
            ->getCollection()
            ->addFieldToFilter('order_id', $order->getId())
            ->addFieldToFilter('status', Status::STATUS_HOLD)
            ->getFieldTotal();

        $transactionData = [
            'order_id'           => $order->getId(),
            'order_increment_id' => $order->getIncrementId(),
            'store_id'           => $order->getStoreId(),
            'campaign_id'        => $order->getAffiliateCampaigns(),
            'total_amount_hold'  => $totalAmountHold
        ];

        return $transactionData;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        $object = $this->getObject();
        if ($object instanceof Creditmemo) {
            $order = $object->getOrder();
        } else {
            $order = $object;
        }

        return $order;
    }

    /**
     * @return string
     */
    public function getAdditionContent()
    {
        $extraContent = $this->getExtraContent();
        $object       = $this->getObject();
        if ($object instanceof Creditmemo) {
            $extraContent['creditmemo_increment_id'] = $object->getIncrementId();
        }

        return $this->jsonHelper->jsonEncode($extraContent);
    }
}
