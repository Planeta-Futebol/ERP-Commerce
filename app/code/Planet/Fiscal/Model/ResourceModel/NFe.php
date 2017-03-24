<?php
namespace Planet\Fiscal\Model\ResourceModel;
class NFe extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('planet_fiscal_nfe','entity_id');
    }
}
