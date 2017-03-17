<?php

namespace Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab;


class NfeInfo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('sales_order');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('nfe_');
        $form->setFieldNameSuffix('nfe');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Note Data')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'text',
                [
                    'name' => 'id',
                    'label' => __('Request number'),
                    'readonly' => true,
                ]
            );
        }

        $fieldset->addField(
            'tipo',
            'select',
            [
                'label'     => __('Operation of the Invoice'),
                'required'  => true,
                'name'      => 'tipo',
                'values'    =>
                    [
                        'S' => __('Output'),
                    ],
                'tabindex' => 1,
                'readonly' => true,
            ]
        );

        $fieldset->addField(
            'natureza_operacao',
            'text',
            [
                'name'        => 'natureza_operacao',
                'label'    => __('Nature of Operation'),
                'required'     => true
            ]
        );

        $fieldset->addField(
            'modelo',
            'select',
            [
                'label'     => __('Invoice Template'),
                'name'      => 'modelo',
                'required'  => true,
                'value'     => '1',
                'values'    =>
                    [
                        '1' => __('NF-e'),
                        '2' => __('NFC-e'),
                    ],
                'tabindex' => 1,
            ]
        );

        $fieldset->addField(
            'finalidade',
            'select',
            [
                'label'     => __('Purpose of issuing the Invoice'),
                'name'      => 'finalidade',
                'required'  => true,
                'value'     => '1',
                'values'    =>
                    [
                        '1' => __('NF-e normal'),
                        '2' => __('NF-e complementar'),
                        '3' => __('NF-e de ajuste'),
                        '4' => __('Devolução/Retorno'),
                    ],
                'tabindex' => 1,
            ]
        );

        $form->setValues([
            'id' => $model->getId(),
            'ambiente' => 2
        ]);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Return Tab label
     *
     * @return string
     * @api
     */
    public function getTabLabel()
    {
        return __('NF-e Info');
    }

    /**
     * Return Tab title
     *
     * @return string
     * @api
     */
    public function getTabTitle()
    {
        return __('NF-e Info');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     * @api
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     * @api
     */
    public function isHidden()
    {
        return false;
    }
}