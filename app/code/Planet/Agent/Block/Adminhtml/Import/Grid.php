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
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_helper->getCollection());

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
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'name'=>'id'
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'name'=>'title'
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created Date'),
                'index' => 'created_at',
                'name'=>'created_at'
            ]
        );

        return parent::_prepareColumns();
    }
}