<?php

class Viagem
{
    private $origem;
    private $destino;
    private $distancia;
    private $tempo;
    private $consumo;
    private $precoCombustivel;

    public function __construct($origem, $destino, $distancia, $tempo, $consumo, $precoCombustivel)
    {
        $this->origem = $origem;
        $this->destino = $destino;
        $this->distancia = $distancia;
        $this->tempo = $tempo;
        $this->consumo = $consumo;
        $this->precoCombustivel = $precoCombustivel;
    }

    public function calcularVelocidadeMedia()
    {
        return $this->distancia / $this->tempo;
    }

    public function calcularConsumoEstimado()
    {
        return $this->distancia / $this->consumo;
    }

    public function calcularCustoViagem()
    {
        return $this->calcularConsumoEstimado() * $this->precoCombustivel;
    }
}

$resultado = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origem = $_POST['origem'];
    $destino = $_POST['destino'];
    $distancia = floatval($_POST['distancia']);
    $tempo = floatval($_POST['tempo']);
    $consumo = floatval($_POST['consumo']);
    $precoCombustivel = floatval($_POST['preco_combustivel']);

    $viagem = new Viagem($origem, $destino, $distancia, $tempo, $consumo, $precoCombustivel);

    $resultado = [
        'velocidade_media' => $viagem->calcularVelocidadeMedia(),
        'consumo_estimado' => $viagem->calcularConsumoEstimado(),
        'custo_viagem' => $viagem->calcularCustoViagem()
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Viagem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Calculadora de Viagem</h1>
    <form method="post">
        <label>Origem: <input type="text" name="origem" required></label><br>
        <label>Destino: <input type="text" name="destino" required></label><br>
        <label>Distância (km): <input type="number" step="0.1" name="distancia" required></label><br>
        <label>Tempo estimado (horas): <input type="number" step="0.1" name="tempo" required></label><br>
        <label>Consumo do veículo (km/l): <input type="number" step="0.1" name="consumo" required></label><br>
        <label>Preço do combustível (R$/l): <input type="number" step="0.01" name="preco_combustivel" required></label><br>
        <button type="submit">Calcular</button>
    </form>

    <?php if ($resultado): ?>
        <h2>Resultados</h2>
        <ul>
            <li>Velocidade média: <?= number_format($resultado['velocidade_media'], 2) ?> km/h</li>
            <li>Consumo estimado: <?= number_format($resultado['consumo_estimado'], 2) ?> litros</li>
            <li>Custo da viagem: R$ <?= number_format($resultado['custo_viagem'], 2, ',', '.') ?></li>
        </ul>
    <?php endif; ?>
</body>
</html>