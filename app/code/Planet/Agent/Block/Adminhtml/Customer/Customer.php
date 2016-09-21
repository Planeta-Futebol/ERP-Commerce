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

    private $customerRepository;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;

        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->setTemplate('Planet_Agent::customer.phtml');
        return parent::_prepareLayout();
    }

    public function _beforeToHtml()
    {
        $this->_customer = $this->getData('customer');
        return parent::_beforeToHtml();
    }

    public function getName()
    {
        return $this->_customer->getName();
    }

    public function getTaxVat()
    {
        return '11.136.790/0001-53';
    }

    public function getStatus()
    {
        return 'Unlocked';
    }

    public function getAddress()
    {
        $address = $this->_customer->getDefaultBillingAddress();
//
//        $addressHtml = $address->ge
        $this->_customer->getDefaultBillingAddress();
    }

    public function getEmail()
    {
        return $this->_customer->getEmail();
    }
}