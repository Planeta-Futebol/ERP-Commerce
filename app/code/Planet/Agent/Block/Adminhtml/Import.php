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
        //die($this->_session->getXlsxFilePath());
        die($this->_session->getSessionId());
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock(
                'Planet\Agent\Block\Adminhtml\Import\Grid',
                'agent.import.grid'
            )
        );

        $this->setChild(
            'customer',
            $this->getLayout()->createBlock(
                'Planet\Agent\Block\Adminhtml\Customer\Customer',
                'agent.import.customer'
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

    public function getCustomerHtml()
    {
        return $this->getChildHtml('customer');
    }
}
