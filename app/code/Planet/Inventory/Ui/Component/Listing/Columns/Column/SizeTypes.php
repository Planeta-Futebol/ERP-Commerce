<?php

namespace Planet\Inventory\Ui\Component\Listing\Columns\Column;

class SizeTypes extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $_productRepository;
    protected $_stockRepository;
    protected $_attributeRepository;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\CatalogInventory\Api\StockStateInterface $stockRepository,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->localeCurrency = $localeCurrency;
        $this->storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_stockRepository = $stockRepository;
        $this->_attributeRepository = $attributeRepository;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource["data"]["items"] as & $item) {
            $_product = $this->_productRepository->getById($item['entity_id']);
            $_children = $_product->getTypeInstance()->getUsedProducts($_product);

            foreach ($_children as $child){
                $attibuteValue = $child->getResource()
                    ->getAttribute('tamanho_camisetas')
                    ->getFrontend()
                    ->getValue($child);

                if( strcasecmp(
                    explode('_', $fieldName)[1],$attibuteValue) === 0
                )
                {
                    $item[$fieldName] = $this->_stockRepository->getStockQty($child->getID());
                }
            }
        }

        return $dataSource;
    }
}