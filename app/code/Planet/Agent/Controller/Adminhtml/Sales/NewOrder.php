<?php

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Planet\Agent\Helper\OrderHelper;

class NewOrder extends Action
{
    public function __construct(
        OrderHelper $helper,
        Action\Context $context
    )

    {
        parent::__construct($context);

        $this->_helper = $helper;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $data = [
            'currency_id'  => 'USD',
            'email'        => 'outrocoaara@webkul.com', //buyer email id
            'shipping_address' =>[
                'firstname'    => 'Outro', //address Details
                'lastname'     => 'Cara de novo',
                'street' => 'xxxxx',
                'city' => 'xxxxx',
                'country_id' => 'IN',
                'region' => 'xxx',
                'postcode' => '43244',
                'telephone' => '52332',
                'fax' => '32423',
                'save_in_address_book' => 1
            ],
            'items'=> [ //array of product which order you want to create
                ['product_id'=>'14766','qty' => 4 ],
                ['product_id'=>'14768','qty' => 20 ],
            ]
        ];

        $arr = $this->_helper->createMageOrder($data);

        $this->messageManager->addSuccessMessage($arr['msg']);

        return $this->resultRedirectFactory->create()->setPath(
            'agent/*/import', [
                '_secure' => $this->getRequest()->isSecure(),
            ]
        );
    }
}