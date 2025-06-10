<?php

class Pedido {
    private $nomeProduto;
    private $quantidade;
    private $precoUnitario;
    private $tipoCliente;

    public function __construct($nomeProduto, $quantidade, $precoUnitario, $tipoCliente) {
        $this->nomeProduto = $nomeProduto;
        $this->quantidade = $quantidade;
        $this->precoUnitario = $precoUnitario;
        $this->tipoCliente = $tipoCliente;
    }

    public function calcularTotalBruto() {
        return $this->quantidade * $this->precoUnitario;
    }

    public function calcularDesconto() {
        if (strtolower($this->tipoCliente) === 'premium') {
            return $this->calcularTotalBruto() * 0.10;
        }
        return 0;
    }

    public function calcularImposto() {
        return ($this->calcularTotalBruto() - $this->calcularDesconto()) * 0.08;
    }

    public function calcularTotalFinal() {
        return $this->calcularTotalBruto() - $this->calcularDesconto() + $this->calcularImposto();
    }
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto = $_POST['nome_produto'] ?? '';
    $quantidade = (int) ($_POST['quantidade'] ?? 0);
    $precoUnitario = (float) ($_POST['preco_unitario'] ?? 0);
    $tipoCliente = $_POST['tipo_cliente'] ?? 'normal';

    $pedido = new Pedido($nomeProduto, $quantidade, $precoUnitario, $tipoCliente);

    $totalBruto = number_format($pedido->calcularTotalBruto(), 2, ',', '.');
    $desconto = number_format($pedido->calcularDesconto(), 2, ',', '.');
    $imposto = number_format($pedido->calcularImposto(), 2, ',', '.');
    $totalFinal = number_format($pedido->calcularTotalFinal(), 2, ',', '.');

    $mensagem = "
        <h3>Resumo do Pedido</h3>
        <ul>
            <li><strong>Produto:</strong> {$nomeProduto}</li>
            <li><strong>Quantidade:</strong> {$quantidade}</li>
            <li><strong>Preço Unitário:</strong> R$ {$precoUnitario}</li>
            <li><strong>Total Bruto:</strong> R$ {$totalBruto}</li>
            <li><strong>Desconto:</strong> R$ {$desconto}</li>
            <li><strong>Imposto:</strong> R$ {$imposto}</li>
            <li><strong>Total Final:</strong> R$ {$totalFinal}</li>
        </ul>
    ";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedido</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Formulário de Pedido</h2>
    <form method="post">
        <label>Nome do Produto: <input type="text" name="nome_produto" required></label><br><br>
        <label>Quantidade: <input type="number" name="quantidade" min="1" required></label><br><br>
        <label>Preço Unitário: <input type="number" name="preco_unitario" step="0.01" min="0" required></label><br><br>
        <label>Tipo de Cliente:
            <select name="tipo_cliente">
                <option value="normal">Normal</option>
                <option value="premium">Premium</option>
            </select>
        </label><br><br>
        <button type="submit">Calcular</button>
    </form>
    <br>
    <?php if ($mensagem) echo $mensagem; ?>
</body>
</html>