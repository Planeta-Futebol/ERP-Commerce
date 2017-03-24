<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Model\ResourceModel;

/**
 * NFe entity resource model
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class NFe extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('planet_fiscal_nfe','entity_id');
    }
}
