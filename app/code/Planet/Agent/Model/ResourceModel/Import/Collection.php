<?php

namespace Planet\Agent\Model\ResourceModel\Import;

use Magento\Framework\DataObject;
use Planet\Agent\Exception\Model\ConvertException;

class Collection extends \Magento\Framework\Data\Collection
{

    public function _init ( array $arr )
    {
        if(!is_array($arr) || !is_array($arr[0])){
            throw new ConvertException("The argument is not an array of two levels!");
        }

        foreach ( $arr as $v ){
            $obj = new DataObject();
            $obj->addData($v);
            $this->addItem($obj);
        }
    }
}
