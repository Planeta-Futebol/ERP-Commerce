<?php
/**
 * Copyright © 2016 Planeta Futebol. All rights reserved.
 *
 */

namespace Planet\Agent\Block\Adminhtml\Customer;

use Magento\Framework\View\Element\Template;

class Customer extends Template
{
    /**
     * @var \Magento\Customer\Model\Customer
     *
     */
    protected $_customer;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterface
     *
     */
    protected $_customerApi;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     *
     */
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
        // receive customer sets by setData()
        $this->_customer = $this->getData('customer');
        // load customer by customer api
        $this->_customerApi = $this->_customerRepository->getById($this->_customer->getId());
        return parent::_beforeToHtml();
    }

    /**
     * Full customer name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_customer->getName();
    }

    /**
     * Tax vat customer
     *
     * @return null|string
     */
    public function getTaxVat()
    {
        return $this->_customerApi->getTaxvat();
    }

    /**
     * Status customer in store
     *
     * @return string
     */
    public function getStatus()
    {
        return ($this->_customer->isCustomerLocked()) ? 'Locked' : 'Unlocked';
    }

    /**
     * Full adress customer
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->_customer->getAddress();
    }

    /**
     * Current email customer
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_customer->getEmail();
    }

    public function getGroup()
    {
        // TODO get name of group customer
    }

    /**
     * Street customer
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->_customer->getStreet();
    }

    /**
     * City customer
     *
     * @return string
     */
    public function getCity()
    {
        return $this->_customer->getCity();
    }

    /**
     * Country id customer
     *
     * @return string
     */
    public function getCountyId()
    {
        return $this->_customer->getCounty();
    }

    /**
     * Region customer
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->_customer->getRegion();
    }

    /**
     * Postcode customer
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->_customer->getPostcode();
    }

    /**
     * Telephone customer
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->_customer->getTelephone();
    }

    /**
     * Firstname customer
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->_customerApi->getFirstname();
    }

    /**
     * Lastname customer
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->_customerApi->getLastname();
    }
}