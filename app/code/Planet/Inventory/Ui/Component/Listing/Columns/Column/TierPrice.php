<?php

namespace Planet\Inventory\Ui\Component\Listing\Columns\Column;


class TierPrice extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'column.price';

    /**
     * @var \Magento\Framework\Locale\CurrencyInterface
     */
    protected $localeCurrency;

    protected $_productRepository;
    protected $_stockRepository;
    protected $_attributeRepository;
    protected $_groupCollection;


    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\CatalogInventory\Api\StockStateInterface $stockRepository,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository,
        \Magento\Customer\Model\ResourceModel\Group\Collection $groupCollection,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->localeCurrency = $localeCurrency;
        $this->storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_stockRepository = $stockRepository;
        $this->_attributeRepository = $attributeRepository;
        $this->_groupCollection = $groupCollection;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');



        foreach ($dataSource["data"]["items"] as &$item) {
            $_product = $this->_productRepository->getById($item['entity_id']);

            /** @var \Magento\Catalog\Model\Product $_child */
            $_child = $_product->getTypeInstance()->getUsedProducts($_product)[0];


            $groupId = 0;

            foreach ($this->_groupCollection->toArray()['items'] as $itemGroup) {
                if(strcasecmp(
                    explode('_', $fieldName)[1],
                    $itemGroup['customer_group_code']) === 0 )
                {
                    $groupId = $itemGroup['customer_group_id'];
                }
            }

            /** @var \Magento\Catalog\Api\Data\ProductTierPriceInterface $tierPrice */
            foreach($_child->getTierPrices() as $tierPrice){

                if($tierPrice->getCustomerGroupId() === $groupId){
                    $store = $this->storeManager->getStore(
                        $this->context->getFilterParam('store_id', \Magento\Store\Model\Store::DEFAULT_STORE_ID)
                    );

                    $currency = $this->localeCurrency->getCurrency($store->getBaseCurrencyCode());
                    $item[$fieldName] = $currency->toCurrency(sprintf("%f", $tierPrice->getValue()));
                }
            }
        }

        return $dataSource;
    }
}