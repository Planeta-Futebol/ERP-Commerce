<?php

namespace Planet\Product\Block\Adminhtml;

class Main extends \Magento\Backend\Block\Widget\Container
{

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_blockGroup = 'Planet_Product';
        $this->_controller = 'adminhtml_index';

        parent::_construct();
    }

    function _prepareLayout(){

        $this->setChild(
            'grid',
            $this->getLayout()->createBlock(
                'Planet\Product\Block\Adminhtml\Import\Grid',
                'agent.import.grid'
            )
        );

        return parent::_prepareLayout();
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
