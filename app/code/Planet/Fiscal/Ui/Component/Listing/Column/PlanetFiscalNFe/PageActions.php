<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Ui\Component\Listing\Column\PlanetFiscalNFe;

/**
 * Class PageActions
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare link to action on grid
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if(isset($item["entity_id"]))
                {
                    $id = $item["entity_id"];
                }
                $item[$name]["view"] = [
                    "href"=>$this->getContext()->getUrl(
                        "fiscal/nfe/edit",["order_id"=>$id]),
                    "label"=>__("Create")
                ];
            }
        }

        return $dataSource;
    }
    
}
