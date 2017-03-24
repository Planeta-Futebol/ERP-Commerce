<?php

namespace Planet\Fiscal\Model;

class NFe extends \Magento\Framework\Model\AbstractModel implements NFeInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'planet_fiscal_nfe';

    protected function _construct()
    {
        $this->_init('Planet\Fiscal\Model\ResourceModel\NFe');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
