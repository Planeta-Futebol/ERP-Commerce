<?php

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use PHPExcel_Cell;
use PHPExcel_IOFactory;

class Process extends Action
{

    const XLSX_DIR = 'xlsx_imported_files';

    const  XLSX_ALLOWED = [
        'xlsx', 'xlsm', 'xltx', 'xltm', 'xls',
        'xlt', 'ods', 'ots'
    ];

    protected $_mediaDirectory;

    protected $_fileUploaderFactory;

    public function __construct(
        Context $context,
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }


    const EOL = '</br>';

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {

        $target = $this->_mediaDirectory->getAbsolutePath();

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if(!$this->_mediaDirectory->isExist(self::XLSX_DIR)){
            mkdir($target . self::XLSX_DIR, 0777, true);
        }

        try{
            $target = $this->_mediaDirectory->getAbsolutePath(self::XLSX_DIR . '/');
            /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'xlsx_file']);

            /** Allowed extension types */
            $uploader->setAllowedExtensions(self::XLSX_ALLOWED);
            /** rename file name if already exists */
            $uploader->setAllowRenameFiles(true);

            $result = $uploader->save($target);

            $xlsxFilePath = $target . $result['file'];

            if ($result['file']) {
                $this->messageManager->addSuccessMessage(__('File has been successfully uploaded'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $objPHPExcel = PHPExcel_IOFactory::load($xlsxFilePath);

        echo date('H:i:s') , " Iterate worksheets" , self::EOL;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            echo 'Worksheet - ' , $worksheet->getTitle() , self::EOL;

            foreach ($worksheet->getRowIterator() as $row) {
                echo '    Row number - ' , $row->getRowIndex() , self::EOL;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                foreach ($cellIterator as $cell) {

                    try {

                        if (!is_null($cell) && !empty($cell->getValue())) {
                            echo '        Cell - ', $cell->getCoordinate(), ' - ', $cell->getCalculatedValue(), self::EOL;
                        }
                    }catch (\PHPExcel_Calculation_Exception $c){
                        if(!empty($cell->getValue())) {
                            echo self::EOL;
                        }
                    }
                }
            }

            break;
        }

        exit;


        return $this->resultRedirectFactory->create()->setPath(
            'agent/*/import', ['_secure'=>$this->getRequest()->isSecure()]
        );
    }
}