<?php

namespace Max\TestAttributes\Model;

use Max\TestAttributes\Model\ResourceModel\Product\Sold\CollectionFactory as SoldCollectionFactory;
use Max\TestAttributes\Model\ResourceModel\Product\Last\CollectionFactory as LastCollectionFactory;
use Max\TestAttributes\Api\SalesInformationInterface;

class SalesInformation implements SalesInformationInterface
{
    protected $orderStatus;
    protected $product_id;
    /**
     * @var Max\TestAttributes\Model\ResourceModel\Product\Sold\CollectionFactory
     */
    private $reportSoldCollectionFactory;
    /**
     * @var Max\TestAttributes\Model\ResourceModel\Product\Last\CollectionFactory
     */
    private $reportLastCollectionFactory;

    /**
     * SalesInformation constructor.
     * @param SoldCollectionFactory $reportSoldCollectionFactory
     * @param LastCollectionFactory $reportLastCollectionFactory
     * @param array $orderStatus
     * @param $product_id
     */
    public function __construct(
        SoldCollectionFactory $reportSoldCollectionFactory,
        LastCollectionFactory $reportLastCollectionFactory,
        array $orderStatus,
        $product_id
    ) {
        $this->product_id = $product_id;
        $this->reportSoldCollectionFactory = $reportSoldCollectionFactory;
        $this->reportLastCollectionFactory = $reportLastCollectionFactory;
        $this->orderStatus = $orderStatus;
    }

    /**
     * Get Sold Qty
     * @return int
     */
    public function getQty()
    {
        $SoldProducts = $this->reportSoldCollectionFactory->create();
        $SoldProductQty = $SoldProducts->addOrderedQty($this->orderStatus, $this->product_id);

        if (!$SoldProductQty->count()) {
            return 0;
        }

        $product = $SoldProductQty->getFirstItem();

        return (int)$product->getData('ordered_qty');
    }

    /**
     * Get Last ordered
     * @return string
     */
    public function getLastOrder()
    {
        $LastProducts = $this->reportLastCollectionFactory->create();
        $LastProductsDate = $LastProducts
            ->addLastOrdered($this->orderStatus, $this->product_id);

        if (!$LastProductsDate->count()) {
            return "";
        }

        $product = $LastProductsDate->getFirstItem();

        return $product->getData('created_at');
    }
}
