<?php
//receber todos os dados enviados pelo formulário e armazena os dados na variáveis
$nomeCompleto = $_POST['nomeCompleto'];
$idade = $_POST['idade'];
$profissao = $_POST['profissao'];
$salarioPretendido = $_POST['salarioPretendido'];
$ExperienciaAnterior = $_POST['ExperienciaAnterior'];

//apresentar cada informação em uma linha 
echo "<center><b>Nome Completo: </b>".$_POST['nomeCompleto']."<br></center>";
echo "<center><b>Idade: </b> ".$_POST['idade']."<br></center>";
echo "<center><b>Profissao: </b>".$_POST['profissao']."<br></center>";
echo "<center><b>Salario Pretendido: R$ </b>".$_POST['salarioPretendido']."<br></center>";
echo "<center><b>Experiencia Anterior: </b>" .$_POST['ExperienciaAnterior']."<br><br></center>";

echo "<center>O colaborador <b> $nomeCompleto </b> foi cadastrado com a profissão de <b> $profissao </b>, e sua experiência anterior foi: <b> $ExperienciaAnterior <br><br></center>"

?>
<!-- retorna ao formulário ou pagina anterior -->
<div>
<center>
<button type="button" onclick="window.history.back()">
    Voltar ao formulário
</button>
</center>
</div>