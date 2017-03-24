<?php

namespace Planet\Fiscal\Controller\Adminhtml\Nfe;


use GuzzleHttp\Client;
use Magento\Framework\App\ResponseInterface;
use Planet\Fiscal\Controller\Adminhtml\Nfe;

class Save extends Nfe
{

    const BASE_URI = "https://api.tiny.com.br/api2/";

    const TOKEN = "68348dc2d8d1baef4c9ad47648d717c765860bb5";

    const INCLUIR_NOTA = "nota.fiscal.incluir.php";

    const OBTER_NOTA = "nota.fiscal.obter.php";

    const UNPROCESSED_REQUEST = 1;

    const VALIDATION_ERROR = 2;

    const SUCCESS = 3;

    const ERROR_TYPE_MESSAGE = [
        1	=> 'token não informado',
        2	=> 'token inválido ou não encontrado',
        3	=> 'XML mal formado ou com erros',
        4	=> 'Erro de procesamento de XML',
        5	=> 'API bloqueada ou sem acesso',
        6	=> 'API bloqueada momentaneamente - muitos acessos no último minuto',
        7	=> 'Espaço da empresa Esgotado',
        8	=> 'Empresa Bloqueada',
        9	=> 'Números de sequencia em duplicidade',
        10	=> 'Parametro não informado',
        20	=> 'A Consulta não retornou registros',
        21	=> 'A Consulta retornou muitos registros',
        22	=> 'O xml tem mais registros que o permitido por lote de envio',
        23	=> 'A página que você está tentanto obter não existe',
        30	=> 'Erro de Duplicidade de Registro',
        31	=> 'Erros de Validação',
        32	=> 'Registro não localizado',
        33	=> 'Registro localizado em duplicidade',
        99	=> 'Sistema em manutenção',
    ];

    protected $_orderFacorty;

    protected $_client;

    protected $_nfeFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Planet\Fiscal\Model\NFeFactory $NFeFactory

    )
    {
        $this->_client =  new Client([
            'base_uri' => self::BASE_URI
        ]);

        $this->_orderFacorty = $orderFactory;
        $this->_nfeFactory   = $NFeFactory;
        parent::__construct($context, $resultPageFactory);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $params = $this->getRequest()->getParam('nfe');

            $nfeData = [
                'tipo'   => $params['tipo'],
                'natureza_operacao' => $params['natureza_operacao'],
            ];

            $nfeData['cliente'] = [
                'codigo'       => $params['codigo'],
                'nome'         => $params['nome_razao_social'],
                'tipo_pessoa'  => $params['tipo_pessoa'],
                'cpf_cnpj'     => $params['cpf_cnpj'],
                'ie'           => $params['ie'],
                'endereco'     => $params['endereco'],
                'complemento'  => $params['complemento'],
                'numero'       => $params['numero'],
                'bairro'       => $params['bairro'],
                'cidade'       => $params['cidade'],
                'uf'           => $params['uf'],
                'cep'          => $params['cep'],
                'fone'         => $params['fone'],
                'email'        => $params['email']
            ];

            $model = $this->_orderFacorty->create();

            if ($params['id']) {
                $model->load($params['id']);
                if (!$model->getId()) {
                    $this->messageManager->addError(__('This sales order no longer exists.'));
                    $this->_redirect('*/*/');
                    return;
                }
            }

            $nfeData['itens'] = null;

            foreach ($model->getAllItems() as $item ) {
                $nfeData['itens'][]['item'] = [
                    'codigo'     =>  $item->getId(),
                    'descricao'  =>  $item->getName(),
                    'sku'        =>  $item->getSku(),
                    'ncm'        =>  '',
                    'unidade'    =>  'UN',
                    'quantidade' =>  $item->getQtyOrdered(),
                    'valor_unitario' => $item->getPrice(),
                    'tipo'       => 'P',
                    'peso_bruto' => 0,
                    'origem'     => 4,
                ];
            }

            $nfeData['transportador'] = [
                'nome'          => $params['shipping_razao_social'],
                'tipo_pessoa'   => 'J',
                'cpf_cnpj'          => $params['shipping_cnpj'],
                'ie'            => $params['shipping_ie'],
                'endereco'      => $params['shipping_endereco'],
                'cidade'        => $params['shipping_cidade'],
                'uf'            => $params['shipping_uf'],
            ];


            $nfeData['quantidade_volumes'] = $params['volume'];
            $nfeData['especie_volumes'] = $params['especie'];
            $nfeData['frete_por_conta'] = $params['frete_por_conta'];
            $nfeData['valor_frete'] = $model->getShippingAmount();
            $nfeData['valor_desconto'] = $model->getDiscountAmount();
            $nfeData['valor_despesas '] = $params['despesas_acessorias'];
            $nfeData['informacoes_fisco'] = $params['despesas_acessorias'];
            $nfeData['informacoes_complementares'] = $params['informacoes_complementares'];

            $response = $this->_client->post(
                self::INCLUIR_NOTA,
                [
                    'query' => [
                        'token' => self::TOKEN,
                        'nota' => json_encode(['nota_fiscal' => $nfeData]),
                        'formato' => 'json'
                    ]
                ]
            );


            $ress = json_decode($response->getBody()->getContents());

            if($ress->retorno->status_processamento == self::VALIDATION_ERROR){

                $registros = $ress->retorno->registros;
                $errorType = $registros->registro->codigo_erro;
                $stringError = self::ERROR_TYPE_MESSAGE[$errorType];

                $errors = json_decode(json_encode($registros->registro->erros), True);

                foreach ( $errors as $errorMessage){
                    $stringError .= "; " . $errorMessage['erro'];
                }

                $this->messageManager->addErrorMessage($stringError);

            }

            if($ress->retorno->status_processamento == self::SUCCESS) {

                $registros = $ress->retorno->registros;
                $registro = $registros->registro;
                try {
                    $nfeModel = $this->_nfeFactory->create();

                    $nfeModel->addData([
                        'order_id'      => $model->getId(),
                        'nfe_id'        => $registro->id,
                        'nfe_serie'     => $registro->serie,
                        'nfe_number'    => $registro->numero,
                        'customer_name' => $params['nome_razao_social'],
                        'nfe_value'     => $model->getGrandTotal()
                    ]);

                    $nfeModel->save();

                } catch (\Exception $e){
                    $message = $e->getMessage();
                    $exceptionMessage = <<< "EXP_MESSAGE"
                        "A nota fical foi incluida com sucesso, mas ocorreu o seguinto erro: {$message}"
EXP_MESSAGE;
                    $this->messageManager->addErrorMessage($e->getMessage());
                }

                // Display success message
                $this->messageManager->addSuccessMessage(__('A nota fiscal foi incluida no Tiny com sucesso!'));

                // Go to grid page
                $this->_redirect('*/*/');
                return;
            }

            $formData = $this->getRequest()->getParam('nfe');

            $this->_getSession()->setFormData($formData);
            $this->_redirect('*/*/edit', ['order_id' => $model->getId()]);
        }
    }
}