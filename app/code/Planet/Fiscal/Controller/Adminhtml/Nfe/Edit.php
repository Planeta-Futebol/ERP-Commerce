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
class Edit extends \Planet\Fiscal\Controller\Adminhtml\Nfe
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFacorty;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_orderFacorty = $orderFactory;
        parent::__construct($context, $resultPageFactory);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $model = $this->_orderFacorty->create();

        if ($orderId) {
            $model->load($orderId);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This sales order no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            //TODO Look at me, I'm not working yet.
            $this->_coreRegistry->register('custom_form_data', $data);
        }
        $this->_coreRegistry->register('sales_order', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Planet_Fiscal::create_nfe');
        $resultPage->getConfig()->getTitle()->prepend(__('Invoice Fiscal Note'));

        return $resultPage;
    }

}