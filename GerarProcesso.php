<?php

// Recupera os tokens da sessão
echo $authorization = 'eyJhbGciOiJkaXIiLCJlbmMiOiJBMTI4Q0JDLUhTMjU2In0..avH9FB0YS__MwvlydZ4ytQ.3bXuulEdSpR8f_S4HEMsuhctkSvVwU_GmC-Q7SFkk1KicPdUNdLU27owLp6tvLX_M3LLnkykLfEmz2GyHFzovTXch0pCLaehxMW4O_C0GpLD2sG3JLR4K03M4NlCKrkjvPMxF6fybzR5S7YMNRwtDYOx5zzRNotepiNHMOk4YpZ7hZpTFdImIeVmkgoscL3cMAN1OmcMIA0WQzsho9XJmw.PAIAOE2ioIiis_7Ii9mfOA';
echo $xIntegrationAuth = 'eyJhbGciOiJkaXIiLCJlbmMiOiJBMTI4Q0JDLUhTMjU2In0..RmDLPoKpRW6-vBKzUIDTyg.6jVsUhvhFy2NQhiUgU3RzjOoxxLBsbVHh3Eui2YMjOHVVbYEGQN5cbg5mv2aerw_k10QEJHrVT1aLZz8krKs3a95jERSciPtbAdrHFxcA3Hi9nRTjx_8GMjL34Lm4uNhsd1bBN-g0wis_i_jNvctb6pw7c52pRUEF80KiH5htjM.98bkIzMVZHe9tsLz-_4OBQ';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados enviados pelo formulário
    $empresa = $_POST['Empresa'];
    $obra = $_POST['Obra'];
    $codigoFornecedor = $_POST['CodigoFornecedor'];
    $tipoProcesso = $_POST['TipoProcesso'];
    $controlarEstoque = isset($_POST['ControlarEstoque']) ? 1 : 0;
    $acompanhaEntrega = isset($_POST['AcompanhaEntrega']) ? 1 : 0;
    $tipoItem = $_POST['TipoItem'];
    $historicoLancContabil = $_POST['HistoricoLancContabil'];
    $historicoLancContabilPago = $_POST['HistoricoLancContabilPago'];
    $numeroContrato = $_POST['NumeroContrato'];
    $taxaJuros = $_POST['TaxaJuros'];
    $taxaMulta = $_POST['TaxaMulta'];
    $tipoJuros = $_POST['TipoJuros'];
    $retroagir = $_POST['Retroagir'];
    $dataInicioReajuste = $_POST['DataIncioReajuste'];

    $parcelaDataVencimento = $_POST['Parcelas']['Datavencimento'];
    $parcelaValor = $_POST['Parcelas']['Valor'];

    $item = $_POST['Itens']['Item'];
    $quantidade = $_POST['Itens']['Quantidade'];
    $preco = $_POST['Itens']['Preco'];
    $cap = $_POST['Cap'];
    $unidade = $_POST['Unidade'];

    $vinculoItem = $_POST['Item'];
    $codigoProduto = $_POST['CodigoProduto'];
    $contrato = $_POST['Contrato'];
    $servico = $_POST['Servico'];
    $insumo = $_POST['Insumo'];
    $mesPlanejamento = $_POST['MesPlanejamento'];
    $vinculoQuantidade = $_POST['Quantidade'];
    $vinculoPreco = $_POST['Preco'];

    // Monta o array com os dados do formulário
    $data = [
        "Empresa" => $empresa,
        "Obra" => $obra,
        "CodigoFornecedor" => $codigoFornecedor,
        "TipoProcesso" => $tipoProcesso,
        "ControlarEstoque" => $controlarEstoque,
        "AcompanhaEntrega" => $acompanhaEntrega,
        "TipoItem" => $tipoItem,
        "HistoricoLancContabil" => $historicoLancContabil,
        "HistoricoLancContabilPago" => $historicoLancContabilPago,
        "NumeroContrato" => $numeroContrato,
        "Parametro" => [
            "TaxaJuros" => $taxaJuros,
            "TaxaMulta" => $taxaMulta,
            "TipoJuros" => $tipoJuros,
            "Retroagir" => $retroagir,
            "DataIncioReajuste" => $dataInicioReajuste
        ],
        "Parcelas" => [
            [
                "Datavencimento" => $parcelaDataVencimento,
                "Valor" => $parcelaValor
            ]
        ],
        "Itens" => [
            [
                "Item" => $item,
                "Quantidade" => $quantidade,
                "Preco" => $preco,
                "Cap" => $cap,
                "Unidade" => $unidade,
                "VinculoPL" => [
                    [
                        "Item" => $vinculoItem,
                        "CodigoProduto" => $codigoProduto,
                        "Contrato" => $contrato,
                        "Servico" => $servico,
                        "Insumo" => $insumo,
                        "MesPlanejamento" => $mesPlanejamento,
                        "Quantidade" => $vinculoQuantidade,
                        "Preco" => $vinculoPreco
                    ]
                ]
            ]
        ]
    ];

    // Converte o array para JSON
    $jsonData = json_encode($data);

    // Configuração da API
    
    $url = "https://gamma-api.seniorcloud.com.br:50810/uauAPI/api/v1.0/ProcessoPagamento/GerarProcesso";
    $version = '1.0';        
   // $headers = [
    //    'Content-Type: application/json',
    //    'version: ' . $version,
    //    'Authorization: Bearer ' . $authorization,
    //    'X-INTEGRATION-Authorization: ' . $xIntegrationAuth
   // ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'version: ' . $version, // Passando a versão da API
        'Authorization: ' . $authorization,  // Usando o Authorization da sessão
        'X-INTEGRATION-Authorization: ' . $xIntegrationAuth // Usando o X-INTEGRATION-Authorization da sessão
    ]);
    
    // Envia a requisição para a API
  //  $ch = curl_init($url);
   // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POST, true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Verifica o código HTTP da resposta
    curl_close($ch);

    // Verifica se a requisição foi bem-sucedida
    if ($http_code == 200) {
        // Sucesso
        echo json_encode(['status' => 'success', 'message' => 'SEU PROCESSO DE PAGAMENTO FOI CADASTRADO COM SUCESSO!']);
    } else {
        // Falha
        echo json_encode(['status' => 'error', 'message' => 'Erro: Verifique os parâmetros ou a autenticação.']);
    }

    echo json_encode(['status' => 'response', 'message' => $response]);
}
?>  


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Processo de Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    
</head>
<body>
    <div class="container mt-5">
        <h2>Formulário de Processo de Pagamento</h2>
        <form id="formulario" method="POST">
           
                    <label for="Empresa" class="form-label">Empresa</label>
                    <input type="number" class="form-control" id="Empresa" name="Empresa" value="1203" required>
                </div>
                <div class="mb-3">
                    <label for="Obra" class="form-label">Obra</label>
                    <input type="text" class="form-control" id="Obra" name="Obra" value="1203" required>
                </div>
                <div class="mb-3">
                    <label for="CodigoFornecedor" class="form-label">Código do Fornecedor</label>
                    <input type="number" class="form-control" id="CodigoFornecedor" name="CodigoFornecedor" value="64730" required>
                </div>
                <div class="mb-3">
                    <label for="TipoProcesso" class="form-label">Tipo de Processo de Pagamento</label>
                    <select class="form-control" id="TipoProcesso" name="TipoProcesso" required>
                        <option value="1">Processo de Pagamento</option>
                        <option value="11">Compra de Patrimônio</option>
                        <option value="13">Adiantamento de Caixa de Obra</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="ControlarEstoque" class="form-label">Controlar Estoque</label>
                    <input type="checkbox" class="form-check-input" id="ControlarEstoque" name="ControlarEstoque" value="0">
                </div>
                <div class="mb-3">
                    <label for="AcompanhaEntrega" class="form-label">Acompanha Entrega</label>
                    <input type="checkbox" class="form-check-input" id="AcompanhaEntrega" name="AcompanhaEntrega" value="0">
                </div>
                <div class="mb-3">
                    <label for="TipoItem" class="form-label">Tipo de Item</label>
                    <input type="number" class="form-control" id="TipoItem" name="TipoItem" value="1" required>
                </div>
                <div class="mb-3">
                    <label for="HistoricoLancContabil" class="form-label">Histórico de Lançamento Contábil</label>
                    <input type="text" class="form-control" id="HistoricoLancContabil" name="HistoricoLancContabil" value="[pgto_NomeFornecedor]" required>
                </div>
                <div class="mb-3">
                    <label for="HistoricoLancContabilPago" class="form-label">Histórico de Lançamento Contábil Pago</label>
                    <input type="text" class="form-control" id="HistoricoLancContabilPago" name="HistoricoLancContabilPago" value="[pgto_NomeFornecedor]" required>
                </div>
                <div class="mb-3">
                    <label for="NumeroContrato" class="form-label">Número do Contrato</label>
                    <input type="number" class="form-control" id="NumeroContrato" name="NumeroContrato" value="0" required>
                </div>
                <div class="mb-3">
                    <label for="TaxaJuros" class="form-label">Taxas de Juros</label>
                    <input type="number" class="form-control" id="TaxaJuros" name="TaxaJuros" value="0" required>
                </div>
                <div class="mb-3">
                    <label for="TaxaMulta" class="form-label">Taxas de Multas</label>
                    <input type="number" class="form-control" id="TaxaMulta" name="TaxaMulta" value="0" required>
                </div>
                <div class="mb-3">
                    <label for="TipoJuros" class="form-label">Tipos de Juros</label>
                    <input type="number" class="form-control" id="TipoJuros" name="TipoJuros" value="0" required>
                </div>
                <div class="mb-3">
                    <label for="Retroagir" class="form-label">Retroagir</label>
                    <input type="number" class="form-control" id="Retroagir" name="Retroagir" value="0" required>
                </div>
                <div class="mb-3">
                    <label for="DataIncioReajuste" class="form-label">Data Início de Reajuste</label>
                    <input type="text" class="form-control datepicker" id="DataIncioReajuste" name="DataIncioReajuste" value="2025-01-30" required>
                </div>
               
            </div>

            <!-- Seção 2: Parcelas -->
                    <label for="Datavencimento" class="form-label">Data de Vencimento</label>
                    <input type="text" class="form-control datepicker" id="Datavencimento" name="Parcelas[Datavencimento]" value="2025-01-30" required>
                </div>
                <div class="mb-3">
                    <label for="Valor" class="form-label">Valor</label>
                    <input type="number" class="form-control" id="Valor" name="Parcelas[Valor]" value="10" required>
                </div>
                 
            </div>

            <!-- Seção 3: Itens -->
            
                    <label for="Item" class="form-label">Item</label>
                    <input type="text" class="form-control" id="Item" name="Itens[Item]" value="12031" required>
                </div>
                <div class="mb-3">
                    <label for="Quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="Quantidade" name="Itens[Quantidade]" value="1" required>
                </div>
                <div class="mb-3">
                    <label for="Preco" class="form-label">Preço</label>
                    <input type="number" class="form-control" id="Preco" name="Itens[Preco]" value="10" required>
                </div>
                <div class="mb-3">
                    <label for="Cap" class="form-label">Cap</label>
                    <input type="number" class="form-control" id="Cap" name="Cap" value="0002" required>
                </div>
                <div class="mb-3">
                    <label for="Unidade" class="form-label">Unidade</label>
                    <input type="text" class="form-control" id="Unidade" name="Unidade" value="UND" required>
                </div>
                
            
            </div>

                    <label for="Item" class="form-label">Item</label>
                    <input type="text" class="form-control" id="Item" name="Item" value="01.01" required>
                </div>
                <div class="mb-3">
                    <label for="CodigoProduto" class="form-label">Código Produto</label>
                    <input type="number" class="form-control" id="CodigoProduto" name="CodigoProduto" value="1203" required>
                </div>
                <div class="mb-3">
                    <label for="Contrato" class="form-label">Contrato</label>
                    <input type="number" class="form-control" id="Contrato" name="Contrato" value="1" required>
                </div>
                <div class="mb-3">
                    <label for="Servico" class="form-label">Serviço</label>
                    <input type="text" class="form-control" id="Servico" name="Servico" value="1203" required>
                </div>
                <div class="mb-3">
                    <label for="Insumo" class="form-label">Insumo</label>
                    <input type="text" class="form-control" id="Insumo" name="Insumo" value="12031" required>
                </div>
                <div class="mb-3">
                    <label for="MesPlanejamento" class="form-label">Mês Planejamento</label>
                    <input type="text" class="form-control datepicker" id="MesPlanejamento" name="MesPlanejamento" value="2025-01-30" required>
                </div>
                <div class="mb-3">
                    <label for="Quantidade" class="form-label">Quantidade</label>
                    <input type="text" class="form-control" id="Quantidade" name="Quantidade" value="1" required>
                </div>
                <div class="mb-3">
                    <label for="Preco" class="form-label">Preco</label>
                    <input type="text" class="form-control" id="Preco" name="Preco" value="10" required>
                </div>
            
                <button type="submit" class="btn btn-success">Finalizar</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script>



        // Inicializa o datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

        // Navegação entre as seções
        $('#next1').on('click', function() {
            $('#section1').removeClass('active');
            $('#section2').addClass('active');
        });

        $('#previous1').on('click', function() {
            $('#section2').removeClass('active');
            $('#section1').addClass('active');
        });

        $('#next2').on('click', function() {
            $('#section2').removeClass('active');
            $('#section3').addClass('active');
        });

        $('#previous2').on('click', function() {
            $('#section3').removeClass('active');
            $('#section2').addClass('active');
        });

        $('#next3').on('click', function() {
            $('#section3').removeClass('active');
            $('#section4').addClass('active');
        });

        $('#previous3').on('click', function() {
            $('#section4').removeClass('active');
            $('#section3').addClass('active');
        });

        

        
    </script>
    
</body>
</html>


