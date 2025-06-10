<?php

class ConversorMoeda {
    public static function converter($valor, $cotacao, $moedaDestino) {
        if ($cotacao <= 0) {
            throw new Exception("Cotação inválida.");
        }
        $valorConvertido = $valor / $cotacao;
        switch ($moedaDestino) {
            case 'USD':
                return number_format($valorConvertido, 2, '.', ',');
            case 'EUR':
                return number_format($valorConvertido, 2, ',', '.');
            default:
                throw new Exception("Moeda não suportada.");
        }
    }
}

$resultado = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = floatval(str_replace(',', '.', $_POST['valor']));
    $cotacao = floatval(str_replace(',', '.', $_POST['cotacao']));
    $moedaDestino = $_POST['moeda'];

    try {
        $valorConvertido = ConversorMoeda::converter($valor, $cotacao, $moedaDestino);
        $simbolo = $moedaDestino === 'USD' ? 'US$' : '€';
        $resultado = "Valor convertido: {$simbolo} {$valorConvertido}";
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conversor de Moeda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Conversor de Moeda</h1>
    <form method="post">
        <label>Valor em Reais (R$): 
            <input type="text" name="valor" required>
        </label><br><br>
        <label>Moeda de destino:
            <select name="moeda" required>
                <option value="USD">Dólar (USD)</option>
                <option value="EUR">Euro (EUR)</option>
            </select>
        </label><br><br>
        <label>Cotação atual:
            <input type="text" name="cotacao" required>
        </label><br><br>
        <button type="submit">Converter</button>
    </form>
    <br>
    <?php if ($resultado): ?>
        <strong><?= $resultado ?></strong>
    <?php elseif ($erro): ?>
        <span style="color:red"><?= $erro ?></span>
    <?php endif; ?>
</body>
</html>