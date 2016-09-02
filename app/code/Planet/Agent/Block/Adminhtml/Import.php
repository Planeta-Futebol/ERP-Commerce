<?php
namespace Planet\Agent\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\RegistryFactory as Registry;
use Magento\Backend\Block\Widget\Container;

class Import extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ){
        $this->_coreRegistry = $registry->create();
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'Planet_Agent';
        $this->_controller = 'adminhtml_import';

        parent::_construct();

    }

    protected function _prepareLayout()
    {
        echo $this->getData('user');

        $this->setChild(
            'grid',
            $this->getLayout()->createBlock(
                'Planet\Agent\Block\Adminhtml\Import\Grid',
                'agent.import.grid'
            )
        );

        return parent::_prepareLayout();
    }


    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
