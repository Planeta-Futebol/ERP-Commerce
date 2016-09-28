<?php
/**
 * Copyright © 2016 Planeta Futebol. All rights reserved.
 *
 */

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class NewOrder extends Action
{
    /**
     * @var \Planet\Agent\Helper\OrderHelper
     *
     */
    protected $helper;

    public function __construct(
        \Planet\Agent\Helper\OrderHelper $helper,
        Action\Context $context
    )
    {
        parent::__construct($context);

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

        $params = $this->getRequest()->getParams();

        $items = array();

        // Prepare an array items to use in new order.
        foreach ($params['items'] as $item) {
            $arr = explode('-', $item);
            $items[] = [
                'product_id' => $arr[0],
                'qty'        => $arr[1]
            ];
        }

        $data = [
            'currency_id'  => 'USD',
            'email'        => $params['email'], //buyer email id
            'shipping_address' =>[
                'firstname'    => $params['firstname'], //address Details
                'lastname'     => $params['lastname'],
                'street'       => $params['street'],
                'city'         => $params['city'],
                'country_id'   => $params['country_id'],
                'region'       => $params['region'],
                'postcode'     => $params['postcode'],
                'telephone'    => $params['telephone'],
                'save_in_address_book' => 1
            ],

            'items' => $items
        ];

        // TODO need urgent corretion, this execption is wrong.
        try{
            $arr = $this->helper->createMageOrder($data);
        }catch (\Magento\Framework\Exception\NoSuchEntityException $e){
            $this->messageManager->addSuccessMessage('O pedido foi craido com sucesso!');
        }

        return $this->resultRedirectFactory->create()->setPath(
            'agent/*/import', [
                '_secure' => $this->getRequest()->isSecure(),
            ]
        );
    }
}