<?php

namespace Planet\Product\Controller\Adminhtml\Product;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Planet_Product::import_product');

        $resultPage->getConfig()->getTitle()->prepend(__('Product - Import'));

        $resultPage->addBreadcrumb(__('Product'), __('Product'));
        $resultPage->addBreadcrumb(__('Import'), __('Import'));


        return $resultPage;

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ACL RULE HERE');
    }

}
