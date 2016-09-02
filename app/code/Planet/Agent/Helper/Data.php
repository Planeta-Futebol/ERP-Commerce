<?php

namespace Planet\Agent\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

use PHPExcel_IOFactory;
use Planet\Agent\Model\ResourceModel\Import\CollectionFactory;

class Data extends AbstractHelper
{
    protected $_collection;

    protected $_mediaDirectory;

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

        $data[] = null;


        foreach ($worksheet->getRowIterator() as $row) {
            $rowNumber = $row->getRowIndex();

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowDataCollection[] = null;

            if($rowNumber > 17 ) {
                foreach ($cellIterator as $cell) {

                    try {

                        if (!is_null($cell) && !empty($cell->getValue())) {

                            switch ($cell->getCoordinate()){

                                case "A{$rowNumber}":
                                    $rowDataCollection['created_at'] = $cell->getValue();
                                    $rowDataCollection['id'] = $rowNumber;
                                    $rowDataCollection['title'] = $worksheet->getTitle();

                            }

                        }
                    } catch (\PHPExcel_Calculation_Exception $c){}

                    $data['collection'][] = $rowDataCollection;
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