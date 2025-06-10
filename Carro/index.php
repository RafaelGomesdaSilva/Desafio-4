<?php

class Carro {
    private $modelo;
    private $combustivel;
    private $tanque;
    private $consumo;
    private $kmRodados;
    private $precoCombustivel;

    public function __construct($modelo, $combustivel, $tanque, $consumo, $kmRodados, $precoCombustivel) {
        $this->modelo = $modelo;
        $this->combustivel = $combustivel;
        $this->tanque = $tanque;
        $this->consumo = $consumo;
        $this->kmRodados = $kmRodados;
        $this->precoCombustivel = $precoCombustivel;
    }

    public function calcularAutonomia() {
        return $this->tanque * $this->consumo;
    }

    public function calcularCustoPorKm() {
        if ($this->consumo == 0) return 0;
        return $this->precoCombustivel / $this->consumo;
    }

    public function precisaRevisao() {
        // Exemplo: revisão a cada 10.000 km
        return $this->kmRodados >= 10000;
    }
}

$resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['modelo'];
    $combustivel = $_POST['combustivel'];
    $tanque = floatval($_POST['tanque']);
    $consumo = floatval($_POST['consumo']);
    $kmRodados = floatval($_POST['km_rodados']);
    $precoCombustivel = floatval($_POST['preco_combustivel']);

    $carro = new Carro($modelo, $combustivel, $tanque, $consumo, $kmRodados, $precoCombustivel);

    $autonomia = $carro->calcularAutonomia();
    $custoPorKm = $carro->calcularCustoPorKm();
    $revisao = $carro->precisaRevisao() ? 'Sim' : 'Não';

    $resultado = "
        <h2>Resultados</h2>
        <ul>
            <li>Autonomia: {$autonomia} km</li>
            <li>Custo por km: R$ " . number_format($custoPorKm, 2, ',', '.') . "</li>
            <li>Hora da revisão? {$revisao}</li>
        </ul>
    ";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Carro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Informações do Carro</h1>
    <form method="post">
        <label>Modelo: <input type="text" name="modelo" required></label><br>
        <label>Combustível:
            <select name="combustivel" required>
                <option value="etanol">Etanol</option>
                <option value="gasolina">Gasolina</option>
            </select>
        </label><br>
        <label>Tanque cheio (litros): <input type="number" step="0.1" name="tanque" required></label><br>
        <label>Consumo (km/l): <input type="number" step="0.1" name="consumo" required></label><br>
        <label>Km rodados: <input type="number" step="1" name="km_rodados" required></label><br>
        <label>Preço do combustível (R$): <input type="number" step="0.01" name="preco_combustivel" required></label><br>
        <button type="submit">Calcular</button>
    </form>
    <?php if ($resultado) echo $resultado; ?>
</body>
</html>