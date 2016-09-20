<?php

namespace Planet\Agent\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

use PHPExcel_IOFactory;
use Planet\Agent\Helper\File\CustomerFile;
use Planet\Agent\Model\ResourceModel\Import\CollectionFactory;

class Data extends AbstractHelper
{
    protected $_collection;

    protected $_mediaDirectory;

    protected $_productRepository;

    protected $_stockState;

    protected $_customerFile;

    protected $_customer;

    const INI_COLLECTION_INDEX = 18;

    const PARENT_SKU = 'A';

    const SIZE_P    = 'D';

    const SIZE_M    = 'F';

    const SIZE_G    = 'H';

    const SIZE_GG   = 'J';

    const SIZE_EXG  = 'L';

    const SIZE_EXGG = 'N';

    private $sizeProducts = [
        self::SIZE_P    => 'P',
        self::SIZE_M    => 'M',
        self::SIZE_G    => 'G',
        self::SIZE_GG   => 'GG',
        self::SIZE_EXG  => 'EXG',
        self::SIZE_EXGG => 'EXGG',
    ];

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        StockStateInterface $stockState,
        Filesystem $filesystem,
        CustomerFile $customerFile
    )
    {

        $this->_collection = $collectionFactory->create();
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_productRepository = $productRepository;
        $this->_stockState = $stockState;
        $this->_customerFile = $customerFile;

        parent::__construct($context);
    }


    public function processXlsxFile($file)
    {

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $worksheet = $objPHPExcel->getActiveSheet();

        $this->_customerFile->load($file);
        $this->_customer = $this->_customerFile->getCustomer();

        $data = array();

        foreach ($worksheet->getRowIterator() as $row) {

            $rowNumber = $row->getRowIndex();

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            if($rowNumber >= self::INI_COLLECTION_INDEX ) {

                $parentSku = null;

                foreach ($cellIterator as $cell) {

                    $rowDataCollection = null;

                    try {

                        if (!is_null($cell) && !empty($cell->getValue())) {

                            switch ($cell->getCoordinate()){

                                case self::PARENT_SKU . $rowNumber:

                                    $parentSku = $cell->getValue();

                                    break;

                                case self::SIZE_P . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_P];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;

                                case self::SIZE_M . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_M];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;

                                case self::SIZE_G . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_G];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;

                                case self::SIZE_GG . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_GG];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;

                                case self::SIZE_EXG . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_EXG];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;

                                case self::SIZE_EXGG . $rowNumber:

                                    $sku = $parentSku . '-' . $this->sizeProducts[self::SIZE_EXGG];
                                    $qty = $cell->getValue();

                                    $data['collection'][] = $this->getProductData($sku, $qty);

                                    break;
                            }

                        }

                    } catch (\PHPExcel_Calculation_Exception $c){

                    }
                }
            }
        }

        $this->_initCollection($data['collection']);

    }

    private function getProductData( $sku, $qty )
    {

        $rowDataCollection['sku']      = $sku;

        try{

            $product = $this->getProductBySku($sku);

            $rowDataCollection['quantity'] = $qty;
            $rowDataCollection['product_name'] = $product->getName();
            $rowDataCollection['stock'] =
                $this->_stockState->getStockQty($product->getId());

            $rowDataCollection['price'] =$product->getPrice();

        }catch (\Exception $e){

        }

        return $rowDataCollection;
    }

    public function _initCollection(array $arr)
    {
        $this->_collection->_init($arr);

        $i = $this->getCollection()->count() -1;
        $limit = $i - count($this->sizeProducts);
        for($i; $i > $limit; $i-- ){
            $this->getCollection()->removeItemByKey($i);
        }
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        return $this->_customer;
    }

}