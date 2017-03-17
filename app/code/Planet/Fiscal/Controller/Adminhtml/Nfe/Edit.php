<?php

namespace Planet\Fiscal\Controller\Adminhtml\Nfe;


use Magento\Framework\App\ResponseInterface;
use Planet\Fiscal\Controller\Adminhtml\Nfe;

class Edit extends Nfe
{
    protected $_coreRegistry;

    protected $_orderFacorty;

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

    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $model = $this->_orderFacorty->create();

        if ($orderId) {
            $model->load($orderId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This sales order no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
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