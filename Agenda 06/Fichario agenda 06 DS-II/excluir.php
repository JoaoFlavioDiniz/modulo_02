<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Excluir - MYSQLI - Agenda 06</title>
</head>
<body class="w3-light-grey">

<a href="index.php" class="w3-display-topmiddle w3-red w3-center w3-padding w3-button" style="text-decoration:none;">
    <i class="fa fa-ban" style="font-size:5em"></i>
    <p style="font-weight:bold;">CANCELAR EXCLUSÃO</p>     
</a> 

<div class="w3-padding w3-content w3-text-grey w3-third w3-margin w3-display-middle">
    <h1 class="w3-center w3-teal w3-round-large w3-margin">
        EXCLUIR - ID: <?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
    </h1>

    <form action="excluirAction.php" class="w3-container w3-white w3-card-4 w3-padding-12 w3-round" method="post">
        <!-- Campo oculto com o ID enviado para o excluirAction.php -->
        <input name="txtID" type="hidden" value="<?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        
        <label class="w3-text-teal" style="font-weight: bold;">Nome</label>
        <input name="txtNome" class="w3-input w3-border w3-sand" disabled 
            value="<?php echo htmlspecialchars($_GET['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label class="w3-text-teal" style="font-weight: bold;">Nota 1</label>
        <input name="txtNota1" class="w3-input w3-border w3-sand" disabled 
            value="<?php echo htmlspecialchars($_GET['nota1'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label class="w3-text-teal" style="font-weight: bold;">Nota 2</label>
        <input name="txtNota2" class="w3-input w3-border w3-sand" disabled 
            value="<?php echo htmlspecialchars($_GET['nota2'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label class="w3-text-teal" style="font-weight: bold;">Nota 3</label>
        <input name="txtNota3" class="w3-input w3-border w3-sand" disabled 
            value="<?php echo htmlspecialchars($_GET['nota3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label class="w3-text-teal" style="font-weight: bold;">Nota 4</label>
        <input name="txtNota4" class="w3-input w3-border w3-sand" disabled 
            value="<?php echo htmlspecialchars($_GET['nota4'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <button name="btnExcluir" type="submit" class="w3-button w3-teal w3-round-large w3-right">     
            <i class="fa fa-check"></i> Confirmar Exclusão
        </button>
    </form>
</div>

</body>
</html>