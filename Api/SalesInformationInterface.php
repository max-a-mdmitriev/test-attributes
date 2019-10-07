<?php

namespace Max\TestAttributes\Api;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SalesInformationInterface extends ExtensibleDataInterface
{
    /**
     * Retrieve product sold qty
     *
     * @return int
     */
    public function getQty();
    /**
     * Retrieve product last ordered date
     *
     * @return string
     */
    public function getLastOrder();
}
