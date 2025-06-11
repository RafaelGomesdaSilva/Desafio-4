<?php

class Pessoa {
    public $nome;
    public $peso;
    public $altura;

    public function __construct($nome, $peso, $altura) {
        $this->nome = $nome;
        $this->peso = $peso;
        $this->altura = $altura;
    }

    public function calcularIMC() {
        if ($this->altura <= 0) return 0;
        return $this->peso / ($this->altura * $this->altura);
    }

    public function classificarIMC() {
        $imc = $this->calcularIMC();
        if ($imc < 18.5) {
            return "Abaixo do peso";
        } elseif ($imc < 25) {
            return "Peso normal";
        } elseif ($imc < 30) {
            return "Sobrepeso";
        } else {
            return "Obesidade";
        }
    }
}

$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $peso = floatval($_POST['peso'] ?? 0);
    $altura = floatval($_POST['altura'] ?? 0);

    $pessoa = new Pessoa($nome, $peso, $altura);
    $imc = $pessoa->calcularIMC();
    $classificacao = $pessoa->classificarIMC();

    $mensagem = "Olá, {$pessoa->nome}! Seu IMC é " . number_format($imc, 2) . " ({$classificacao}).";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Calculadora de IMC</h1>
    <form method="post">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>Peso (kg): <input type="number" step="0.01" name="peso" required></label><br>
        <label>Altura (m): <input type="number" step="0.01" name="altura" required></label><br>
        <button type="submit">Calcular</button>
    </form>
    <?php if ($mensagem): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>
</body>
</html>