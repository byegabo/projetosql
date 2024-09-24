<?php 

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "cadastro_produtos";

$conn = new mysqli($servidor, $usuario, $senha, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);

}

?>