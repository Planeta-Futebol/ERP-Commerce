<?php

namespace Planet\Product\Helper;

use PHPExcel_IOFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_productRepository;
    protected $_productFactory;
    protected $_attribute;

    const INIT_PRODUCT_COLLECTION_INDEX = 2;

    const PARENT_SKU = 'A';

    const GENDER     = 'B';

    const CATEGORY   = 'C';

    const CLOTHING   = 'D';

    const STYLE      = 'E';

    const PRODUCT_NAME   = 'F';

    const COST       = 'M';

    const SIZE_P     = 'G';

    const SIZE_M     = 'H';

    const SIZE_G     = 'I';

    const SIZE_GG    = 'J';

    const SIZE_EXG   = 'K';

    const SIZE_EXGG  = 'L';

    const RETAIL_PRICE  = 'Q';

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attribute,
        \Magento\Catalog\Model\ProductFactory $product
    )
    {
        $this->_productRepository = $productRepository;
        $this->_productFactory = $product;
        $this->_attribute =  $attribute;
    }

    public function processFile( $path )
    {
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $worksheet = $objPHPExcel->getActiveSheet();

        $data = array();

        foreach ($worksheet->getRowIterator() as $row) {

            $rowNumber = $row->getRowIndex();

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            if($rowNumber >= self::INIT_PRODUCT_COLLECTION_INDEX ) {

                $data[] = $this->getProductData($worksheet, $rowNumber);

            }
        }

        return $data;
    }

    /**
     * @param $worksheet \PHPExcel_Worksheet
     * @param $row
     * @return array
     */
    private function getProductData( $worksheet, $row )
    {
        $parentProduct = array();

        $parentProduct['sku'] = $worksheet->getCell($this::PARENT_SKU . $row)->getValue();
        $parentProduct['gender'] = $worksheet->getCell($this::GENDER . $row)->getValue();
        $parentProduct['category'] = $worksheet->getCell($this::CATEGORY . $row)->getValue();
        $parentProduct['clothing'] = $worksheet->getCell($this::CLOTHING . $row)->getValue();
        $parentProduct['style'] = $worksheet->getCell($this::STYLE . $row)->getValue();
        $parentProduct['product_name'] = $worksheet->getCell($this::PRODUCT_NAME . $row)->getValue();
        $parentProduct['cost'] = $worksheet->getCell($this::COST . $row)->getValue();
        $parentProduct['retail_price'] = $worksheet->getCell($this::RETAIL_PRICE . $row)->getValue();

        if (
            !is_null($worksheet->getCell($this::SIZE_P . $row))
            && !empty($worksheet->getCell($this::SIZE_P . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_P . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-P',
                $stock
            );
        }

        if (
            !is_null($worksheet->getCell($this::SIZE_M . $row))
            && !empty($worksheet->getCell($this::SIZE_M . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_M . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-M',
                $stock
            );
        }

        if (
            !is_null($worksheet->getCell($this::SIZE_G . $row))
            && !empty($worksheet->getCell($this::SIZE_G . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_G . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-G',
                $stock
            );
        }

        if (
            !is_null($worksheet->getCell($this::SIZE_GG . $row))
            && !empty($worksheet->getCell($this::SIZE_GG . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_GG . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-GG',
                $stock
            );
        }

        if (
            !is_null($worksheet->getCell($this::SIZE_EXG . $row))
            && !empty($worksheet->getCell($this::SIZE_EXG . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_EXG . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-EXG',
                $stock
            );
        }

        if (
            !is_null($worksheet->getCell($this::SIZE_EXGG . $row))
            && !empty($worksheet->getCell($this::SIZE_EXGG . $row)->getValue())
        ) {

            $stock = $worksheet->getCell($this::SIZE_EXGG . $row)->getValue();

            $parentProduct['childrens'][] = $this->getChildProduct(
                $parentProduct,
                $parentProduct['sku'] . '-EXGG',
                $stock
            );
        }

        return $parentProduct;
    }

    private function getChildProduct($parentProduct, $sku, $stock )
    {
        return [
            'sku'          => $sku,
            'gender'       => $parentProduct['gender'],
            'category'     => $parentProduct['category'],
            'clothing'     => $parentProduct['clothing'],
            'style'        => $parentProduct['style'],
            'product_name' => $parentProduct['product_name'],
            'cost'         => $parentProduct['cost'],
            'stock'        => $stock,
            'retail_price' => $parentProduct['retail_price'],
        ];
    }

    public function create( $products )
    {

        $attrGender = $this->_attribute->get('genero');

        foreach ( $attrGender->getOptions() as $option) {
            $option->getValue(); // codigo
            $option->getLabel(); // nome
        }

        $ttrCategory = $this->_attribute->get('categoria');

        foreach ( $ttrCategory->getOptions() as $option) {
            $option->getValue(); // codigo
            $option->getLabel(); // nome
        }

        $ttrStyle = $this->_attribute->get('style');

        foreach ( $ttrStyle->getOptions() as $option) {
            $option->getValue(); // codigo
            $option->getLabel(); // nome
        }

        $ttrClothing = $this->_attribute->get('vestuario');

        foreach ( $ttrClothing->getOptions() as $option) {
            $option->getValue(); // codigo
            $option->getLabel(); // nome
        }

        foreach ($products as $productConfigurables){
            foreach ($productConfigurables['childrens'] as $productChild){
                //$product = $this->_productFactory->create();
            }

            $product = $this->_productFactory->create();

            $product->setName($productConfigurables['product_name']);
            $product->setSku($productConfigurables['sku']);
            $product->setAttributeSetId(4);

            $product->setStatus(1); // Status on product enabled/ disabled 1/0
            $product->setWeight(10); // weight of product
            $product->setVisibility(4); // visibilty of product (catalog / search / catalog, search / Not visible individually)
            //$product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE); // type of product (simple/virtual/downloadable/configurable)
            $product->setTypeId(\Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE); // type of product (simple/virtual/downloadable/configurable)
            $product->setPrice($productConfigurables['retail_price']); // price of product

//            $product->setStockData([
//                'use_config_manage_stock' => 1,
//                'qty' => 100,
//                'is_qty_decimal' => 0,
//                'is_in_stock' => 1
//            ]);

            //$product->setCustomAttribute($attr->getAttributeCode(), 62);

            $this->_productRepository->save($product);
        }
    }
}