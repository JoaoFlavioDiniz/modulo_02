<?php
// Array bidimensional com os dados dos alunos e suas notas nos 4 bimestres
$alunos = [
    [
        'nome' => 'Ana Clara Santos',
        'notas' => [7.5, 8.0, 6.5, 9.0]
    ],
    [
        'nome' => 'Bruno Henrique Lima',
        'notas' => [5.0, 6.0, 4.5, 5.5]
    ],
    [
        'nome' => 'Camila Fernandes',
        'notas' => [8.5, 9.0, 8.0, 9.5]
    ],
    [
        'nome' => 'Diego Rodrigues',
        'notas' => [4.0, 3.5, 5.0, 6.0]
    ],
    [
        'nome' => 'Eduarda Martins',
        'notas' => [6.0, 7.0, 6.5, 6.0]
    ],
    [
        'nome' => 'João Rodrigues',
        'notas' => [7.0, 6.5, 8.0, 6.0]
    ],
    [
        'nome' => 'Flávio Diniz',
        'notas' => [6.0, 9.5, 5.0, 7.6]
    ],
    [
        'nome' => 'Ivo Rosa',
        'notas' => [8.0, 8.5, 5.0, 6.0]
    ],
    [
        'nome' => 'Manuel Messias',
        'notas' => [6.0, 4.5, 5.8, 6.7]
    ],
    [
        'nome' => 'Rosana Heloisa',
        'notas' => [6.0, 8.5, 9.0, 6.0]
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletim Escolar - 8º Ano A</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f8;
            margin: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 750px;
        }

        h1 {
            color: #1e293b;
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            padding: 12px;
            border: 1px solid #e2e8f0;
        }

        th {
            background-color: #0284c7;
            color: #ffffff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .nome-aluno {
            text-align: left;
            font-weight: 500;
        }

        /* Classes para destaque da média em*/
        .media-aprovado {
            color: #15803d;
            background-color: #dcfce7;
            font-weight: bold;
        }
        /* Classes para destaque da média em*/

        .media-reprovado {
            color: #b91c1c;
            background-color: #fee2e2;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Notas e Médias de alunos - 8º Ano A</h1>

    <table>
        <thead>
            <tr>
                <th>Aluno</th>
                <th>1º Bimestre</th>
                <th>2º Bimestre</th>
                <th>3º Bimestre</th>
                <th>4º Bimestre</th>
                <th>Média Final</th>
            </tr>
        </thead>
        <tbody>
            <?php
            /*
             * ESTRUTURAFOREACH:
             * A estrutura foreach percorre sequencialmente cada aluno cadastrado no array $alunos.
             * A cada volta do laço, ela extrai as notas dos 4 bimestres, calcula a média aritmética somando-as e 
             * dividindo pela quantidade, e gera automaticamente uma nova linha (<tr>) na tabela HTML.
             * Ela também aplica a classe CSS verde ou vermelha conforme o valor da média calculada.
             */
            foreach ($alunos as $aluno) {
                // Cálculo da média aritmética simples
                $soma = array_sum($aluno['notas']);
                $quantidade = count($aluno['notas']);
                $media = $soma / $quantidade;

                // Formatação com 1 casa decimal e vírgula
                $mediaFormatada = number_format($media, 1, ',', '.');

                // Define a classe CSS conforme a regra de destaque (>= 6,0 ou < 6,0)
                $classeDestaque = ($media >= 6.0) ? 'media-aprovado' : 'media-reprovado';
            ?>
                <tr>
                    <td class="nome-aluno"><?= htmlspecialchars($aluno['nome']); ?></td>
                    <td><?= number_format($aluno['notas'][0], 1, ',', '.'); ?></td>
                    <td><?= number_format($aluno['notas'][1], 1, ',', '.'); ?></td>
                    <td><?= number_format($aluno['notas'][2], 1, ',', '.'); ?></td>
                    <td><?= number_format($aluno['notas'][3], 1, ',', '.'); ?></td>
                    <td class="<?= $classeDestaque; ?>"><?= $mediaFormatada; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>