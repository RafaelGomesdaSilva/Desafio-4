<?php

class Aluno {
    public $nome;
    public $disciplina;
    public $notas = [];

    public function __construct($nome, $disciplina, $notas) {
        $this->nome = $nome;
        $this->disciplina = $disciplina;
        $this->notas = $notas;
    }

    public function calcularMedia() {
        return array_sum($this->notas) / count($this->notas);
    }

    public function situacao() {
        $media = $this->calcularMedia();
        if ($media >= 7) {
            return "Aprovado";
        } elseif ($media >= 5) {
            return "Recuperação";
        } else {
            return "Reprovado";
        }
    }
}

// Inicializa variáveis
$erro = "";
$resultado = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $disciplina = trim($_POST['disciplina'] ?? '');
    $nota1 = $_POST['nota1'] ?? '';
    $nota2 = $_POST['nota2'] ?? '';
    $nota3 = $_POST['nota3'] ?? '';

    // Validação simples
    if ($nome === '' || $disciplina === '' || $nota1 === '' || $nota2 === '' || $nota3 === '') {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!is_numeric($nota1) || !is_numeric($nota2) || !is_numeric($nota3)) {
        $erro = "As notas devem ser números.";
    } elseif ($nota1 < 0 || $nota1 > 10 || $nota2 < 0 || $nota2 > 10 || $nota3 < 0 || $nota3 > 10) {
        $erro = "As notas devem estar entre 0 e 10.";
    } else {
        $aluno = new Aluno($nome, $disciplina, [(float)$nota1, (float)$nota2, (float)$nota3]);
        $media = $aluno->calcularMedia();
        $situacao = $aluno->situacao();
        $resultado = "Aluno: <b>{$aluno->nome}</b><br>Disciplina: <b>{$aluno->disciplina}</b><br>Média: <b>" . number_format($media, 2) . "</b><br>Situação: <b>{$situacao}</b>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Aluno</h1>
    <?php if ($erro): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"></label><br><br>
        <label>Disciplina: <input type="text" name="disciplina" value="<?= htmlspecialchars($_POST['disciplina'] ?? '') ?>"></label><br><br>
        <label>Nota 1: <input type="number" name="nota1" min="0" max="10" step="0.01" value="<?= htmlspecialchars($_POST['nota1'] ?? '') ?>"></label><br><br>
        <label>Nota 2: <input type="number" name="nota2" min="0" max="10" step="0.01" value="<?= htmlspecialchars($_POST['nota2'] ?? '') ?>"></label><br><br>
        <label>Nota 3: <input type="number" name="nota3" min="0" max="10" step="0.01" value="<?= htmlspecialchars($_POST['nota3'] ?? '') ?>"></label><br><br>
        <button type="submit">Calcular</button>
    </form>
    <br>
    <?php if ($resultado): ?>
        <div style="border:1px solid #ccc; padding:10px;"><?= $resultado ?></div>
    <?php endif; ?>
</body>
</html>