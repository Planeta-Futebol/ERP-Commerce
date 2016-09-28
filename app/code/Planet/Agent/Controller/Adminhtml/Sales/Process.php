<?php
/**
 * Copyright © 2016 Planeta Futebol. All rights reserved.
 *
 */

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;

class Process extends Action
{
    /**
     * Directory na to save xls imported files.
     *
     * @var string
     *
     */
    const XLSX_DIR = 'xlsx_imported_files';

    /**
     * Type files allowed
     *
     * @var array
     *
     */
    const XLSX_ALLOWED = [
        'xlsx', 'xlsm', 'xltx', 'xltm',
        'xlt' , 'ods' , 'ots' , 'xls'
    ];

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     *
     */
    protected $_mediaDirectory;

    /**
     * @var \Magento\Framework\File\UploaderFactory
     *
     */
    protected $_fileUploaderFactory;

    /**
     * @var \Planet\Agent\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\File\UploaderFactory $fileUploaderFactory,
        \Planet\Agent\Helper\Data $helper
    ) {
        parent::__construct($context);

        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->helper = $helper;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        // get path to pub/media
        $target = $this->_mediaDirectory->getAbsolutePath();

        // if dont have our directory, creates it with 777 permission.
        if(!$this->_mediaDirectory->isExist(self::XLSX_DIR)){
            mkdir($target . self::XLSX_DIR, 0777, true);
        }

        try{

            $target = $this->_mediaDirectory->getAbsolutePath(self::XLSX_DIR . '/');

            /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'xlsx_file']);

            // Allowed extension types.
            $uploader->setAllowedExtensions(self::XLSX_ALLOWED);

            // Rename file name if already exists.
            $uploader->setAllowRenameFiles(true);

            $result = $uploader->save($target);

            $xlsxFilePath = $target . $result['file'];

            // Set in session the current path to uploaded file.
            $this->_session->setXlsxFilePath($xlsxFilePath);

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath(
            'agent/*/import', [
                '_secure' => $this->getRequest()->isSecure(),
            ]
        );
    }
}