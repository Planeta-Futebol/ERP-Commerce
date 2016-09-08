<?php

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use PHPExcel_IOFactory;
use Planet\Agent\Helper\Data as ImportData;


class Process extends Action
{

    const XLSX_DIR = 'xlsx_imported_files';

    const  XLSX_ALLOWED = [
        'xlsx', 'xlsm', 'xltx', 'xltm',
        'xlt' , 'ods' , 'ots' , 'xls'
    ];

    protected $_mediaDirectory;

    protected $_fileUploaderFactory;

    public function __construct(
        Context $context,
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory,
        ImportData  $helper
    ) {
        parent::__construct($context);

        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $target = $this->_mediaDirectory->getAbsolutePath();

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

        $this->_session->setXlsxFilePath($xlsxFilePath);

        return $this->resultRedirectFactory->create()->setPath(
            'agent/*/import', [
                '_secure' => $this->getRequest()->isSecure(),
            ]
        );
    }
}