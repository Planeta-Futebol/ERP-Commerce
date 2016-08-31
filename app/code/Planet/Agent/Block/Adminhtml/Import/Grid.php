<?php
namespace Planet\Agent\Block\Adminhtml\Import;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Module\Manager;
use Planet\Agent\Model\ResourceModel\Import\Collection;

/**
 * Created by PhpStorm.
 * User: ziru
 * Date: 29/08/16
 * Time: 17:05
 */
class Grid extends Extended
{
    /**
     * @var Manager
     */
    protected $moduleManager;


    protected $_importFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        Collection $importCollectionFactory,
        Manager $moduleManager,
        array $data = []
    ) {
        $this->_importFactory = $importCollectionFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('listsGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setVarNameFilter('lists_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_importFactory;

        $collection->_init([
            [
                'id' => 1,
                'title' => '123',
                'created_at' => 213414
            ],
            [
                'id' => 3,
                'title' => 'lalal',
                'created_at' => 213414
            ],
            [
                'id' => 4,
                'title' => 'ttt',
                'created_at' => 213414
            ],
        ]);

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