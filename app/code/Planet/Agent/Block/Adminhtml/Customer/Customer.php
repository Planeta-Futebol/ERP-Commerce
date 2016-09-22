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
        return 'Unlocked';
    }

    public function getAddress()
    {
        $address = $this->_customer->getDefaultBillingAddress();

        $addressHtml = sprintf(
            "%s; %s; %s",
            $address->getStreetFull(),
            $address->getCity(),
            $address->getCountryModel()->getName()

        );

        return $addressHtml;
    }

    public function getEmail()
    {
        return $this->_customer->getEmail();
    }

    public function getGroup()
    {
        return 'Traditional Trade';
    }
}