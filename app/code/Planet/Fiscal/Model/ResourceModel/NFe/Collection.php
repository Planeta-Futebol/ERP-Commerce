<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Model\ResourceModel\NFe;

/**
 * NFe collection resource model
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Planet\Fiscal\Model\NFe','Planet\Fiscal\Model\ResourceModel\NFe');
    }

    /**
     * Retrieve all order ids for collection
     *
     * @return array
     */
    public function getAllOrderIds()
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(\Magento\Framework\DB\Select::ORDER);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
        $idsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);

        $idsSelect->columns('order_id', 'main_table');
        return $this->getConnection()->fetchCol($idsSelect, $this->_bindParams);
    }
}
