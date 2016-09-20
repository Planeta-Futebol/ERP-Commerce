<?php
namespace Planet\Agent\Helper\File;


class CustomerFile extends AbstractFile
{
    private $customerFactory;
    private $customer;
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        $this->customerFactory = $customerFactory->create();
    }

    public function getCustomer()
    {
        return $this->isCustomer();
    }

    private function isCustomer()
    {
        $customer = $this->customerFactory->setWebsiteId(1);
        $customer->loadByEmail($this->getMail());
        if ($customer->getId()) {
            return $customer;
        }

        return false;
    }

    private function getMail()
    {
        return $this->getCell('A11');
    }

}