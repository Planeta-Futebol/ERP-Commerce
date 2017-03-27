<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Controller\Adminhtml\Nfe;

use Magento\Framework\App\ResponseInterface;

/**
 * Generic backend controller
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class Index extends \Planet\Fiscal\Controller\Adminhtml\Nfe
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