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
        return parent::_prepareLayout();
    }
}
