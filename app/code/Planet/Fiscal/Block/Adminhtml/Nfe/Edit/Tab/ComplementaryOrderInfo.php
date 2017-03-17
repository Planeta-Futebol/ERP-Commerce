<?php

namespace Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab;


class ComplementaryOrderInfo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
            ['legend' => __('Complementary Order Information')]
        );

//        $fieldset->addField(
//            'pagamento',
//            'select',
//            [
//                'label'     => __('Forma de pagamento'),
//                'required'  => true,
//                'name'      => 'pagamento',
//                'value'     => '1',
//                'values'    =>
//                    [
//                        '0' => __('Pagamento à vista'),
//                        '1' => __('Pagamento a prazo'),
//                        '2' => __('Outros'),
//                    ],
//                'tabindex' => 1,
//
//            ]
//        );

//        $fieldset->addField(
//            'presenca',
//            'select',
//            [
//                'label'     => __('Indicador de presença do comprador'),
//                'required'  => true,
//                'name'      => 'presenca',
//                'value'     => '1',
//                'values'    =>
//                    [
//                        '0' => __('Não se aplica'),
//                        '1' => __('Operação presencial'),
//                        '2' => __('Operação não presencial, pela Internet'),
//                        '3' => __('Operação não presencial, Teleatendimento'),
//                        '4' => __('NFC-e em operação com entrega a domicílio'),
//                        '9' => __('Operação não presencial, outros'),
//                    ],
//                'tabindex' => 1,
//
//            ]
//        );

        $fieldset->addField(
            'frete_por_conta',
            'select',
            [
                'label'     => __('Modalidade do frete '),
                'name'      => 'frete_por_conta',
                'value'     => '1',
                'values'    =>
                    [
                        'R' => __('Por conta do emitente'),
                        'D' => __('Por conta do destinatário'),
                    ],
                'tabindex' => 1,
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'valor_frete',
            'text',
            [
                'label'    => __('Total do frete'),
                'name'     => 'valor_frete ',
            ]
        );

        $fieldset->addField(
            'valor_desconto ',
            'text',
            [
                'label'    => __('Total do desconto'),
                'name'     => 'valor_desconto ',
            ]
        );

        $fieldset->addField(
            'despesas_acessorias',
            'text',
            [
                'name'        => 'despesas_acessorias',
                'label'    => __('Outras despesas acessórias'),
            ]
        );

        $fieldset->addField(
            'informacoes_fisco',
            'textarea',
            [
                'name'        => 'informacoes_fisco',
                'label'    => __('Informações ao Fisco'),
            ]
        );

        $fieldset->addField(
            'informacoes_complementares',
            'textarea',
            [
                'name'     => 'informacoes_complementares',
                'label'    => __('Informações Complementares ao Consumidor'),
            ]
        );

        $form->setValues([
            'valor_frete'    => $model->getShippingAmount(),
            'valor_desconto' => $model->getDiscountAmount(),
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