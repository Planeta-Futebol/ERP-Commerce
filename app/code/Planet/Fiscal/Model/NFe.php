<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Model;

/**
 * NFe model
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class NFe extends \Magento\Framework\Model\AbstractModel implements NFeInterface, \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'planet_fiscal_nfe';

    protected function _construct()
    {
        $this->_init('Planet\Fiscal\Model\ResourceModel\NFe');
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
