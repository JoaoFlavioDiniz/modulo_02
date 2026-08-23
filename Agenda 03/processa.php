<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Processamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="card-container">
        <header class="card-header">
            <h2>Status da Venda</h2>
        </header>

<?php
//código fornecido na atividade da agenda 03
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["txtNome"];
    $valorCompra = $_POST["txtValorCompra"];
    $formaPagamento = $_POST["cmbPag"];
    $desconto = 0;
    $valorTotalPago = 0;
        
    // ERRO: cálculo incorreto para boleto e depósito
    //Os erros foram corrigidos e comentados
    if ($formaPagamento == "cartaoCredito") {
        $desconto = 0;
        $mensagem = "Olá $nome, sua compra de R$ $valorCompra foi realizada com cartão de crédito. <br> Não há desconto.";
        
    } elseif ($formaPagamento == "boleto") {
        $desconto = $valorCompra * 0.08; // ERRO: deveria ser 8% para boleto - (erro corrigido)
        $mensagem = "Olá $nome, sua compra de R$ $valorCompra foi realizada com boleto.<br> Seu desconto é de R$ $desconto.";
        
        } elseif ($formaPagamento == "deposito") {
        $desconto = $valorCompra * 0.1; // ERRO: deveria ser 10% para depósito - (erro corrido)
        $mensagem = "Olá $nome, sua compra de R$ $valorCompra foi realizada com depósito.<br> Seu desconto é de R$ $desconto.";
    
        } else {
        $mensagem = "Forma de pagamento inválida.";
    }
//Verifica se a variável $mensagem possui algum valor e resgata este valor
    if (isset($mensagem)) {
        // Subtrai o desconto do valor original para apresentar o valor pago
        $valorTotalPago = $valorCompra - $desconto;//Pula um alinha e apresenta o valor total pago no prod.
        $mensagem .= "<br><strong>O valor total pago foi: R$ " . number_format($valorTotalPago, 2, ',', '.') . "</strong>";
    }

    // ERRO: mensagem final não mostra valor com desconto
    echo "<div class='w3-panel w3-green'>$mensagem</div>";
}
?>
<!-- Retorna a pagina anterior -->
        <a href="formulario.html" class="btn-voltar">Nova Compra</a>
    </main>
<!-- a primeira coisa que fiz foi verificar o valor das porcentagens e percebi o aviso de erro, percebi que 
 os valores de 10% e 8% estavam invertidos. Depois de fazer a carreção criei um arquivo html básico e coloquei
 o código ha tag body. Declarei uma nova variável $valorTotalPago e atribui um valor nela como zero. 
 Para exibir as mensagens eu busquei no video síncrono desta semana o comando "isset" da variável imagem,
 eu estava tentando usar de forma incorreta, consultei a IA para ver o melhor jeito de colocar para que
 a mensagem aparecesse em todas as opções e assim adicionei no final, assim as variáveis já estariam com
 o valor atribuido nas etapas anteriores. Professor, não sei se precisava declarar a variável $valorTotalPago
 setando-a como zero, por isso eu segui o exemplo da variável $desconto. -->
</body>
</html>