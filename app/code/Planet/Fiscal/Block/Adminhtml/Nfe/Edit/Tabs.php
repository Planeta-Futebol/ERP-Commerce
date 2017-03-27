<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Block\Adminhtml\Nfe\Edit;

/**
 * Backend tabs block
 *
 * @author Planeta Core Team - Ronildo dos Santos
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('fiscal_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('NF-e Information'));
    }

    /**
     * Adds the tabs of form
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'nfe_info',
            [
                'label' => __('Note Data'),
                'title' => __('Note Data'),
                'content' => $this->getLayout()->createBlock(
                    'Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab\NfeInfo'
                )->toHtml(),
                //sets current tab active
                'active' => true
            ]
        );

        $this->addTab(
            'customer_info',
            [
                'label' => __('Customer Data'),
                'title' => __('Customer Data'),
                'content' => $this->getLayout()->createBlock(
                    'Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab\CustomerInfo'
                )->toHtml(),
            ]
        );

        $this->addTab(
            'complementary_order_info',
            [
                'label' => __('Complementary Order Information'),
                'title' => __('Complementary Order Information'),
                'content' => $this->getLayout()->createBlock(
                    'Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab\ComplementaryOrderInfo'
                )->toHtml(),
            ]
        );


        $this->addTab(
            'transport_info',
            [
                'label' => __('Transport Information'),
                'title' => __('Transport Information'),
                'content' => $this->getLayout()->createBlock(
                    'Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab\TransportInfo'
                )->toHtml(),
            ]
        );

        return parent::_beforeToHtml();
    }
}