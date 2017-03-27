<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Ui\Component\Listing\DataProviders\Planet\Fiscal;

/**
 * Class NFe
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class NFe extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Planet\Fiscal\Model\ResourceModel\Order\Grid\CollectionFactory $collectionFactory
     * @param \Planet\Fiscal\Model\ResourceModel\NFe\CollectionFactory $nfeCollection
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Planet\Fiscal\Model\ResourceModel\Order\Grid\CollectionFactory $collectionFactory,
        \Planet\Fiscal\Model\ResourceModel\NFe\CollectionFactory $nfeCollection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create()
            ->addFieldToFilter('entity_id', [
                'nin' => $nfeCollection->create()->getAllOrderIds()
            ]);
    }
}
