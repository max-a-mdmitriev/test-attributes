<?php

namespace Max\TestAttributes\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Max\TestAttributes\Api\SalesInformationInterfaceFactory;

class ProductGet
{
    /**
     * @var ProductExtensionFactory
     */
    private $extensionFactory;
    /**
     * @var SalesInformationInterfaceFactory
     */
    private $salesInformationFactory;

    /**
     * @param ProductExtensionFactory          $extensionFactory
     * @param SalesInformationInterfaceFactory $salesInformationFactory
     */
    public function __construct(
        ProductExtensionFactory $extensionFactory,
        SalesInformationInterfaceFactory $salesInformationFactory
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->salesInformationFactory = $salesInformationFactory;
    }
    /**
     * @param Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param Magento\Catalog\Api\Data\ProductInterface $entity
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes()?:$this->extensionFactory->create();
        $extensionAttributes->setSalesInformation(
            $this->salesInformationFactory->create(['product_id' => $entity->getId()])
        );
        return $entity;
    }
    /**
     * @param Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param Magento\Catalog\Api\Data\ProductInterface $entity
     */
    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes()?:$this->extensionFactory->create();
        $extensionAttributes->setSalesInformation(
            $this->salesInformationFactory->create(['product_id' => $entity->getId()])
        );
        return $entity;
    }
}
