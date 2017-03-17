<?php

namespace Planet\Fiscal\Controller\Adminhtml\Nfe;


use Magento\Framework\App\ResponseInterface;
use Planet\Fiscal\Controller\Adminhtml\Nfe;

class Index extends Nfe
{


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Planet_Fiscal::create_nfe');
        $resultPage->getConfig()->getTitle()->prepend(__('Sales list to create NF-e'));
        $resultPage->addBreadcrumb(__('Sales'), __('Sales'));
        $resultPage->addBreadcrumb(__('Nf-e'), __('Nf-e'));

        return $resultPage;
    }
}