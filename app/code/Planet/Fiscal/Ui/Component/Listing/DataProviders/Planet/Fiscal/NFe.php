<?php
namespace Planet\Fiscal\Ui\Component\Listing\DataProviders\Planet\Fiscal;

class NFe extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
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
