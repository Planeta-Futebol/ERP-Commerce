<?php

namespace Planet\Fiscal\Block\Adminhtml\Nfe\Edit\Tab;


use Magento\Sales\Model\Order\AddressRepository;

class CustomerInfo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_customerRepository;
    protected $_addressRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Sales\Model\Order\AddressRepository $addressRepository,
        array $data = []
    )
    {
        $this->_customerRepository = $customerRepository;
        $this->_addressRepository = $addressRepository;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('sales_order');
        $customer = $this->_customerRepository->getById($model->getCustomerId());
        $address = $this->_addressRepository->get($model->getShippingAddressId());


        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('nfe_');
        $form->setFieldNameSuffix('nfe');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Customer Data')]
        );

        $fieldset->addField(
            'tipo_pessoa',
            'select',
            [
                'label'     => __('Pessoa'),
                'name'      => 'tipo_pessoa',
                'values'    =>
                    [
                        'F' => __('Física'),
                        'J' => __('Jurídica'),
                        'E' => __('Estrangeiro'),
                    ],
                'tabindex' => 1,
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'cpf_cnpj',
            'text',
            [
                'label' => __('CPF/CNPJ'),
                'name' => 'cpf_cnpj',
            ]
        );

        $fieldset->addField(
            'ie',
            'text',
            [
                'label' => __('Inscrição Estadual'),
                'name' => 'ie',
            ]
        );

        $fieldset->addField(
            'nome_razao_social',
            'text',
            [
                'label' => __('Nome/Razão social'),
                'name' => 'nome_razao_social',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'endereco',
            'text',
            [
                'label' => __('Endereço de entrega'),
                'name' => 'endereco',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'complemento',
            'text',
            [
                'label' => __('Complemento'),
                'name' => 'complemento',
            ]
        );

        $fieldset->addField(
            'numero',
            'text',
            [
                'label' => __('Número'),
                'name' => 'numero',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'bairro',
            'text',
            [
                'label' => __('Bairro'),
                'name' => 'bairro',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'cidade',
            'text',
            [
                'label' => __('Cidade'),
                'name' => 'cidade',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'uf',
            'text',
            [
                'label' => __('UF'),
                'name' => 'uf',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'cep',
            'text',
            [
                'label' => __('CEP'),
                'name' => 'cep',
                'required'  => true,
            ]
        );

        $fieldset->addField(
            'fone',
            'text',
            [
                'label' => __('Telefone'),
                'name' => 'fone'
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'label' => __('E-mail do cliente'),
                'name' => 'email'
            ]
        );

        $fieldset->addField(
            'codigo',
            'hidden',
            [
                'name' => 'codigo'
            ]
        );

        $form->setValues([
            'codigo'            => $model->getCustomerId(),
            'nome_razao_social' => $model->getCustomerFirstname(),
            'endereco'     => $address->getStreet()[0],
            'complemento'  => isset($address->getStreet()[1]) ? $address->getStreet()[1] : null,
            'cidade'       => $address->getCity(),
            'uf'           => $address->getRegionCode(),
            'cep'          => $address->getPostcode(),
            'email'        => $address->getEmail()
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
        return __('Customer Info');
    }

    /**
     * Return Tab title
     *
     * @return string
     * @api
     */
    public function getTabTitle()
    {
        return __('Customer Info');
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