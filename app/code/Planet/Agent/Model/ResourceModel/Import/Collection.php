<?php
/**
 * Copyright © 2016 Planeta Futebol. All rights reserved.
 *
 */

namespace Planet\Agent\Model\ResourceModel\Import;

use Magento\Framework\DataObject;
use Planet\Agent\Exception\Model\ConvertException;

/**
 * Class Collection
 * @package Planet\Agent\Model\ResourceModel\Import
 */
class Collection extends \Magento\Framework\Data\Collection
{
    /**
     * Initialise the collection with array data passed in parameters
     *
     * @param array $arr
     * @throws ConvertException
     */
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
