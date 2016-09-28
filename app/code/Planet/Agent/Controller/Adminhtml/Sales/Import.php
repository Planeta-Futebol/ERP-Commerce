<?php
/**
 * Copyright © 2016 Planeta Futebol. All rights reserved.
 *
 */

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action;

class Import extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     *
     */
    protected $resultPageFactory;

    /**
     * @var \Planet\Agent\Helper\Data
     *
     */
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Planet\Agent\Helper\Data $helper

    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;

        parent::__construct($context);
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

            // Try process xls file by path in session.
            $this->helper->processXlsxFile($this->_session->getXlsxFilePath());

            $block = $resultPage->getLayout()->getBlock('agent_sales_import');

            // Set explicite product follection to Import Block.
            $block->setData('collection', $this->helper->getCollection());

            // And difme customer child with data imported
            $block->setChild(
                'customer',
                $resultPage->getLayout()->createBlock(
                    'Planet\Agent\Block\Adminhtml\Customer\Customer',
                    'agent.import.customer'
                )->setData('customer', $this->helper->getCustomer())
            );

        }catch (\PHPExcel_Reader_Exception $e){
            // It does nothing if there is no file.
        }

        return $resultPage;
    }
}