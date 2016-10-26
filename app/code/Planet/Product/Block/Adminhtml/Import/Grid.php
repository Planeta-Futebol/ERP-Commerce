<?php

namespace Planet\Product\Block\Adminhtml\Import;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    /**
     * @var \Planet\Agent\Helper\Data
     *
     */
    protected $_helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Planet\Agent\Helper\Data $helper,
        array $data = []
    ) {
        $this->_helper = $helper;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->setId('importGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setVarNameFilter('import_filter');

        $this->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        // products collection
        $collection = $this->_helper->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'sku',
            [
                'header' => __('sku'),
                'index'  => 'sku',
                'name'   => 'sku',
                'filter'   => false,
                'sortable' => false,
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'product_name',
            [
                'header' => __('Product Name'),
                'index'  => 'product_name',
                'name'   => 'Product Name',
                'filter'   => false,
                'sortable' => false
            ]
        );

        $this->addColumn(
            'quantity',
            [
                'header' => __('Quantity'),
                'index'  => 'quantity',
                'name'   => 'quantity',
                'filter'   => false,
                'sortable' => false,
            ]
        );

        $this->addColumn(
            'stock',
            [
                'header' => __('Stock'),
                'index'  => 'stock',
                'name'   => 'stock',
                'filter'   => false,
                'sortable' => false
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'index'  => 'price',
                'name'   => 'price',
                'filter'   => false,
                'sortable' => false
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Define current action for lines of grid.
     *
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\DataObject $item
     * @return bool
     */
    public function getRowUrl($item)
    {
        return false;
    }
}