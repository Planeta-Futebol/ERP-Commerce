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

    private $_customerRepository;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->_customerRepository = $customerRepository;

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
        return $this->_customerRepository->getById($this->_customer->getId())->getTaxvat();
    }

    public function getStatus()
    {
        return ($this->_customer->isCustomerLocked()) ? 'Locked' : 'Unlocked';
    }

    public function getAddress()
    {
        return $this->_customer->getAddress();
    }

    public function getEmail()
    {
        return $this->_customer->getEmail();
    }

    public function getGroup()
    {
        //return $this->_customer->getAddress();
    }
}