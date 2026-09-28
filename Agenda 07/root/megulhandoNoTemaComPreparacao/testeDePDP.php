<?php

if (extension_loaded('pdo_mysql')) {
    echo "PDO MySQL está ativado.";
} else {
    echo "PDO MySQL não está ativado.";
}

?>

<!--utilize este arquivo para testar o PDO. ele já vem habilitado descomentar 
a linha ;extension=pdo_mysql no arquivo PHP.ini acessar pelo pánel do xampp-->