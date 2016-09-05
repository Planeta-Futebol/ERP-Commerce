<?php

namespace Planet\Agent\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

use PHPExcel_IOFactory;
use Planet\Agent\Model\ResourceModel\Import\CollectionFactory;

class Data extends AbstractHelper
{
    protected $_collection;

    protected $_mediaDirectory;

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
        Filesystem $filesystem
    )
    {

        $this->_collection = $collectionFactory->create();
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);


        parent::__construct($context);
    }


    public function processXlsxFile($file)
    {

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $worksheet = $objPHPExcel->getActiveSheet();

        $data = array();

        foreach ($worksheet->getRowIterator() as $row) {

            $rowNumber = $row->getRowIndex();

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            if($rowNumber >= self::INI_COLLECTION_INDEX ) {

                $productCollection = null;
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

                                    $rowDataCollection['sku'] = $parentSku . '-' . $this->sizeProducts[self::SIZE_P];
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                                case self::SIZE_M . $rowNumber:

                                    $rowDataCollection['sku'] = $parentSku . '-' . $this->sizeProducts[self::SIZE_M];
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                                case self::SIZE_G . $rowNumber:

                                    $rowDataCollection['sku'] = $parentSku . '-' . $this->sizeProducts[self::SIZE_G];
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                                case self::SIZE_GG . $rowNumber:

                                    $rowDataCollection['sku'] = $parentSku . '-' . $this->sizeProducts[self::SIZE_GG];
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                                case self::SIZE_EXG . $rowNumber:

                                    $rowDataCollection['sku'] = $parentSku . '-' . $this->sizeProducts[self::SIZE_EXG];
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                                case self::SIZE_EXGG . $rowNumber:

                                    $rowDataCollection['sku'] = $parentSku . '-' . self::SIZE_EXGG;
                                    $rowDataCollection['quantity'] = $cell->getValue();
                                    $productCollection[] = $rowDataCollection;

                                    break;

                            }

                        }

                        if(!is_null($productCollection)) {

                            foreach ($productCollection as $c){
                                $data['collection'][] = $c;
                            }

                            $productCollection = null;
                        }

                    } catch (\PHPExcel_Calculation_Exception $c){}
                }
            }
        }

        $this->_initCollection($data['collection']);

    }


    public function _initCollection(array $arr)
    {
        $this->_collection->_init($arr);
    }

    public function getCollection()
    {
        return $this->_collection;
    }
}