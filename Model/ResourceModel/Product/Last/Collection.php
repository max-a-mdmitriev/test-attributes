<?php

namespace Max\TestAttributes\Model\ResourceModel\Product\Last;

use Magento\Sales\Model\Order;

class Collection extends \Magento\Reports\Model\ResourceModel\Order\Collection
{
    /**
     * Add last ordered day
     *
     * @param array $status
     * @param int $product_id
     * @return $this
     */
    public function addLastOrdered($status, $product_id)
    {
        $connection = $this->getConnection();
        $orderTableAliasName = $connection->quoteIdentifier('order');

        if (is_array($status)) {
            $orderJoinCondition = [
                $orderTableAliasName . '.entity_id = order_items.order_id',
                $connection->quoteInto("{$orderTableAliasName}.state in (?)", $status),
            ];
        } else {
            $orderJoinCondition = [
                $orderTableAliasName . '.entity_id = order_items.order_id',
                $connection->quoteInto("{$orderTableAliasName}.state <> ?", Order::STATE_CANCELED),
            ];
        }

        $this->getSelect()->reset()->from(
            ['order_items' => $this->getTable('sales_order_item')],
            [
                'ordered_qty' => 'order_items.qty_ordered',
                'order_items_name' => 'order_items.name',
                'order_items_sku' => 'order_items.sku'
            ]
        )->joinInner(
            ['order' => $this->getTable('sales_order')],
            implode(' AND ', $orderJoinCondition),
            ['created_at']
        )->where(
            'order_items.qty_ordered > ?',
            0
        )->where(
            'order_items.product_id = ?',
            $product_id
        )->order(
            'order.created_at '  . Collection::SORT_ORDER_DESC
        )->limit(1);
        return $this;
    }
}
