<?php

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Planet\Agent\Helper\Data as ImportData;

class Import extends Action
{
    protected $resultPageFactory = false;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ImportData $helper

    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $helper;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Planet_Agent::sales_import');

        $resultPage->getConfig()->getTitle()->prepend(__('Agent - Sales Import'));

        $resultPage->addBreadcrumb(__('Sales'), __('Sales'));
        $resultPage->addBreadcrumb(__('Import'), __('Import'));

        try{

            $this->_helper->processXlsxFile($this->_session->getXlsxFilePath());

        }catch (\PHPExcel_Reader_Exception $e){

        }

        return $resultPage;
    }
}