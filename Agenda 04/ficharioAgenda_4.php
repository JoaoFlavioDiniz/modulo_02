<?php

// Array com a lista de notas dos alunos
$estudantes = [
    ["nome" => "Lucas Silva", "nota" => 8.5],
    ["nome" => "Beatriz Santos", "nota" => 5.0],
    ["nome" => "Carlos Eduardo", "nota" => 7.2],
    ["nome" => "Daniela Lima", "nota" => 4.8],
    ["nome" => "Eduardo Rocha", "nota" => 9.0]
];

// Funções com parâmetros e retornos como os tipos (tipado)
function verificarAprovacao(float $nota, float $mediaMinima = 6.0): string {
    return $nota >= $mediaMinima ? "<b>Aprovado</b>" : "<b>Em Recuperação</b>";
}

function calcularMediaGeral(array $alunos): float {
    $soma = 0;
    // Uso do laço FOREACH para iterar sobre o Array com as notas dos alunos
    foreach ($alunos as $aluno) {
        $soma += $aluno["nota"];
    }
    return round($soma / count($alunos), 2);
}

function listarRecuperacao(array $alunos, float $corte = 6.0): void {
    echo "<b>Alunos que precisam de recuperação:\n</b><br>";
    $i = 0;
    // Uso do laço WHILE com contador manual
    while ($i < count($alunos)) {
        if ($alunos[$i]["nota"] < $corte) {
            echo "- {$alunos[$i]['nome']} (Nota: {$alunos[$i]['nota']})\n<br>";
        }
        $i++;
    }
}

// Exibição e execução

echo "<br>\***   RELATÓRIO INDIVIDUAL  ***/\n<br>";
// Uso do laço FOR tradicional para percorrer posições por índice numérico
$totalAlunos = count($estudantes);
for ($i = 0; $i < $totalAlunos; $i++) {
    $nome = $estudantes[$i]["nome"];
    $nota = $estudantes[$i]["nota"];
    $status = verificarAprovacao($nota);
    
    echo ($i + 1) . ". {$nome} | Nota: {$nota} | Situação: {$status}\n<br>";
}

echo "<br>\n\***   ESTATÍSTICAS DA TURMA   ***/\n<br>";
$media = calcularMediaGeral($estudantes);
echo "<b>Média geral da turma de alunos: {$media}\n\n</b><br>";

listarRecuperacao($estudantes);