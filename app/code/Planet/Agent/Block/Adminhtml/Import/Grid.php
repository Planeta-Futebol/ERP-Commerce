<?php
namespace Planet\Agent\Block\Adminhtml\Import;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Module\Manager;
use Planet\Agent\Helper\Data as ImportData;

class Grid extends Extended
{
    /**
     * @var Manager
     */
    protected $moduleManager;

    protected $_helper;

    public function __construct(
        Context $context,
        Data $backendHelper,
        Manager $moduleManager,
        ImportData $helper,
        array $data = []
    ) {
        $this->moduleManager = $moduleManager;
        $this->_helper = $helper;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('importGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setVarNameFilter('import_filter');

        $this->setFilterVisibility(false);
        $this->setDefaultLimit(100);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_helper->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
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

//                'editable'  => true,
//                'edit_only' => true,
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
//                'renderer' => '\Magento\Framework\Pricing\Render',

                'filter'   => false,
                'sortable' => false
            ]
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($item)
    {
        return false;
    }
}