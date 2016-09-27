<?php

namespace Planet\Agent\Helper\File;


class CustomerFile extends AbstractFile
{
    private $customerFactory;
    private $storeManager;
    /**
     * @var \Magento\Customer\Model\Customer
     */
    private $customer;

    const STREET    = 'A8';
    const CITY      = 'A9';
    const COUNTY_ID = 'IN';
    const REGION    = 'A10';
    const POSTCODE  = 'D9';
    const TELEPHONE = 'D10';

    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->customerFactory = $customerFactory->create();
        $this->storeManager = $storeManager;
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        $customer = $this->isCustomer();
        $customer->addData([
            'address'   => $this->getImportedAddress(),
            'street'    => $this->getCell(self::STREET),
            'city'      => $this->getCell(self::CITY),
            'county'    => self::COUNTY_ID,
            'region'    => $this->getCell(self::REGION),
            'postcode'  => $this->getCell(self::POSTCODE),
            'telephone' =>$this->getCell(self::TELEPHONE)
        ]);

        return $customer;
    }

    private function isCustomer()
    {
        $store     = $this->storeManager->getStore();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer  = $this->customerFactory->setWebsiteId($websiteId);
        $customer->loadByEmail($this->getMail());

        if(!$customer->getEntityId()){
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($this->getName())
                ->setLastname('Imported')
                ->setEmail($this->getMail())
                ->setPassword($this->getMail());
            $customer->save();
        }

        return $customer;
    }

    private function getMail()
    {
        return $this->getCell('A11');
    }

    private function getName()
    {
        return $this->getCell('D6');
    }

    private function getImportedAddress()
    {
        $address = sprintf(
            "%s; %s; %s; %s; %s; %s",
            $this->getCell(self::STREET),
            $this->getCell(self::CITY),
            self::COUNTY_ID,
            $this->getCell(self::REGION),
            $this->getCell(self::POSTCODE),
            $this->getCell(self::TELEPHONE)

        );

        return $address;
    }
}