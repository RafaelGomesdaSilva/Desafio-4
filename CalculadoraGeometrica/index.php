<?php
require_once 'Classe.php';

$resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['figura'];
    $medidas = [];

    switch ($tipo) {
        case 'quadrado':
            $medidas['lado'] = $_POST['lado'];
            break;

        case 'retangulo':
            $medidas['base'] = $_POST['base'];
            $medidas['altura'] = $_POST['altura'];
            break;

        case 'circulo':
            $medidas['raio'] = $_POST['raio'];
            break;
    }

    try {
        $figura = new FiguraGeometrica($tipo, $medidas);
        $area = $figura->calcularArea();
        $resultado = "Figura: " . $figura->getTipo() . " | Área: {$area}";
    } catch (Exception $e) {
        $resultado = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cálculo de Área</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function mostrarCampos() {
            const figura = document.getElementById("figura").value;
            document.getElementById("quadrado").style.display = "none";
            document.getElementById("retangulo").style.display = "none";
            document.getElementById("circulo").style.display = "none";

            document.getElementById(figura).style.display = "block";
        }
    </script>
</head>
<body>
    <h1>Calcular Área da Figura</h1>
    <form method="POST">
        <label for="figura">Escolha a figura:</label>
        <select name="figura" id="figura" onchange="mostrarCampos()" required>
            <option value="">-- Selecione --</option>
            <option value="quadrado">Quadrado</option>
            <option value="retangulo">Retângulo</option>
            <option value="circulo">Círculo</option>
        </select>

        <div id="quadrado" style="display:none;">
            <label>Lado: <input type="number" step="any" name="lado" required></label>
        </div>

        <div id="retangulo" style="display:none;">
            <label>Base: <input type="number" step="any" name="base" required></label>
            <label>Altura: <input type="number" step="any" name="altura" required></label>
        </div>

        <div id="circulo" style="display:none;">
            <label>Raio: <input type="number" step="any" name="raio" required></label>
        </div>

        <br>
        <button type="submit">Calcular</button>
    </form>

    <h2><?= $resultado ?></h2>
</body>
</html>
