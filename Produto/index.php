<?php

class Produto {
    private $nome;
    private $quantidade;
    private $valorUnitario;

    public function __construct($nome, $quantidade, $valorUnitario) {
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->valorUnitario = $valorUnitario;
    }

    public function entradaEstoque($qtd) {
        $this->quantidade += $qtd;
    }

    public function saidaEstoque($qtd) {
        if ($qtd > $this->quantidade) {
            return false;
        }
        $this->quantidade -= $qtd;
        return true;
    }

    public function valorTotalEstoque() {
        return $this->quantidade * $this->valorUnitario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getValorUnitario() {
        return $this->valorUnitario;
    }
}

// Inicialização do produto (poderia ser dinâmico, mas fixo para exemplo)
session_start();
if (!isset($_SESSION['produto'])) {
    $_SESSION['produto'] = serialize(new Produto("Produto Exemplo", 10, 50.00));
}
$produto = unserialize($_SESSION['produto']);
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo']) && isset($_POST['quantidade'])) {
        $qtd = intval($_POST['quantidade']);
        if ($_POST['tipo'] === 'entrada') {
            $produto->entradaEstoque($qtd);
            $msg = "Entrada realizada com sucesso!";
        } elseif ($_POST['tipo'] === 'saida') {
            if ($produto->saidaEstoque($qtd)) {
                $msg = "Saída realizada com sucesso!";
            } else {
                $msg = "Quantidade insuficiente em estoque!";
            }
        }
        $_SESSION['produto'] = serialize($produto);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Simulação de Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Produto: <?php echo htmlspecialchars($produto->getNome()); ?></h1>
    <p>Quantidade em estoque: <?php echo $produto->getQuantidade(); ?></p>
    <p>Valor unitário: R$ <?php echo number_format($produto->getValorUnitario(), 2, ',', '.'); ?></p>
    <p>Valor total em estoque: R$ <?php echo number_format($produto->valorTotalEstoque(), 2, ',', '.'); ?></p>
    <?php if ($msg): ?>
        <p><strong><?php echo $msg; ?></strong></p>
    <?php endif; ?>
    <form method="post">
        <label>
            Tipo de movimentação:
            <select name="tipo">
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
            </select>
        </label>
        <br>
        <label>
            Quantidade:
            <input type="number" name="quantidade" min="1" required>
        </label>
        <br>
        <button type="submit">Realizar Movimentação</button>
    </form>
</body>
</html>