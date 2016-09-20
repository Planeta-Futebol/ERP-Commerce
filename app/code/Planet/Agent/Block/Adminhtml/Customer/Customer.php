<?php

namespace Planet\Agent\Block\Adminhtml\Customer;

use Magento\Framework\View\Element\Template;

class Customer extends Template
{
    protected $_helper;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $_customer;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Planet\Agent\Helper\Data $helper
    )
    {
        $this->_helper   = $helper;
        $this->_customer = $helper->getCustomer();

        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->setTemplate('Planet_Agent::customer.phtml');
        return parent::_prepareLayout();
    }

    public function getName()
    {
        //return $this->_customer->getName();
    }
}