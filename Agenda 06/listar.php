
<?php
/*
 * Sistema de Gestão de Alunos - Agenda 06 (Versão 2)
 * Arquivo: listar_alunos-v2.php
 * Descrição: Exibe os alunos concluintes com cálculo de média, 
 * campo de busca por nome e ordenação por ranking de notas.
 * Compatível com o padrão de conexão ($conexao) e componentes W3.CSS da Agenda 06.
 */

// 1. Conexão com o Banco de Dados
// Tenta reaproveitar a conexão existente 'conexaoBD.php' ou estabelece $conexao via MySQLi
if (file_exists('conexaoBD.php')) {
    include_once 'conexaoBD.php';
} else {
    $servername = "localhost";
    $username   = "root";
    $password   = "";        // Senha padrão local
    $dbname     = "pwii";    // Nome do banco de dados da disciplina (ou bd_agenda06)

    $conexao = new mysqli($servername, $username, $password, $dbname);

    if ($conexao->connect_error) {
        die("<div class='w3-panel w3-red'>Falha na conexão: " . $conexao->connect_error . "</div>");
    }
}

$conexao->set_charset("utf8");

// 2. Recebe o termo de pesquisa por nome (via GET)
$busca = isset($_GET['txtNome']) ? trim($_GET['txtNome']) : (isset($_GET['txtBusca']) ? trim($_GET['txtBusca']) : '');

// 3. Consulta SQL: Cálculo da Média e Ordenação por Ranking (ORDER BY media DESC)
if (!empty($busca)) {
    // Filtro por nome mantendo a ordenação das maiores médias no topo
    $sql = "SELECT idalunoconcluinte, nome, nota1, nota2, nota3, nota4, 
                ((nota1 + nota2 + nota3 + nota4) / 4) AS media 
            FROM alunoconcluinte 
            WHERE nome LIKE ? 
            ORDER BY media DESC";
            
    $stmt = $conexao->prepare($sql);
    $paramBusca = "%" . $busca . "%";
    $stmt->bind_param("s", $paramBusca);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    // Consulta geral ordenada diretamente pela média (Ranking)
    $sql = "SELECT idalunoconcluinte, nome, nota1, nota2, nota3, nota4, 
                ((nota1 + nota2 + nota3 + nota4) / 4) AS media 
            FROM alunoconcluinte 
            ORDER BY media DESC";
            
    $resultado = $conexao->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos e Ranking - Agenda 06</title>
    <!-- Estilos do W3.CSS e FontAwesome (mesmos links utilizados na Agenda 06) -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .pos-badge { display: inline-block; width: 28px; height: 28px; line-height: 28px; text-align: center; border-radius: 50%; font-weight: bold; }
        .gold { background-color: #ffd700; color: #333; }
        .silver { background-color: #c0c0c0; color: #333; }
        .bronze { background-color: #cd7f32; color: #fff; }
        .standard { background-color: #009688; color: #fff; }
    </style>
</head>
<body class="w3-light-grey">

<div class="w3-container w3-padding-32" style="max-width: 950px; margin: auto;">

    <!-- Cabeçalho Principal -->
    <div class="w3-card-4 w3-white w3-round-large w3-margin-bottom">
        <div class="w3-container w3-teal w3-round-large">
            <h2><i class="fa fa-trophy"></i> Ranking e Notas dos Alunos Concluintes</h2>
        </div>

        <!-- Campo de Pesquisa por Nome -->
        <div class="w3-container w3-padding-16">
            <form action="listar_alunos-v2.php" method="GET" class="w3-row-padding">
                <div class="w3-col m9 l10">
                    <label class="w3-text-teal" style="font-weight: bold;">Filtrar Aluno por Nome:</label>
                    <input name="txtNome" class="w3-input w3-light-grey w3-border w3-round" type="text" 
                        placeholder="Digite o nome do aluno..." value="<?php echo htmlspecialchars($busca); ?>">
                </div>
                <div class="w3-col m3 l2 w3-padding-top-24">
                    <button type="submit" class="w3-button w3-teal w3-block w3-round">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
            </form>

            <?php if (!empty($busca)): ?>
                <div class="w3-margin-top">
                    <span class="w3-tag w3-teal w3-round">
                        Filtro ativo: "<strong><?php echo htmlspecialchars($busca); ?></strong>"
                    </span>
                    <a href="listar_alunos-v2.php" class="w3-button w3-small w3-gray w3-round w3-margin-left">
                        <i class="fa fa-times"></i> Limpar Filtro
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabela de Alunos, Média e Ranking -->
    <div class="w3-card-4 w3-white w3-round-large w3-responsive">
        <table class="w3-table-all w3-hoverable w3-centered">
            <thead>
                <tr class="w3-teal">
                    <th>Posição</th>
                    <th>Nome do Aluno</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota 3</th>
                    <th>Nota 4</th>
                    <th>Média</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    $posicao = 1;
                    while ($linha = $resultado->fetch_assoc()) {
                        $id    = $linha['idalunoconcluinte'];
                        $nome  = $linha['nome'];
                        $n1    = $linha['nota1'];
                        $n2    = $linha['nota2'];
                        $n3    = $linha['nota3'];
                        $n4    = $linha['nota4'];
                        $media = $linha['media'];

                        // Medalhas de posição no ranking
                        if ($posicao == 1) {
                            $badge = "gold";
                        } elseif ($posicao == 2) {
                            $badge = "silver";
                        } elseif ($posicao == 3) {
                            $badge = "bronze";
                        } else {
                            $badge = "standard";
                        }

                        echo "<tr>";
                        echo "<td><span class='pos-badge {$badge}'>{$posicao}º</span></td>";
                        echo "<td class='w3-left-align' style='font-weight:bold;'>" . htmlspecialchars($nome) . "</td>";
                        echo "<td>" . number_format($n1, 1, ',', '.') . "</td>";
                        echo "<td>" . number_format($n2, 1, ',', '.') . "</td>";
                        echo "<td>" . number_format($n3, 1, ',', '.') . "</td>";
                        echo "<td>" . number_format($n4, 1, ',', '.') . "</td>";
                        echo "<td><strong class='w3-text-teal'>" . number_format($media, 2, ',', '.') . "</strong></td>";
                        echo "<td>
                                <a href='atualizar.php?id={$id}&nome=" . urlencode($nome) . "&nota1={$n1}&nota2={$n2}&nota3={$n3}&nota4={$n4}' class='w3-button w3-small w3-teal w3-round' title='Editar'>
                                    <i class='fa fa-refresh'></i>
                                </a>
                                <a href='excluir.php?id={$id}&nome=" . urlencode($nome) . "' class='w3-button w3-small w3-red w3-round' title='Excluir'>
                                    <i class='fa fa-trash'></i>
                                </a>
                            </td>";
                        echo "</tr>";

                        $posicao++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='w3-padding-16 w3-text-red'>Nenhum aluno encontrado no banco de dados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Navegação e Ações -->
    <div class="w3-margin-top w3-center">
        <a href="cadastro.php" class="w3-button w3-teal w3-round-large"><i class="fa fa-plus-circle"></i> Cadastrar Aluno</a>
        <a href="index.php" class="w3-button w3-gray w3-round-large w3-margin-left"><i class="fa fa-home"></i> Início</a>
    </div>

</div>

</body>
</html>

<?php
// Encerra a conexão conforme o padrão dos scripts da Agenda 06
$conexao->close();
?>
