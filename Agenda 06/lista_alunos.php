<?php
/*
 * Sistema de Gestão de Alunos - Agenda 06
 * Arquivo: listar_alunos.php
 * Descrição: Conecta ao banco de dados, exibe a tabela de alunos, calcula a média,
 * permite busca por nome e ordena os alunos pelo ranking de média.
 */

// 1. Configurações de Conexão com o Banco de Dados (MySQLi)
$host    = "localhost";
$usuario = "root";
$senha   = "";
$banco   = "bd_agenda06";

$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica erro de conexão
if ($conexao->connect_error) {
    die("<div class='w3-panel w3-red'>Erro na conexão com o banco de dados: " . htmlspecialchars($conexao->connect_error) . "</div>");
}

// utf8mb4 cobre acentuação completa e caracteres modernos
$conexao->set_charset("utf8mb4");

// 2. Leitura do Campo de Pesquisa por Nome
$busca = isset($_GET['txtBusca']) ? trim($_GET['txtBusca']) : '';

// 3. Consulta SQL: Cálculo da Média com COALESCE (evita erro com valores nulos)
$calculoMedia = "((COALESCE(nota1, 0) + COALESCE(nota2, 0) + COALESCE(nota3, 0) + COALESCE(nota4, 0)) / 4)";

if (!empty($busca)) {
    // Filtro seguro contra SQL Injection
    $sql = "SELECT idalunoconcluinte, nome, nota1, nota2, nota3, nota4, 
                   {$calculoMedia} AS media 
            FROM alunoconcluinte 
            WHERE nome LIKE ? 
            ORDER BY media DESC";
            
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $paramBusca = "%" . $busca . "%";
        $stmt->bind_param("s", $paramBusca);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } else {
        $resultado = false;
    }
} else {
    // Consulta direta sem filtro
    $sql = "SELECT idalunoconcluinte, nome, nota1, nota2, nota3, nota4, 
                   {$calculoMedia} AS media 
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
    <title>Ranking de Alunos - Agenda 06</title>
    <!-- Framework W3.CSS e FontAwesome -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .badge-pos { display: inline-block; width: 30px; height: 30px; line-height: 30px; text-align: center; border-radius: 50%; color: white; font-weight: bold; }
        .gold { background-color: #ffd700; color: #333; }
        .silver { background-color: #c0c0c0; color: #333; }
        .bronze { background-color: #cd7f32; color: white; }
        .other { background-color: #009688; color: white; }
    </style>
</head>
<body class="w3-light-grey">

<div class="w3-container w3-padding-32" style="max-width: 1000px; margin: auto;">

    <!-- Cabeçalho e Painel de Busca -->
    <div class="w3-card-4 w3-white w3-round-large w3-margin-bottom">
        <div class="w3-container w3-teal w3-round-large">
            <h2><i class="fa fa-trophy"></i> Ranking e Lista de Alunos Concluintes</h2>
        </div>

        <!-- Formulário de Pesquisa -->
        <div class="w3-container w3-padding-16">
            <form action="listar_alunos.php" method="GET" class="w3-row-padding">
                <div class="w3-col m9 l10">
                    <label class="w3-text-teal" style="font-weight: bold;">Pesquisar Aluno por Nome:</label>
                    <input class="w3-input w3-border w3-round" type="text" name="txtBusca" 
                           placeholder="Digite o nome do aluno..." value="<?php echo htmlspecialchars($busca, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="w3-col m3 l2 w3-padding-top-24">
                    <button type="submit" class="w3-button w3-teal w3-block w3-round">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
            </form>
            
            <?php if (!empty($busca)): ?>
                <div class="w3-margin-top">
                    <span class="w3-tag w3-light-blue w3-round">
                        Exibindo resultados para: "<strong><?php echo htmlspecialchars($busca, ENT_QUOTES, 'UTF-8'); ?></strong>"
                    </span>
                    <a href="listar_alunos.php" class="w3-button w3-small w3-gray w3-round w3-margin-left">
                        <i class="fa fa-times"></i> Limpar Filtro
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabela de Alunos e Ranking -->
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
                    <th>Média Final</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    $posicao = 1;
                    while ($linha = $resultado->fetch_assoc()) {
                        $mediaValor = (float) $linha['media'];
                        $mediaFormatada = number_format($mediaValor, 2, ',', '.');

                        // Medalhas do Ranking
                        if ($posicao == 1) {
                            $badgeClass = "gold";
                        } elseif ($posicao == 2) {
                            $badgeClass = "silver";
                        } elseif ($posicao == 3) {
                            $badgeClass = "bronze";
                        } else {
                            $badgeClass = "other";
                        }

                        // Status do aluno
                        if ($mediaValor >= 7.0) {
                            $statusTag = "<span class='w3-tag w3-green w3-round'>Aprovado</span>";
                        } elseif ($mediaValor >= 5.0) {
                            $statusTag = "<span class='w3-tag w3-orange w3-text-white w3-round'>Recuperação</span>";
                        } else {
                            $statusTag = "<span class='w3-tag w3-red w3-round'>Reprovado</span>";
                        }

                        echo "<tr>";
                        echo "<td><span class='badge-pos {$badgeClass}'>{$posicao}º</span></td>";
                        echo "<td class='w3-left-align' style='font-weight:bold;'>" . htmlspecialchars($linha['nome'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . number_format((float)$linha['nota1'], 1, ',', '.') . "</td>";
                        echo "<td>" . number_format((float)$linha['nota2'], 1, ',', '.') . "</td>";
                        echo "<td>" . number_format((float)$linha['nota3'], 1, ',', '.') . "</td>";
                        echo "<td>" . number_format((float)$linha['nota4'], 1, ',', '.') . "</td>";
                        echo "<td><strong class='w3-text-teal'>{$mediaFormatada}</strong></td>";
                        echo "<td>{$statusTag}</td>";
                        echo "</tr>";

                        $posicao++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='w3-padding-16 w3-text-red'>Nenhum aluno encontrado.</td></tr>";
                }

                // Libera recursos e fecha statements
                if (isset($stmt) && $stmt) {
                    $stmt->close();
                }
                $conexao->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Navegação -->
    <div class="w3-margin-top w3-center">
        <a href="cadastro.php" class="w3-button w3-teal w3-round-large"><i class="fa fa-plus-circle"></i> Cadastrar Novo Aluno</a>
        <a href="index.php" class="w3-button w3-gray w3-round-large w3-margin-left"><i class="fa fa-home"></i> Voltar</a>
    </div>

</div>

</body>
</html>