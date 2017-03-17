<?php

namespace Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab;


class TransportInfo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('nfe_');
        $form->setFieldNameSuffix('nfe');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Transport Information')]
        );

        $fieldset->addField(
            'volume',
            'text',
            [
                'name'        => 'volume',
                'label'    => __('Quantidade de volumes transportados'),
            ]
        );

        $fieldset->addField(
            'especie',
            'text',
            [
                'name'     => 'especie',
                'label'    => __('Espécie dos volumes transportados'),
            ]
        );

        $fieldset->addField(
            'peso_bruto',
            'text',
            [
                'name'     => 'peso_bruto',
                'label'    => __('Peso bruto dos volumes transportados'),
            ]
        );

        $fieldset->addField(
            'peso_liquido',
            'text',
            [
                'name'     => 'peso_liquido',
                'label'    => __('Peso líquido dos volumes transportados'),
            ]
        );

        $fieldset->addField(
            'marca',
            'text',
            [
                'name'     => 'marca',
                'label'    => __('Marca dos volumes transportados'),
            ]
        );

        $fieldset->addField(
            'numeracao',
            'text',
            [
                'name'     => 'numeracao',
                'label'    => __('Numeração dos volumes transportados'),
            ]
        );

        $fieldset->addField(
            'lacres',
            'text',
            [
                'name'     => 'lacres',
                'label'    => __('Número dos Lacres dos volumes transportados'),
            ]
        );

        $fieldset = $form->addFieldset(
            'shipping_company_fieldset',
            ['legend' => __('Shipping Company')]
        );

        $fieldset->addField(
            'shipping_cnpj',
            'text',
            [
                'name'     => 'shipping_cnpj',
                'label'    => __('CNPJ'),
            ]
        );

        $fieldset->addField(
            'shipping_razao_social',
            'text',
            [
                'name'     => 'shipping_razao_social',
                'label'    => __('Razão Social'),
            ]
        );

        $fieldset->addField(
            'shipping_ie',
            'text',
            [
                'name'     => 'shipping_ie',
                'label'    => __('Inscrição Estadual'),
            ]
        );

        $fieldset->addField(
            'shipping_endereco',
            'text',
            [
                'name'     => 'shipping_endereco',
                'label'    => __('Endereço completo da empresa'),
            ]
        );

        $fieldset->addField(
            'shipping_uf',
            'text',
            [
                'name'     => 'shipping_uf',
                'label'    => __('UF'),
            ]
        );

        $fieldset->addField(
            'shipping_cidade',
            'text',
            [
                'name'     => 'shipping_cidade',
                'label'    => __('Cidade'),
            ]
        );

        $fieldset->addField(
            'shipping_cep',
            'text',
            [
                'name'     => 'shipping_cep',
                'label'    => __('CEP'),
            ]
        );

        $fieldset->addField(
            'shipping_placa',
            'text',
            [
                'name'     => 'shipping_placa',
                'label'    => __('Placa'),
            ]
        );

        $fieldset->addField(
            'shipping_rntc',
            'text',
            [
                'name'     => 'shipping_rntc',
                'label'    => __('Registro Nacional da Transportador (ANTT)'),
            ]
        );

        $fieldset->addField(
            'shipping_seguro',
            'text',
            [
                'name'     => 'shipping_seguro',
                'label'    => __('Seguro'),
            ]
        );

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