<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora Financeira</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Simulador de Parcelamento</h2>
    <form method="post">
        Valor da compra: <input type="number" step="0.01" name="valor" required><br>
        Número de parcelas: <input type="number" name="parcelas" required><br>
        Taxa de juros mensal (%): <input type="number" step="0.01" name="juros" required><br>
        <button type="submit">Calcular</button>
    </form>
    <?php
    class CalculadoraFinanceira {
        private $valor;
        private $parcelas;
        private $juros;

        public function __construct($valor, $parcelas, $juros) {
            $this->valor = $valor;
            $this->parcelas = $parcelas;
            $this->juros = $juros / 100; // Converter para decimal
        }

        public function calcularParcela() {
            // Fórmula: parcela = valor * (1 + juro) ^ n / n
            $valorFuturo = $this->valor * pow(1 + $this->juros, $this->parcelas);
            return $valorFuturo / $this->parcelas;
        }

        public function calcularTotal() {
            return $this->calcularParcela() * $this->parcelas;
        }

        public function calcularJurosPagos() {
            return $this->calcularTotal() - $this->valor;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $valor = floatval($_POST['valor']);
        $parcelas = intval($_POST['parcelas']);
        $juros = floatval($_POST['juros']);

        $calc = new CalculadoraFinanceira($valor, $parcelas, $juros);

        $parcela = number_format($calc->calcularParcela(), 2, ',', '.');
        $total = number_format($calc->calcularTotal(), 2, ',', '.');
        $jurosPagos = number_format($calc->calcularJurosPagos(), 2, ',', '.');

        echo "<div class='resultados'>";
        echo "<h3>Resultados:</h3>";
        echo "Valor da parcela: R$ {$parcela}<br>";
        echo "Total a pagar: R$ {$total}<br>";
        echo "Juros pagos: R$ {$jurosPagos}<br>";
        echo "</div>";
    }
    ?>
</body>
</html>